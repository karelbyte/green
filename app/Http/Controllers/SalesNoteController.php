<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Mail\MailSaleRequeriments;
use App\Models\Calendar;
use App\Models\CGlobal\CGlobal;
use App\Models\Company;
use App\Models\Element;
use App\Models\Inventori;
use App\Models\Maintenances\Maintenance;
use App\Models\ProductOffereds\ProductOffereds;
use App\Models\ProductOffereds\ProductOfferedsDetails;
use App\Models\Qualities\Quality;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteDelivered;
use App\Models\SalesNotes\SalesNoteDetails;
use App\Models\ServicesOffereds\ServiceOffereds;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
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
            $q->with('client', 'user');
        }, 'details' => function($d) {
            $d->with('measure');
        }])->leftJoin('cglobals', 'cglobals.id', 'salesnotes.global_id')
            ->leftJoin('clients', 'clients.id', 'cglobals.client_id');


        if ( (int) $user->position_id !== 1) {

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

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);

    }

    public function SaveDetails(Request $request) {

        $sale = SalesNote::query()->find($request->id);

        if ($sale->status_id > self::PROCESO) { // ACTULIZANDO PAGO Y ESTADOS

            $total = $sale->total() - $sale->discount;

            if ( (double) $request->advance > 0) {
                switch ($sale->status_id) {
                    case self::EJECUCION;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_EJECUCION : self::RECIBIDO_EJECUCION;
                        $sale->globals()->update(['status_id' => 6, 'traser' => 12]);
                        break;
                    case self::TERMINADA;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_TERMINADA : self::RECIBIDO_TERMINADA;
                        $sale->globals()->update(['status_id' => 7, 'traser' => 13]);
                        break;
                    case self::RECIBIDO_TERMINADA;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_TERMINADA : self::RECIBIDO_TERMINADA;
                        $sale->globals()->update(['status_id' => 7, 'traser' => 13]);
                        break;
                    case self::RECIBIDO_EJECUCION;
                        $sale->status_id = (double) $request->advance >= (double) $total ? self::PAGADA_EJECUCION : self::RECIBIDO_EJECUCION;
                        $sale->globals()->update(['status_id' => 6, 'traser' => 12]);
                        break;
                }
            }
            // ACTUALIZANDO NOTA DE VENTA
            $sale->have_iva = $request->have_iva;
            $sale->advance = $request->advance;
            $sale->discount = $request->discount;
            $sale->save();
            return response()->json('Detalles guardados con exito!');

        }  else { // EDITANDO DETALLES
            // ACTUALIZANDO DETALLES NOTA DE VENTA
            $actuals = $sale->details->pluck('id');

            foreach ($request->details as $det) {
                $deliver = 1;
                if (array_key_exists('item',  $det)) {
                    $deliver = (int) $det['type_item'] > 1 ? $det['item']['end']: 1;
                } else {
                    if ((int) $det['type_item'] === 2) {
                        $deliver = ProductOfferedsDetails::query()->find($det['item_id'])->end;
                    }
                    if ((int) $det['type_item'] === 3) {
                        $deliver = ServiceOfferedsDetails::query()->find($det['item_id'])->end;
                    }
                }
                SalesNoteDetails::query()->updateOrCreate([

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

                        'deliver_product' => $deliver
                    ]);
            }

            $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

            $ids = $actuals->diff($updates);

            SalesNoteDetails::whereIn('id', $ids)->delete();

            $total = (double) SalesNote::query()->find($request->id)->total() - (int) $request->discount;

            if ( (double) $request->advance > 0) {

                 $sale->status_id = (double) $request->advance >=  $total ? self::PAGADA : self::RECIBIDO;
            }
             /// ACTUALIZANDO NOTA DE VENTA
            $sale->have_iva = $request->have_iva;
            $sale->advance = $request->advance;
            $sale->discount = $request->discount;
            $sale->save();
                // ACTUALIZANDO CICLO DE ATENCION GLOBAL
            $status_global = 0;
            $traser = 0;

             if ( (int) $sale->origin === SalesNote::ORIGIN_CAG)   {
                    if ((int) $sale->status_id === self::PROCESO) { $status_global = 2;  $traser = 2; }
                    if ((int) $sale->status_id === self::RECIBIDO) { $status_global = 3; $traser = 4; }
                    if ((int) $sale->status_id === self::PAGADA ) { $status_global = 4; $traser = 10; }
                    $sale->globals()->update(['status_id' => $status_global, 'traser' => $traser]);
              }

         return response()->json('Detalles guardados con exito!');
       }

    }

    public function NoteDeliverClient($id) {
       $inventoris = SalesNoteDelivered::query()->where('sale_id', $id)->whereRaw('delivered < cant')->get();
       $notfull = 0;
       foreach ($inventoris as $det) {
                $pro = Inventori::query()->where('element_id', $det['element_id'])->first();
                $avility = (double) $pro['cant'] >= (double) $det['cant'];
                if (!$avility) { $notfull++;}
        }
       if ($notfull > 0) {
           return response()->json(['data'=> $this->pdf_requirements($id), 'type'=> 2]);
       } else {
           foreach ($inventoris as $det) {
               $pro = Inventori::query()->where('element_id', $det['element_id'])->first();
               $discount = (double) $det['cant'] - (double) $pro['delivered'];
               $pro->update(['cant' => $pro['cant'] - $discount]);
               SalesNoteDelivered::query()->where('id', $det['id'])->update(['delivered' =>  $det['cant']]);
           }
           // REGRESANDO HERRAMIENTAS AL ALMACEN
           $invent = SalesNoteDelivered::query()->where('sale_id', $id)->get();
           foreach ($invent as $det) {
               $element = Element::query()->find( $det['element_id']);
               if ($element !== null) {
                   if ((int) $element['type'] === 2) {
                       $tool = Inventori::query()->where('element_id', $det['element_id'])->first();
                       if ($tool !== null) {
                           $tool->update(['cant' => (int) $tool['cant'] + (int) $det['delivered']]);
                       }
                   }
               }

           }
       }
      $sale =  SalesNote::query()->find($id);
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

       Quality::query()->create([
            'cglobal_id' => $sale->global_id,
            'moment' => Carbon::now(),
            'status_id' => 1
        ]);
       $sale->globals()->update(['status_id' => 7, 'traser' => 13]);
       return response()->json([
           'data'=> 'Se actualizo el inventario, la nota de venta, se genero un apartado de calidad para este ciclo!',
           'id' =>  $sale->global_id,
           'type'=> 1]
       );
    }

    // APLICANDO CANTIDADES Y GENERANDO ALERTAS
    public function NoteConfirm(Request $request) {
        // ACTUALIZANDO INVENTARIOS
         $needs =  $this->NoteAplic($request->id);
         $notfull = 0;
         foreach ($needs as $det) {
                    $delivered = 0;
                    $pro = Inventori::query()->where('element_id', $det['item_id'])->first();
                    if ($pro !== null) {
                        $avility = $pro['cant'] >= $det['cant'];
                        if (!$avility) { $notfull++;}
                        $delivered =  $avility ? $det['cant'] : $pro['cant'];
                        $pro->update(['cant' => $pro['cant'] - $delivered]);

                        SalesNoteDelivered::query()->create([
                            'sale_id' => $request->id,
                            'element_id' => $det['item_id'],
                            'cant' => $det['cant'],
                            'delivered' => $delivered
                        ]);
                    }
        }

            $sale = SalesNote::query()->find($request->id);
         /* $sale = SalesNote::with(['globals' => function($q) {
                $q->with('client', 'user');
             }])->where('id', $$request->id)->firts(); */
            // GENERANDO MANTENIMIENTOS

            if ((int) $sale->origin === SalesNote::ORIGIN_CAG) {
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
                        'moment' => Carbon::parse($maintenance->start),
                        'sale_id' => $request->id,
                        'price' => $sale->total(),
                        'accept' => 1,
                        'status_id' => 1]);

                    Calendar::query()->create([
                        'cglobal_id' => $sale->globals->id,
                        'user_id' => $sale->globals->user_id,
                        'for_user_id' => 0,
                        'start' => Carbon::parse(Carbon::parse($maintenance->start)),
                        'end' => Carbon::parse(Carbon::parse($maintenance->start))->addHours(2),
                        'title' => 'SERVICIO A : ' .  $sale->globals->client->name ,
                        'contentFull' => $maintenance->descrip . '   DOMICILIO: ' . $sale->globals->client->street . ' '. $sale->globals->client->home_number . ' '. $sale->globals->client->colony,
                        'class' => 'mant'
                    ]);
                }

            }

            // ESTADO DEL CICLO DE ATENCION
            $sale->globals()->update(['status_id' => 6, 'traser' => 10]);

           // ESTADOS
            switch ($sale->status_id) {
                case self::PROCESO:
                    $sale->status_id = self::EJECUCION;  // $notfull > 0 ? self::EJECUCION : self::TERMINADA;
                    break;
                case self::RECIBIDO:
                    $sale->status_id =   self::RECIBIDO_EJECUCION; // $notfull > 0 ? self::RECIBIDO_EJECUCION : self::RECIBIDO_TERMINADA;
                    break;
                case self::PAGADA:
                    $sale->status_id = self::PAGADA_EJECUCION; // $notfull > 0 ? self::PAGADA_EJECUCION : self::PAGADA_TERMINADA;
                    break;
            }
            $sale->paimentdate = $request->paimentdate;

            // CALCULAR TIEMPOS DE ENTREGA
            $det = $sale->products_services_null;
            if (count($det) > 0) {
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
        $footer = \View::make('pdf.footer')->render();

        $header = \View::make('pdf.header', ['company' => Company::query()->find(1)])->render();

        $html = \View::make('pages.sales.pdf_requirements', $data)->render();

        $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

        $pdf->save($patch . '/note-'. $id . '.pdf');

        Mail::to($email)->send(new MailSaleRequeriments($data));

    }

    public function NoteAplic($id) {

        $needs = $this->needs($id);

            if (count($needs) > 0) {

                foreach ($needs as $det) {

                    if ($det['item_id'] !== null) {

                        $itemType = Element::query()->find($det['item_id']);

                        $pro = Inventori::query()->where('element_id', $det['item_id'])->first();

                        if ( (int) $itemType->type !== 2) {

                            $det['cant'] = (int) $det['type_item'] > 1  ? $det['cant']  * $det['cant_general'] : $det['cant'];
                        }

                        $det['exis'] = $pro['cant'] ?? 0;

                        $det['avility'] =   $pro['cant'] >= $det['cant'];

                        $det['delivered'] =  $det['avility'] ? $det['cant'] : $pro['cant'];

                        $det['missing'] =  $det['avility'] ? '' : abs($pro['cant'] - $det['cant']);
                    }
                }
            }
         return $needs;
    }

    public function needs($id) {

        $products = SalesNoteDetails::query()->leftjoin('products_offereds_details', 'products_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('products_offereds_needs', 'products_offereds_needs.products_offereds_detail_id', 'products_offereds_details.id')

            ->leftjoin('elements', 'products_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item', 'elements.id as item_id',
                'elements.code', 'elements.name as descrip', 'products_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::PRODUCTO)->get();


        $services = SalesNoteDetails::query()->leftjoin('services_offereds_details', 'services_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('services_offereds_needs', 'services_offereds_needs.services_offereds_detail_id', 'services_offereds_details.id')

            ->leftjoin('elements', 'services_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item' , 'elements.id as item_id', 'elements.code',
                'elements.name as descrip', 'services_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::SERVICIO)->get();

        $sale = SalesNote::query()->find($id);

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

        $footer = \View::make('pdf.footer')->render();

        $header = \View::make('pdf.header', ['company' => Company::query()->find(1)])->render();

        $html = \View::make('pages.sales.pdf', $data)->render();

        $pdf->loadHTML($html)->setOption('header-html', $header)->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }
}
