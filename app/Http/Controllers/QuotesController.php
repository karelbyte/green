<?php

namespace App\Http\Controllers;

use App\Mail\SendQuoteClient;
use App\Models\Calendar;
use App\Models\CGlobal\CGlobal;
use App\Models\Company;
use App\Models\LandScaper;
use App\Models\Quotes\Quote;
use App\Models\Quotes\QuoteDoc;
use App\Models\Quotes\QuoteHead;
use App\Models\Quotes\QuotesNote;
use App\Models\SalesNotes\SalesNote;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $quote = Quote::query()->find($request->id);
        $quote->moment = $request->moment;
        $quote->save();
        return response()->json('');
    }

    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);
        $skip = $request->input('start') * $request->input('take');
        $filters = $request->filters;
        $orders =  $request->orders;

        $datos = Quote::with(['notes',  'TypeSend', 'docs', 'status', 'globals' => function ($q){
            $q->with(['client', 'user', 'landscaper' => function ($d) {
                $d->with('user');
            }]);
        }, 'heads' => function($d) {
            $d->with(['details' => function ($m) {
                $m->with('measure');
            }]);
        }])->leftJoin('cglobals', 'cglobals.id', 'quotes.cglobal_id')
            ->leftJoin('clients', 'clients.id', 'cglobals.client_id');

        if ( (int) $user->position_id === 2) {
            $datos->where('cglobals.user_id', $request->user_id_auth);
        }

        if ($filters['value'] !== null ) {

            if ( is_string($filters['value']))  {
                $datos->where($filters['field'], 'LIKE', '%'.$filters['value'].'%');
            } else {
                $datos->where($filters['field'], $filters['value']);
            }
        }

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

    public function cancel(Request $request) {

        $quote = Quote::query()->find($request->id);

        $quote->status_id = 5;

        $quote->feedback = $request->note;

        $quote->globals()->update(['status_id' => 5, 'traser' => 16]); // NO VENTA

        Calendar::query()->where('cglobal_id', $quote->cglobal_id)->delete();

        LandScaper::query()->where('cglobal_id', $quote->cglobal_id)->delete();

        $quote->save();

        return response()->json('Se archivaron los datos en el expediente!');

    }

    public function SaveFileMultiple(Request $request) {

        $quote = Quote::query()->find($request->id);

        for ($i = 0;  $i < $request->cant; $i++) {

            $file = $request->file('file' . $i);

            $ext = $file->getClientOriginalExtension();

            $name =  Str::uuid() . Carbon::now()->unix() .'.'. $ext;

            $patch =  storage_path('app/public/cliente-') . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit';

            File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

            $file->storeAs('/public/cliente-' . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit', $name);

            $quote->docs()->create(['url' => 'storage/cliente-' . $quote->globals->client->code. '/cag-' .  $quote->globals->id .'/visit/'. $name, 'name' => $name, 'ext' => $ext] );

        }

        return response()->json('' );
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

            if ((int) $request->clientemit === 1) {

                $quote->status_id = 4; // SE ACEPTO EL PRESUPUESTO VA A NOTA DE VENTA

            } else {

                if ( (int) $request->emit === 2) { // NO SE ACEPTO FINALMENTE SE ARCHIVA

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

            if ((int) $request->clientemit === 1) {  // GENERAR NOTA DE VENTA

                $quote->globals()->update(['status_id' => 4, 'traser' => 9]);

                $sale = SalesNote::query()->create([

                    'global_id' => $quote->cglobal_id,

                    'moment' => Carbon::now(),

                    'emit' => Carbon::now(),

                    'advance' => 0,

                    'strategy' => $quote->strategy,

                    'origin' => SalesNote::ORIGIN_CAG,

                    'status_id' => 3,

                ]);

                $datas = QuoteHead::query()->with('details')->whereIn('id',$request->headCheck)->get();
                foreach ($datas as $tf) {
                    $sale->details()->createMany($tf['details']->toArray());
                }

                return response()->json($sale->id);

            } else {

                return response()->json('Se verificó la recepción!');
            }

        } else {

            return response()->json('No coincide el código de confirmación!', 500);
        }

    }

    public function sendInfo(Request $request) {

        $quo = Quote::query()->find($request->id);

        $quote = Quote::query()->with(['heads' => function($d) {
                $d->with(['details' =>function ($i) {
                    $i->with('measure');
                }]);
            }]
        )->where('id', $request->id)->select('*')->first();

        $client = CGlobal::query()->with('client')->where('id',  $quote->cglobal_id)->first();

        if ((int) $quote->status_id === 2 || (int) $quote->status_id === 10 || (int) $quote->status_id === 11 ) {  // SE ENVIA PARA CONFIRMACION 1 VES

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 3;

            $quote->check_date = Carbon::now()->addDay(1);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 10, 'traser' => 5]);

        }
        if ((int) $quote->status_id === 6 ){

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 7;

            $quote->check_date = Carbon::now()->addDay(5);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 11, 'traser' => 6]);
        }
        if ((int) $quote->status_id === 8 ){

            $quote->type_send_id = $request->type_send_id;

            $quote->status_id = 9;

            $quote->strategy =  $request->strategy;

            $quote->check_date = Carbon::now()->addDay(7);

            $quote->sends ++ ;

            $quote->save();

            $quote->globals()->update(['status_id' => 13, 'traser' => 8]);
        }

            $patch = storage_path('app/public/cliente-') . $client['client']['code']. '/cag-' .  $quote->globals->id;

            File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

            // Generado la cotizacion

            $pdf = \App::make('snappy.pdf.wrapper');

            $data = [
                'company' => Company::query()->find(1),
                'patch' => $patch . '/cotizacion-'. $quote->token . '.pdf',
                'namepdf' =>  'cotizacion-'. $quote->token . '.pdf',
                'data' =>  $quote['heads'],
                'quote' => $quo,
                'client' => $client['client']
            ];

            //return $data;

            $footer = \View::make('pdf.footer')->render();

            $html = \View::make('pages.quotes.pdf', $data)->render();

            $pdf->loadHTML($html)->setOption('footer-html', $footer);

            if (File::exists( $patch . '/cotizacion-'. $quote->token . '.pdf')) {

                Storage::disk('public')->delete('cliente-'. $client['client']['code']. '/cag-' .
                    $quote->globals->id . '/cotizacion-'. $quote->token . '.pdf');

            }

           $pdf->save($patch . '/cotizacion-'. $quote->token . '.pdf');

         Mail::to($client['client']['email'])->send(new SendQuoteClient($data));

        return response()->json('Se actualizó el estado de envio de la información!');

    }

    // GUARDAR COTIZACION
    public function saveInfo(Request $request) {
        $data = $request->all();
        $quote = Quote::query()->find($request->id);
        if ($request->status_id === true || $request->status_id === 1) {
            $quote->status_id = 10;
            $quote->check_date = Carbon::now();
            $quote->save();
            $quote->globals()->update(['status_id' => 8, 'traser' => 3]);
        }
        $data['timer'] = Carbon::parse($data['timer'])->format('H:i');
        LandScaper::query()->where('cglobal_id',  $quote->globals->id)
            ->update([
                'moment' => $data['moment'],
                'timer' => $data['timer'],
                'status_id' => $request->status_id === true || $request->status_id === 1 ? 1 : 0
            ]);
        return response()->json('Detalles guardados con exito!');
    }
    // GUARDAR DETALLES

    public function SaveDetails(Request $request) {

      $quote =  Quote::query()->find($request->id);

        // CAMBIANDO ESTADO DE LA COTIZACION Y EL CAG
        if ($quote->status_id === 10 || $quote->status_id  === 2 || $quote->status_id  === 10) {
            $quote->status_id = 11;
            $quote->save();
            $quote->globals()->update(['status_id' => 9, 'traser' => 4]);
        }

      if (!$request->edit) {
          $head = $quote->heads()->create([
              'descrip' => $request->descrip,
              'specifications' => $request->specifications,
              'have_iva' => $request->have_iva,
              'discount' => $request->discount
          ]);
          $head->details()->createMany($request->details);

          $data = [
              'msj' => 'Creada con exito!',
              'dat' =>  $head->id
          ];
          return response()->json($data);

      } else {
           QuoteHead::query()->where('id', $request->head_id)->update([
              'descrip' => $request->descrip,
              'specifications' => $request->specifications,
              'have_iva' => $request->have_iva,
              'discount' => $request->discount
          ]);
          $head = QuoteHead::query()->find($request->head_id);
          $head->details()->delete();
          $head->details()->createMany($request->details);
          $data = [
              'msj' => 'Actualizada con exito',
              'dat' =>  $head->id
          ];
          return response()->json($data);
      }

    }

    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');
        $quo = Quote::query()->find($id);
        $datos = Quote::query()->with(['heads' => function($d) {
              $d->with(['details' =>function ($i) {
                 $i->with('measure');
              }]);
            }]
        )->where('id', $id)->select('*')->first();

        $client = CGlobal::query()->with('client')->where('id',  $datos->cglobal_id)->first();

        $data = [
            'company' => Company::query()->find(1),
            'data' =>  $datos['heads'],
            'quote' => $quo,
            'client' => $client['client']
        ];

        $footer = \View::make('pdf.footer')->render();

        $html = \View::make('pages.quotes.pdf', $data)->render();

        $pdf->loadHTML($html)->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function deleteQuote(Request $request) {
        QuoteHead::query()->where('id', $request->id)->delete();

        return response()->json('Cotizacion eliminada con exito!');
    }
}
