<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\CGlobal\CGlobal;
use App\Models\CGlobal\CGlobalInfo;
use App\Models\Client;
use App\Models\LandScaper;
use App\Models\ProductOffereds\ProductOffereds;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use App\Models\ServicesOffereds\ServiceOffereds;
use App\Models\TypeContact;
use App\Models\TypeInfo;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GenerateID;


class CGlobalsController extends Controller
{
    use GenerateID;

    public function index()
    {
        return view('pages.cags.list');
    }


    public function getCglobals() {

        return CGlobal::all();

    }

    public function sendID () {

        return $this->getID('cglobals');
    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = CGlobal::with(['MotiveServices', 'MotiveProducts', 'documents', 'landscaper', 'compromise','contact',
           'attended', 'client', 'status', 'info' => function($q) {
            $q->with('info', 'info_det');
        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'clients' => Client::select('id', 'name')->get(),

            'type_contacts' => TypeContact::select('id', 'name')->get(),

            'type_infos' => TypeInfo::with('detail')->get(),

            'landscapers' => User::where('position_id', 3)->select('uid', 'name')->get(),

            'servicesOffereds' => ServiceOffereds::all(),

            'productsOffereds' => ProductOffereds::all()

        ];

        return response()->json($result, 200);

    }

    public function store(Request $request) {

       $data = $request->all();

       $cg = CGlobal::create([

           'moment' => $data['moment'],

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

           'status_id' => 1
       ]);

       $this->setID('cglobals', $cg->id );

       foreach ($data['info'] as $inf) {

           CGlobalInfo::create([

               'cglobal_id' => $cg->id,

               'type_info_id' => $inf['info']['id'],

               'type_info_detail_id' => $inf['info_det']['id'],

               'info_descrip' => $inf['info_descrip']
           ]);
       }

       // CREANDO COTIZACION A  DOMICIOLIO

       if ($data['type_compromise_id'] == 3) {

           $cg->LandScaper()->create($data['landscaper']);

           Calendar::create([

               'cglobal_id' => $cg->id,

               'moment' => $data['landscaper']['moment'],

               'timer' => $data['landscaper']['timer'],

               'title' => 'Visita a cliente'
           ]);

           Quote::create([

               'cglobal_id' => $cg->id,

               'type_quote_id' => 1,

               'token' => mt_rand(0,99999),

               'moment' => Carbon::now(),

               'status_id' => 1,


           ]);

           return response()->json('Se generó un evento de visita en el calendario y se informo al paisajista!', 200);
        }


        if ($data['type_compromise_id'] == 4) {

            $cg->Documents()->create($data['documents']);

            Calendar::create([

                'cglobal_id' => $cg->id,

                'moment' => $data['documents']['moment'],

                'timer' => '10:00',

                'title' => 'Envio de información'
            ]);

            return response()->json('Se generó un evento de envio de informacion a cliente!', 200);
        }

        if ($data['type_compromise_id'] == 1) {

          $sale = SalesNote::create([

                'global_id' => $cg->id,

                'moment' => Carbon::now(),

                'advance' => 0,

                'status_id' => 3,

            ]);

           return response()->json(['id'=>$sale->id], 200);
        }

        if ($data['type_compromise_id'] == 2) {

            $quote =   Quote::create([

               'cglobal_id' => $cg->id,

                'type_quote_id' => 2,

                'token' => mt_rand(0,99999),

                'moment' => Carbon::now(),

                'status_id' => 2,

            ]);

            return response()->json(['id'=>$quote->id], 200);
        }


    }

    public function update(Request $request, $id) {

        $data = $request->all();

        $cg = CGlobal::find($id);

        $cg->update([

            'type_contact_id' => $data['type_contact_id'],

            'repeater' => $data['repeater'],

            'type_compromise_id' => $data['type_compromise_id'],

            'type_motive' => $data['type_motive'],

            'type_motive_id' => $data['type_motive_id'],

            'required_time' => $data['required_time'],

            'note' => $data['note']

        ]);


        // CREANDO COTIZACION A DOMICILIO

        $cg->LandScaper()->delete();

        $cg->Documents()->delete();

        Calendar::where('cglobal_id', $cg->id)->delete();

        Quote::where('cglobal_id', $cg->id)->delete();

        SalesNote::where('global_id', $cg->id)->delete();


        if ($data['type_compromise_id'] == 3) {

            $cg->LandScaper()->create($data['landscaper']);

            Calendar::create([

                'cglobal_id' => $cg->id,

                'moment' => $data['landscaper']['moment'],

                'timer' => $data['landscaper']['timer'],

                'title' => 'Visita a cliente'
            ]);

            Quote::create([

                'cglobal_id' => $cg->id,

                'type_quote_id' => 1,

                'token' => mt_rand(0,99999),

                'moment' => Carbon::now(),

                'status_id' => 1,


            ]);

            return response()->json('Se generó un evento de visita en el calendario y se informo al paisajista!', 200);
        }


        if ($data['type_compromise_id'] == 4) {

            $cg->Documents()->create($data['documents']);

            Calendar::create([

                'cglobal_id' => $cg->id,

                'moment' => $data['documents']['moment'],

                'timer' => '10:00',

                'title' => 'Envio de información'
            ]);

            return response()->json('Se generó un evento de envio de informacion a cliente!', 200);
        }

        if ($data['type_compromise_id'] == 1) {

            $sale = SalesNote::create([

                'global_id' => $cg->id,

                'moment' => Carbon::now(),

                'advance' => 0,

                'status_id' => 3,

            ]);

            return response()->json(['id'=>$sale->id], 200);
        }

        if ($data['type_compromise_id'] == 2) {

            $quote =  Quote::create([

                'cglobal_id' => $cg->id,

                'type_quote_id' => 2,

                'token' => mt_rand(0,99999),

                'moment' => Carbon::now(),

                'status_id' => 2,

            ]);

            return response()->json(['id'=>$quote->id], 200);
        }


    }

    public function destroy($id)  {

        CGlobal::destroy($id);

        CGlobalInfo::where('cglobal_id', $id)->delete();

        LandScaper::where('cglobal_id', $id)->delete();

        Calendar::where('cglobal_id', $id)->delete();


        return response()->json('Datos eliminados con exito!', 200);

        /*$pro = Product::find($id);

        if ($pro->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Product::destroy($id);

            return response()->json('Producto eliminado con exito!', 200);
        } */
    }
}
