<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Mail\SendQuoteClient;
use App\Models\CGlobal\CGlobal;
use App\Models\Company;
use App\Models\LandScaper;
use App\Models\Quotes\Quote;
use App\Models\Quotes\QuoteDoc;
use App\Models\Quotes\QuotesNote;
use App\Models\SalesNotes\SalesNote;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class QuotesController extends Controller
{

    public function index($id = 0)
    {
        return view('pages.quotes.list', ['find' => $id]);
    }

    public function getQuoteFiles($id) {
        return Quote::with('docs')->where('id', $id)->select('*')->first();
    }

    public function getQuoteNotes($id) {
        return Quote::with('notes')->where('id', $id)->select('*')->first();
    }

    public function deleteQuoteNote($id) {
        QuotesNote::destroy($id);
        return http_response_code(200);
    }

    public function deleteQuoteFile($id) {

        $doc = QuoteDoc::query()->find($id);

        $patch = substr($doc->url, 8, strlen($doc->url));

        Storage::disk('public')->delete($patch);

        QuoteDoc::destroy($id);

        return http_response_code(200);
    }

    public function SaveNote(Request $request) {

        $quote = Quote::find($request->id);

        $quote->notes()->create($request->all());

        return response()->json('');
    }

    public function SetDate(Request $request) {

        $quote = Quote::find($request->id);

        $quote->moment = $request->moment;

        $quote->save();

        return response()->json('');
    }


    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Quote::with(['notes',  'TypeSend', 'docs', 'status', 'globals' => function($q){
            $q->with(['client', 'user', 'landscaper' => function ($d) {
                $d->with('user');
            }]);
        }, 'details' => function($d) {
            $d->with('measure');
        }])->leftJoin('cglobals', 'cglobals.id', 'quotes.cglobal_id')
            ->leftJoin('clients', 'clients.id', 'cglobals.client_id');

        if ( (int) $user->position_id !== 1) {

            $datos->where('cglobals.user_id', $request->user_id_auth);
        }

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('quotes.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'landscapers' => User::query()->where('position_id', 3)->select('uid', 'name')->get(),
        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);

    }


    public function SaveFile(Request $request) {

        $quote = Quote::query()->find($request->id);

        $file = $request->file;

        $ext = $file->getClientOriginalExtension();

        $name = Carbon::now()->timestamp .'.'. $ext;

        $patch =  storage_path('app/public/cliente-') . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit';

        File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

        $request->file->storeAs('/public/cliente-' . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit', $name);

        $quote->docs()->create(['url' => 'storage/cliente-' . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit/'. $name, 'name' => $name, 'ext' => $ext] );

        return response()->json('' );
    }

    public function checkInfo(Request $request) {

        $quote = Quote::query()->where('id',$request->id)->first();

        if ((int) $quote->token === (int) $request->code) {

            $quote->type_check_id = $request->type_check_id;

            $quote->feedback = $request->feedback;

            if ($request->clientemit === 1) {

                $quote->status_id = 4; // SE ACEPTO EL PRESUPUESTO VA A NOTA DE VENTA

            } else {

                if ($request->emit === 2) { // NO SE ACEPTO FINALMENTE SE ARCHIVA

                    $quote->status_id = 5;

                    $quote->feedback = $request->feedback;

                    $quote->globals()->update(['status_id' => 5, 'traser' => 16]); // NO VENTA

                    $quote->save();

                    return response()->json('Se archivaron los datos en el expediente!');

                } else {

                    $quote->status_id = $quote->status_id === 3 ? 6 : 8;

                    $quote->globals()->update(['status_id' => 11, 'traser' => 6]);

                   if ($quote->status_id === 8) {

                       $quote->check_date = Carbon::now()->addDay(7);

                       $quote->globals()->update(['status_id' => 12, 'traser' => 7]);
                   }

                    $quote->feedback = $request->feedback;

                }

            }

            $quote->save();

            if ($request->clientemit === 1) {  // GENERAR NOTA DE VENTA

                $quote->globals()->update(['status_id' => 4, 'traser' => 9]);

                $sale = SalesNote::create([

                    'global_id' => $quote->cglobal_id,

                    'moment' => Carbon::now(),

                    'advance' => 0,

                    'strategy' => $quote->strategy,

                    'origin' => SalesNote::ORIGIN_CAG,

                    'status_id' => 3,

                ]);

                $sale->details()->createMany($quote->details()->get()->toArray());

                return response()->json($sale->id);

            } else {

                return response()->json('Se verificó la recepción!');
            }

        } else {

            return response()->json('No coincide el código de confirmación!', 500);
        }

    }

    public function sendInfo(Request $request) {

        $quote = Quote::with(['notes', 'docs', 'status', 'globals' => function($q){
            $q->with(['client', 'Attended',  'landscaper' => function ($d) {

                $d->with('user');

            }]);
        }, 'details' => function($d) {
            $d->with('measure');
        }])->where('id', $request->id)->first();


        $client = CGlobal::query()->with('client')->where('id',  $quote->cglobal_id)->first();

        if ($quote->status_id === 2 || $quote->status_id === 10 || $quote->status_id === 11 ) {  // SE ENVIA PARA CONFIRMACION 1 VES

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 3;

            $quote->check_date = Carbon::now()->addDay(1);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 10, 'traser' => 5]);

        }
        if ($quote->status_id === 6 ){

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 7;

            $quote->check_date = Carbon::now()->addDay(5);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 11, 'traser' => 6]);
        }
        if ($quote->status_id === 8 ){

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 9;

            $quote->strategy =  $request->strategy;

            $quote->check_date = Carbon::now()->addDay(7);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 13, 'traser' => 8]);
        }

            // Creando rutas para guardar cotizacion --------------------

            $patch = storage_path('app/public/cliente-') . $quote->globals->client->code. '/cag-' .  $quote->globals->id;

            File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

            // Generado la cotizacion

            $pdf = \App::make('snappy.pdf.wrapper');

            $data = [

                'company' => Company::query()->find(1),

                'data' =>  $quote,

                'patch' => $patch . '/cotizacion-'. $quote->token . '.pdf',

                'namepdf' =>  'cotizacion-'. $quote->token . '.pdf',

                'client' => $client

            ];

            $footer = \View::make('pdf.footer')->render();

            $header = \View::make('pdf.header', ['company' => Company::query()->find(1)])->render();

            $html = \View::make('pages.quotes.pdf', $data)->render();

            $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

            if (File::exists( $patch . '/cotizacion-'. $quote->token . '.pdf')) {

                Storage::disk('public')->delete('cliente-'. $quote->globals->client->code. '/cag-' .
                    $quote->globals->id . '/cotizacion-'. $quote->token . '.pdf');

            }

           $pdf->save($patch . '/cotizacion-'. $quote->token . '.pdf');

           Mail::to($quote['globals']['client']['email'])->send(new SendQuoteClient($data));

        return response()->json('Se actualizó el estado de envio de la información!');

    }

    // GUARDAR COTIZACION

    public function saveInfo(Request $request) {

        $quote =  Quote::find($request->id);

        if ($request->status_id === true && $quote->status_id === 1) {

            $quote->status_id = 10;

            $quote->save();

            $quote->globals()->update(['status_id' => 8, 'traser' => 3]);
        }

        $cg = $quote->globals; // ->LandScaper()->update($request->except('id'));

        $lan = LandScaper::query()->where('cglobal_id', $cg->id)->first();

        $lan->update($request->except('id'));

        return response()->json('Detalles guardados con exito!');
    }

    // GUARDAR DETALLES

    public function SaveDetails(Request $request) {

      $quote =  Quote::query()->find($request->id);

      $quote->descrip = $request->descrip;

      $quote->specifications = $request->specifications;

        if ($quote->status_id === 10 || $quote->status_id  === 2 || $quote->status_id  === 10) {

            $quote->status_id = 11;

            $quote->save();

            $quote->globals()->update(['status_id' => 9, 'traser' => 4]);
        }

      $quote->save();

      $quote->details()->delete();

      $quote->details()->createMany($request->details);

      return response()->json('Detalles guardados con exito!', 200);
    }

    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = Quote::query()->with(['details' => function($d) {
            $d->with('measure');
        }])->where('id', $id)->select('*')->first();

        $client = CGlobal::query()->with('client')->where('id',  $datos->cglobal_id)->first();


        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'client' => $client

        ];
        $footer = \View::make('pdf.footer')->render();

        $header = \View::make('pdf.header', ['company' => \App\Models\Company::query()->find(1)])->render();

        $html = \View::make('pages.quotes.pdf', $data)->render();

        $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }
}
