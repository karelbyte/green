<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Mail\AlertLandscape;
use App\Models\Calendar;
use App\Models\CGlobal\CGlobal;
use App\Models\CGlobal\CGlobalInfo;
use App\Models\Client;
use App\Models\Company;
use App\Models\ProductOffereds\ProductOffereds;
use App\Models\ProductOffereds\ProductOfferedsDetails;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use App\Models\ServicesOffereds\ServiceOffereds;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
use App\Models\TypeCompromise;
use App\Models\TypeContact;
use App\Models\TypeInfo;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GenerateID;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;


class CGlobalsController extends Controller
{
    use GenerateID;

    protected  $sql = 'drop';

    public function index($status=0, $id=0)
    {
        return view('pages.cags.list', ['status' => $status, 'user_id' => $id]);
    }

    public function getCglobals() {

        return CGlobal::all();

    }

    public function sendID () {

        return $this->getID('cglobals');
    }

    public function getListFilter(Request $request) {

       // $filter = $request->fil;

        $datos = CGlobal::with(['MotiveServices', 'MotiveProducts', 'documents', 'landscaper', 'compromise','contact',
            'attended', 'client', 'status', 'info' => function($q) {
                $q->with('info', 'info_det');
            }])->leftJoin('clients', 'clients.id', 'cglobals.client_id')
            ->wherein('cglobals.id', $request->fil)
            ->select('cglobals.*')->get();


        $result = [

            'list' =>   $datos,

            'clients' => Client::query()->select('id', 'name')->get(),

            'type_contacts' => TypeContact::query()->select('id', 'name')->get(),

            'type_infos' => TypeInfo::with('detail')->get(),

            'landscapers' => User::query()->where('position_id', 3)->select('uid', 'name')->get(),

            'servicesOffereds' => ServiceOffereds::all(),

            'productsOffereds' => ProductOffereds::all()

        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);

    }

    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = CGlobal::with(['MotiveServices', 'MotiveProducts', 'documents', 'landscaper', 'compromise','contact',
           'attended', 'client', 'status', 'info' => function($q) {
            $q->with('info', 'info_det');
        }])->leftJoin('clients', 'clients.id', 'cglobals.client_id');

        if ( (int) $user->position_id !== 1) {

            $datos->where('user_id', $request->user_id_auth);
        }

        if ( $filters['value'] !== null) {

            if  ($filters['type'] === 'int') {

                $datos->where( $filters['field'], $filters['value']);

            } else {
                $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');
            }
        }

        if ( array_key_exists('user_id', $filters)) {
         if  ($filters['user_id'] !== 0) {
             $datos->where( 'user_id',  $filters['user_id'] );
         }
        }

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('cglobals.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'clients' => Client::query()->select('id', 'name')->get(),

            'type_contacts' => TypeContact::query()->select('id', 'name')->get(),

            'type_infos' => TypeInfo::with('detail')->get(),

            'landscapers' => User::query()->where('position_id', 3)->select('uid', 'name')->get(),

            'servicesOffereds' => ServiceOffereds::all(),

            'productsOffereds' => ProductOffereds::all()

        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);

    }

    // CREANDO CICLO DE ATENCION GLOBAL
    public function store(Request $request) {
       $data = $request->all();
       $status = 0;
       switch ($data['type_compromise_id']) {
           case TypeCompromise::QUOTE_HOME:
               $status = 1;
               break;
           case TypeCompromise::QUOTE_DISTANCE:
               $status = 18;
               break;
           case TypeCompromise::SALE_NOTE:
               $status = 3;
               break;
           case TypeCompromise::INFO_SEND:
               $status = Carbon::parse($data['documents']['moment'])->day === Carbon::now()->day ? 17 : 16;
               break;
       }

       $cg = CGlobal::query()->create([
           'moment' => $data['moment'],
           'emit' => Carbon::now(),
           'client_id' => $data['client']['id'],
           'user_id' => $data['user_id'],
           'type_contact_id' => $data['type_contact_id'],
           'repeater' => $data['repeater'],
           'type_compromise_id' => $data['type_compromise_id'],
           'type_motive' => $data['type_motive'],
           'type_motive_id' => $data['type_motive_id'],
           'required_time' => $data['required_time'],
           'traser' => 1,
           'note' => $data['note'],
           'status_id' => $status
       ]);

       $this->setID('cglobals', $cg->id);

       foreach ($data['info'] as $inf) {
           CGlobalInfo::query()->create([
               'cglobal_id' => $cg->id,
               'type_info_id' => $inf['info']['id'],
               'type_info_detail_id' => $inf['info_det']['id'],
               'info_descrip' => $inf['info_descrip']
           ]);
       }

       // CREANDO COTIZACION A DOMICILIO

        $client = Client::query()->find($data['client']['id']);

       if ($data['type_compromise_id'] === TypeCompromise::QUOTE_HOME) {

           $cg->LandScaper()->create($data['landscaper']);

           $user_email = User::query()->where('uid', $data['landscaper']['user_uid'])->first();

           $generador = User::query()->where('id', $data['user_id'])->first();

           $data_email = [
               'user' => $user_email,
               'generador' =>  $generador->name,
               'visit' => $data['landscaper'],
               'client' => $client,
               'company' => Company::query()->find(1),
           ];
           // ENVIANDO ALERTA A PAISAJISTA
          //  SendMails::dispatch(new AlertLandscape($data_email), $user_email->email);
           Mail::to($user_email->email)->send(new AlertLandscape($data_email));

           Calendar::query()->create([
               'cglobal_id' => $cg->id,
               'user_id' => $data['user_id'],
               'for_user_id' => 0,
               'start' => Carbon::parse($data['landscaper']['moment'] . ' '.$data['landscaper']['timer']),
               'end' => Carbon::parse($data['landscaper']['moment'] . ' '.$data['landscaper']['timer'])->addHours(2),
               'title' => 'Visita a cliente: ' .  $client->name ,
               'contentFull' => 'DOMICILIO: ' . $client->street . ' '. $client->home_number . ' '. $client->colony .  '  /  NOTA: '.  $data['landscaper']['note'],
               'class' => 'domicilio'
           ]);

           Quote::query()->create([
               'cglobal_id' => $cg->id,
               'type_quote_id' => 1,
               'token' => random_int(0,99999),
               'moment' => Carbon::now(),
               'emit' => Carbon::now(),
               'status_id' => 1,
           ]);

           return response()->json('Se generó un evento de visita en el calendario y se informo al paisajista!');
        }


        if ($data['type_compromise_id'] === TypeCompromise::INFO_SEND) {

            $cg->Documents()->create($data['documents']);

            Calendar::query()->create([
                'cglobal_id' => $cg->id,
                'user_id' => $data['user_id'],
                'for_user_id' => 0,
                'start' => Carbon::parse($data['documents']['moment'] . ' 8:00'),
                'end' => Carbon::parse($data['documents']['moment'] . ' 18:00'),
                'allDay' => 1,
                'contentFull' => ' DOMICILIO: ' . $client->street . ' '. $client->home_number . ' '. $client->colony,
                'title' => 'Información a: ' .$client->name ,
                'class' => 'info'
            ]);

            return response()->json('Se generó un evento de envio de información a cliente!');
        }

        if ($data['type_compromise_id'] === TypeCompromise::SALE_NOTE) {

          $sale = SalesNote::create([
                'global_id' => $cg->id,
                'moment' => Carbon::now(),
                'emit' => Carbon::now(),
                'advance' => 0,
                'origin' => SalesNote::ORIGIN_CAG,
                'status_id' => 3,
            ]);

           return response()->json(['id'=>$sale->id]);
        }

        if ($data['type_compromise_id'] === TypeCompromise::QUOTE_DISTANCE) {
            $quote =  Quote::query()->create([
                'cglobal_id' => $cg->id,
                'type_quote_id' => 2,
                'token' => mt_rand(0,99999),
                'moment' => Carbon::now(),
                'emit' => Carbon::now(),
                'status_id' => 2,
            ]);
            return response()->json(['id'=>$quote->id]);
        }


    }

    public function update(Request $request, $id) {

        $data = $request->all();

        $cg = CGlobal::query()->find($id);

        $status = 0;
        switch ($data['type_compromise_id']) {
            case TypeCompromise::QUOTE_HOME:
                $status = 1;
                break;
            case TypeCompromise::QUOTE_DISTANCE:
                $status = 18;
                break;
            case TypeCompromise::SALE_NOTE:
                $status = 3;
                break;
            case TypeCompromise::INFO_SEND:
                $status = Carbon::parse($data['documents']['moment'])->day === Carbon::now()->day ? 17 : 16;
                break;
        }

        $cg->update([
            'type_contact_id' => $data['type_contact_id'],
            'repeater' => $data['repeater'],
            'type_compromise_id' => $data['type_compromise_id'],
            'type_motive' => $data['type_motive'],
            'type_motive_id' => $data['type_motive_id'],
            'required_time' => $data['required_time'],
            'note' => $data['note'],
            'status_id' => $status
        ]);

        $user_email = User::query()->where('uid', $data['landscaper']['user_uid'])->first();

        $client = Client::query()->find($data['client']['id']);

        $data_email = [
            'user' => $user_email,
            'visit' => $data['landscaper'],
            'client' => $client,
            'company' => Company::query()->find(1),
        ];

        // CREANDO COTIZACION A DOMICILIO

        $cg->LandScaper()->delete();

        $cg->Documents()->delete();

        Calendar::query()->where('cglobal_id', $cg->id)->delete();

        Quote::query()->where('cglobal_id', $cg->id)->delete();

        SalesNote::query()->where('global_id', $cg->id)->delete();

        if ($data['type_compromise_id'] === TypeCompromise::QUOTE_HOME) {

            $cg->LandScaper()->create($data['landscaper']);

            Calendar::query()->create([
                'cglobal_id' => $cg->id,
                'user_id' => $data['user_id'],
                'for_user_id' => 0,
                'start' => Carbon::parse($data['landscaper']['moment'] . ' '.$data['landscaper']['timer']),
                'end' => Carbon::parse($data['landscaper']['moment'] . ' '.$data['landscaper']['timer'])->addHours(2),
                'title' => 'Visita a cliente: ' .  $client->name ,
                'contentFull' => 'DOMICILIO: ' .$client->street . ' '. $client->home_number . ' '. $client->colony . '  /  NOTA: '.  $data['landscaper']['note'],
                'class' => 'domicilio'
            ]);

            Quote::query()->create([
                'cglobal_id' => $cg->id,
                'type_quote_id' => 1,
                'token' => mt_rand(0,99999),
                'moment' => Carbon::now(),
                'emit' => Carbon::now(),
                'status_id' => 1
            ]);

            // ENVIANDO ALERTA A PAISAJISTA
            Mail::to($user_email->email)->send(new AlertLandscape($data_email));

            return response()->json('Se generó un evento de visita en el calendario y se informo al paisajista!');
        }

        if ($data['type_compromise_id'] === TypeCompromise::INFO_SEND) {

            $cg->Documents()->create($data['documents']);

            Calendar::query()->create([
                'cglobal_id' => $cg->id,
                'user_id' => $data['user_id'],
                'for_user_id' => 0,
                'start' => Carbon::parse($data['documents']['moment'] . ' 8:00'),
                'end' => Carbon::parse($data['documents']['moment'] . ' 18:00'),
                'allDay' => 1,
                'contentFull' => ' DOMICILIO: ' . $client->street . ' '. $client->home_number . ' '. $client->colony ,
                'title' => 'Información a: ' .$client->name,
                'class' => 'info'
            ]);

            return response()->json('Se generó un evento de envio de informacion a cliente!', 200);
        }

        if ($data['type_compromise_id'] === TypeCompromise::SALE_NOTE) {

            $sale = SalesNote::query()->create([
                'global_id' => $cg->id,
                'moment' => Carbon::now(),
                'emit' => Carbon::now(),
                'advance' => 0,
                'status_id' => 3,
            ]);
            return response()->json(['id'=>$sale->id]);
        }

        if ($data['type_compromise_id'] === TypeCompromise::QUOTE_DISTANCE) {

            $quote =  Quote::query()->create([
                'cglobal_id' => $cg->id,
                'type_quote_id' => 2,
                'token' => random_int(0,99999),
                'moment' => Carbon::now(),
                'emit' => Carbon::now(),
                'status_id' => 2
            ]);

            return response()->json(['id'=>$quote->id]);
        }
    }

    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = CGlobal::query()->with(['documents', 'compromise','contact',
            'attended', 'client', 'status', 'info' => function($q) {
                $q->with('info', 'info_det');
            }, 'landscaper' => function($l) {
                $l->with('user');
            }])->where('id', $id)->first();

        $sale = SalesNote::with([ 'status', 'details' => function($d) {
            $d->with('measure');
        }, 'delivered'=> function($d) {
            $d->with(['element'=> function($d) {
                $d->with('measure');
            }]);
        }])->where('global_id', $id)->first();

       if ( (int) $datos->type_motive === 1) {
           $motive = ProductOffereds::query()->find($datos->type_motive_id);
         } else {
           $motive = ServiceOffereds::query()->find($datos->type_motive_id);
        }

        $quote= Quote::with([ 'status', 'details' => function($d) {
            $d->with('measure');
        }])->where('cglobal_id', $id)->first();

        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale,

            'motive' => $motive->name,

            'quote' => $quote
        ];

       // return $data;

        $footer = \View::make('pdf.footer')->render();

        $header = \View::make('pdf.header', ['company' => Company::query()->find(1)])->render();

        $html = \View::make('pages.cags.pdf', $data)->render();

        $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function html($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = CGlobal::query()->with(['MotiveServices', 'MotiveProducts', 'documents', 'compromise','contact',
            'attended', 'client', 'status', 'info' => function($q) {
                $q->with('info', 'info_det');
            }, 'landscaper' => function($l) {
                $l->with('user');
            }])->where('id', $id)->first();

        $sale =  SalesNote::with([ 'status', 'details' => function($d) {
            $d->with('measure');
        }])->where('global_id', $id)->first();

        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale

        ];
        // return  $data;
        // $footer = View::make('components.footer')->render();

        $html = \View::make('pages.cags.pdf', $data)->render();

        $pdf->loadHTML($html); //->setOption('footer-html', $footer);

        return $pdf->inline();

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function update_database () {

        $sql = $this->sql .' database preciowe_crmgreen '; //.  env('DB_DATABASE');
        return $sql;
        \Illuminate\Support\Facades\DB::statement( $sql );
        return 'Listo';
    }

    public function destroy($id)  {

        CGlobal::destroy($id);

        Calendar::query()->where('cglobal_id', $id)->delete();

        return response()->json('Datos eliminados con exito!');

    }
}
