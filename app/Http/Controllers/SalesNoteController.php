<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Mail\MailSaleRequeriments;
use App\Models\CGlobal\CGlobal;
use App\Models\Company;
use App\Models\Element;
use App\Models\Inventori;
use App\Models\Maintenances\Maintenance;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteDelivered;
use App\Models\SalesNotes\SalesNoteDetails;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Glob;

class SalesNoteController extends Controller
{
    // TIPOS DE ELEMENTOS
    const PRODUCTO = 2;
    const SERVICIO = 3;
    const INVENTARIO = 1;

    // ESTADOS DE LA NOTA DE VENTA
    const RECIBIDO = 1;
    const PAGADA = 2;
    const PROCESO = 3;
    const RECIBIDO_EJECUCION = 4;
    const PAGADA_EJECUCION = 5;
    const EJECUCION = 6;
    const PAGADA_TERMINADA = 7;
    const RECIBIDO_TERMINADA = 8;
    const TERMINADA = 9;

    public function index($id = 0)
    {
        return view('pages.sales.list', ['find' => $id]);
    }

    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = SalesNote::with([ 'status', 'globals' => function($q){
            $q->with('client');
        }, 'details' => function($d) {
            $d->with('measure');
        }])->leftJoin('cglobals', 'cglobals.id', 'salesnotes.global_id');

        if ( $user->position_id !== 1) {

            $datos->where('cglobals.user_id', $request->user_id_auth);
        }

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('salesnotes.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'users' => User::query()->select('uid', 'name', 'email')->get()

        ];

        return response()->json($result);

    }

    public function SaveDetails(Request $request) {

        $sale = SalesNote::find($request->id);

        $total = $sale->total();

        if ($sale->status_id > self::PROCESO) { // ACTULIZANDO PAGO Y ESTADOS
            if ( (double) $request->advance > 0) {
                switch ($sale->status_id) {
                    case self::EJECUCION;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_EJECUCION : self::RECIBIDO_EJECUCION;
                        $sale->globals()->update(['status_id' => 6, 'traser' => 12]);
                        break;
                    case self::TERMINADA;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_TERMINADA : self::RECIBIDO_TERMINADA;
                        $sale->globals()->update(['status_id' => 7, 'traser' => 15]);
                        break;
                    case self::RECIBIDO_TERMINADA;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_TERMINADA : self::RECIBIDO_TERMINADA;
                        $sale->globals()->update(['status_id' => 7, 'traser' => 15]);
                        break;
                    case self::RECIBIDO_EJECUCION;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_EJECUCION : self::ECIBIDO_EJECUCION;
                        $sale->globals()->update(['status_id' => 7, 'traser' => 14]);
                        break;
                }
            }
            // ACTUALIZANDO NOTA DE VENTA
            $sale->advance = $request->advance;
            $sale->save();
            return response()->json('Detalles guardados con exito!', 200);

        }  else { // EDITANDO DETALLES

         if ( (double) $request->advance > 0) {
             $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA : self::RECIBIDO;
         }
         /// ACTUALIZANDO NOTA DE VENTA
         $sale->advance = $request->advance;
         $sale->save();

            // ACTUALIZANDO CICLO DE ATENCION GLOBAL
         if ($sale->origin === SalesNote::ORIGIN_CAG)   {
                if ($sale->status_id == self::PROCESO) { $statusglobal = 2;  $traser = 2; }
                if ($sale->status_id == self::RECIBIDO) { $statusglobal = 3; $traser = 4; }
                if ($sale->status_ids == self::PAGADA ) { $statusglobal = 4; $traser = 10; }
                $sale->globals()->update(['status_id' => $statusglobal, 'traser' => $traser]);
          }

         // ACTUALIZANDO DETALLES NOTA DE VENTA
         $actuals = $sale->details->pluck('id');

         foreach ($request->details as $det) {

                SalesNoteDetails::updateOrCreate([

                    'id' => $det['id']],
                    [
                        'sale_id' => $sale->id,

                        'type_item' => $det['type_item'],

                        'item_id' => $det['item_id'],

                        'descrip' => $det['descrip'],

                        'measure_id' => $det['measure_id'],

                        'cant' => $det['cant'],

                        'price' => $det['price'],

                        'start' => $det['start'],

                        'timer' => $det['timer'],

                        'deliver_product' => $det['item']['end'],
                    ]);
         }

         $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

         $ids = $actuals->diff($updates);

         SalesNoteDetails::whereIn('id', $ids)->delete();

         return response()->json('Detalles guardados con exito!', 200);
       }

    }

    public function NoteDeliverClient($id) {
       $inventoris = SalesNoteDelivered::query()->where('sale_id', $id)->whereRaw('delivered < cant')->get();
       $notfull = 0;
       foreach ($inventoris as $det) {
                $pro = Inventori::where('element_id', $det['element_id'])->first();
                $avility = (double) $pro['cant'] >= (double) $det['cant'];
                if (!$avility) { $notfull++;}
        }
       if ($notfull > 0) {
           return response()->json('Faltan existencia no se puede finalizar!', 500);
       } else {
           foreach ($inventoris as $det) {
               $pro = Inventori::where('element_id', $det['element_id'])->first();
               $discount = (double) $det['cant'] - (double) $pro['delivered'];
               $pro->update(['cant' => $pro['cant'] - $discount]);
               SalesNoteDelivered::where('id', $det['id'])->update(['delivered' =>  $det['cant']]);
           }
       }
      $sale =  SalesNote::find($id);
      switch ($sale->status_id) {
                case self::EJECUCION:
                    $sale->status_id = self::TERMINADA;
                    break;
                case self::PAGADA_EJECUCION:
                    $sale->status_id = self::PAGADA_TERMINADA;
                    break;
                case self::RECIBIDO_EJECUCION:
                    $sale->status_id = self::RECIBIDO_TERMINADA;
                    break;
       }
       $sale->save();
       $sale->globals()->update(['status_id' => 6, 'traser' => 15]);
       return response()->json('Se actualizo el inventario y la nota de venta!', 200);
    }

    // APLICANDO CANTIDADES Y GENERANDO ALERTAS
    public function NoteConfirm(Request $request) {
        // ACTUALIZANDO INVENTARIOS
        $needs =  $this->needs($request->id);

        $notfull = 0;
         foreach ($needs as $det) {
                $delivered = 0;
                $det['cant'] = $det['type_item'] > 1 ? $det['cant']  * $det['cant_general'] : $det['cant'];
                $pro = Inventori::where('element_id', $det['item_id'])->first();
                if ($pro !== null) {
                    $avility = $pro['cant'] >= $det['cant'];
                    if (!$avility) { $notfull++;}
                    $delivered =  $avility ? $det['cant'] : $pro['cant'];
                    $pro->update(['cant' => $pro['cant'] - $delivered]);
                };
                SalesNoteDelivered::query()->create([
                    'sale_id' => $request->id,
                    'element_id' => $det['item_id'],
                    'cant' => $det['cant'],
                    'delivered' => $delivered
                ]);
        }


            $sale = SalesNote::query()->find($request->id);
            // GENERANDO MANTENIMIENTOS
            if ($sale->origin === SalesNote::ORIGIN_CAG) {
                foreach ($sale->products_services as $maintenance) {
                    $newMait = Maintenance::query()->create([
                        'sales_note_details_id' => $maintenance->id,
                        'client_id' => $sale->globals->client_id,
                        'service_offereds_id' => $maintenance->item_id,
                        'timer' =>  $maintenance->timer,
                        'start' =>  $maintenance->start,
                        'status_id' => 1
                    ]);
                    $newMait->details()->create([
                        'moment' => Carbon::now(),
                        'sale_id' => $request->id,
                        'price' => $sale->total(),
                        'status_id' => 1]);

                }
                // ESTADO DEL CICLO DE ATENCION
                $sale->globals()->update(['status_id' => 6, 'traser' => 12]);
            }

           // ESTADOS
            switch ($sale->status_id) {
                case self::PROCESO:
                    $sale->status_id = $notfull > 0 ? self::EJECUCION : self::TERMINADA;
                    break;
                case self::RECIBIDO:
                    $sale->status_id =  $notfull > 0 ? self::RECIBIDO_EJECUCION : self::RECIBIDO_TERMINADA;
                    break;
                case self::PAGADA:
                    $sale->status_id = $notfull > 0 ? self::PAGADA_EJECUCION : self::PAGADA_TERMINADA;
                    break;
            }
            $sale->paimentdate = $request->paimentdate;
            // CALCULAR TIEMPOS DE ENTREGA
            $det = $sale->products_services_null;
            if ($det !== null) {
                $sale->deliverydate = Carbon::now()->addDays($det[0]['deliver_product'] - 1);
            } else {
                $sale->deliverydate = $request->deliverydate;
            }

            $sale->save();

            // ENVIANDO CORREO E IMPRIMIENDO
            if ($request->has('emailto') &&  $request->emailto !== '') {
               $this->emailTo($request->id, $request->emailto);
            }

            if ($request->generate_pdf) {
              return  $this->pdf_requirements($request->id);
            }

            return response()->json('Se generaron alertas y se actualizo el inventario!');
    }

    public function pdf_requirements($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $sale = SalesNote::with('status')->where('id', $id)->first();

        $datos = CGlobal::with('client')->where('id', $sale->global_id)->first();

        $details = $this->NoteAplic($id);

        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale,

            'details' => $details,

        ];

        $html = \View::make('pages.sales.pdf_requirements', $data)->render();

        $pdf->loadHTML($html);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function emailTo($id, $email) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $sale = SalesNote::with('status')->where('id', $id)->first();

        $datos = CGlobal::with('client')->where('id', $sale->global_id)->first();

        $details = $this->NoteAplic($id);

        $patch = storage_path('app/public/notes');

        File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

        if (File::exists( $patch . '/note-'. $id . '.pdf')) {

            Storage::disk('public')->delete('notes/note-'. $id . '.pdf');

        }
        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale,

            'details' => $details,

            'patch' => $patch . '/note-'. $id . '.pdf',

            'namepdf' =>  'nota-'. $id . '.pdf',

        ];

        $html = \View::make('pages.sales.pdf_requirements', $data)->render();

        $pdf->loadHTML($html);

        $pdf->save($patch . '/note-'. $id . '.pdf');

        Mail::to($email)->send(new MailSaleRequeriments($data));

    }

    public function NoteAplic($id) {

        $needs = $this->needs($id);

            if (count($needs) > 0) {

                foreach ($needs as $det) {

                    $itemType = Element::query()->find($det['item_id']);

                    $pro = Inventori::query()->where('element_id', $det['item_id'])->first();

                    if ( $itemType->type !== 2) {

                        $det['cant'] = $det['type_item'] > 1  ? $det['cant']  * $det['cant_general'] : $det['cant'];
                    }

                    $det['exis'] = $pro['cant'] ?? 0;

                    $det['avility'] =   $pro['cant'] >= $det['cant'];

                    $det['delivered'] =  $det['avility'] ? $det['cant'] : $pro['cant'];

                    $det['missing'] =  $det['avility'] ? '' : abs($pro['cant'] - $det['cant']);

                }
            }
         return $needs;
    }

    public function needs($id) {

        $products = SalesNoteDetails::leftjoin('products_offereds_details', 'products_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('products_offereds_needs', 'products_offereds_needs.products_offereds_detail_id', 'products_offereds_details.id')

            ->leftjoin('elements', 'products_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item', 'elements.id as item_id',
                'elements.code', 'elements.name as descrip', 'products_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::PRODUCTO)->get();

        $services = SalesNoteDetails::leftjoin('services_offereds_details', 'services_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('services_offereds_needs', 'services_offereds_needs.services_offereds_detail_id', 'services_offereds_details.id')

            ->leftjoin('elements', 'services_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item' , 'elements.id as item_id', 'elements.code',
                'elements.name as descrip', 'services_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::SERVICIO)->get();

        $sale = SalesNote::find($id);

        $inventoris = $sale->details_inventoris;

        $needs = $services->concat($products)->concat($inventoris);

        $finaly = $needs->reduce(function ($acumulador, $item){
            if (array_key_exists($item->item_id, $acumulador)) {
                $acumulador[$item->item_id]->cant += $item->cant;
            } else {
                $acumulador[$item->item_id] = $item;
            }
            return $acumulador;
        }, []);

        return  array_values($finaly);
    }

    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $sale =  SalesNote::with(['status', 'details' => function($d) {
            $d->with('measure');
        },])->where('id', $id)->first();

        $datos = CGlobal::with('client')->where('id', $sale->global_id)->first();

        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale

        ];

        $html = \View::make('pages.sales.pdf', $data)->render();

        $pdf->loadHTML($html);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }
}
