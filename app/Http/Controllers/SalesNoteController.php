<?php

namespace App\Http\Controllers;

use App\Models\Inventori;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteDetails;
use App\Models\SalesNotes\SalesNoteStatus;
use Illuminate\Http\Request;

class SalesNoteController extends Controller
{
    // TIPOS DE ELEMENTOS
    const PRODUCTO = 2;
    const SERVICIO = 3;
    const INVENTARIO = 1;

    // ESTADOS DE LA NOTA DE VENTA
    const RECIBIDO= 1;
    const PAGADA = 2;
    const PROCESO = 3;
    const RECIBIDO_EJECUCION = 4;
    const PAGADA_EJECUCION = 5;
    const EJECUCION = 6;
    const PAGADA_TERMINADA = 7;
    const RECIBIDO_TERMINADA = 8;

    public function index($id = 0)
    {
        return view('pages.sales.list', ['find' => $id]);
    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = SalesNote::with(['details', 'status', 'globals' => function($q){

            $q->with('client');

        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result, 200);

    }

    public function SaveDetails(Request $request) {

        $total = collect($request->details)->reduce( function ($carry, $item) {
            return $carry + ($item['cant'] * $item['price']);
        });

        $status = self::PROCESO;

        if ( (double) $request->advance > 0) {
           $status = (double) $request->advance >= (double) $total ? self::PAGADA : self::RECIBIDO;
        }

        // ACTUALIZANDO NOTA DE VENTA

        $sale = SalesNote::find($request->id);

        $sale->advance = $request->advance;

        $sale->status_id = $status;

        $sale->save();

        // ACTUALIZANDO CICLO DE ATENCION GLOBAL

        if ($status == self::PROCESO) { $statusglobal = 2;  $traser = 2; }

        if ($status == self::RECIBIDO) { $statusglobal = 3; $traser = 4; }

        if ($status == self::PAGADA ) { $statusglobal = 4; $traser = 10; }

        $sale->globals()->update(['status_id' => $statusglobal, 'traser' => $traser]);


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

                    'cant' => $det['cant'],

                    'price' => $det['price'],

                    'start' => $det['start'],

                    'timer' => $det['timer'],
                ]);
        }
        $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

        $ids = $actuals->diff($updates);

        SalesNoteDetails::whereIn('id', $ids)->delete();

        return response()->json('Detalles guardados con exito!', 200);
    }

    // APLICANDO CANTIDADES Y GENERANDO ALERTAS
    public function NoteConfirm(Request $request) {
        $found = SalesNote::leftjoin('sales_note_details', 'sales_note_details.sale_id', 'salesnotes.id')

            ->where('salesnotes.id', $request->id)->whereIn('sales_note_details.type_item', [self::PRODUCTO, self::SERVICIO])->first();

        if ($found !== null) {
            // NOTA COMPLEJA
        } else {
            $sale = SalesNote::query()->find($request->id);
            switch ($sale->status_id) {
                case self::PROCESO:
                    $sale->status_id = self::EJECUCION;
                    break;
                case self::RECIBIDO:
                    $sale->status_id = self::RECIBIDO_EJECUCION;
                    break;
                case self::PAGADA:
                    $sale->status_id = self::PAGADA_EJECUCION;
                    break;
            }
            $sale->paimentdate = $request->paimentdate;
            $sale->deliverydate = $request->deliverydate;
            $sale->save();

            $inventoris = $sale->details_inventoris;
            foreach ($inventoris  as $det) {
                $pro = Inventori::where('element_id', ($det['item_id']))->first();
                $avility = $pro->cant >= $det['cant'];
                $delivered =  $avility ? $det['cant'] : $pro['cant'];
                $pro->update(['cant' => $pro['cant'] - $delivered]);
                SalesNoteDetails::query()->where('id', $det['id'])->update(['delivered' => $delivered]);
            }

        }
        return response()->json('Se generaron alertas y se actulizo el inventario!', 200);
    }

    public function NoteAplic($id) {

        $found = SalesNote::leftjoin('sales_note_details', 'sales_note_details.sale_id', 'salesnotes.id')

            ->where('salesnotes.id', $id)->whereIn('sales_note_details.type_item', [self::PRODUCTO, self::SERVICIO])->first();

        if ($found !== null) {

            // REVISANDO INVENTARIO PARA PRODUCTOS COMPUESTOS
            $sale = SalesNote::find($id);

            $products = SalesNote::leftjoin('sales_note_details', 'sales_note_details.sale_id', 'salesnotes.id')

                ->leftjoin('products_offereds_details', 'products_offereds_details.id', 'sales_note_details.item_id')

                ->leftjoin('products_offereds_needs', 'products_offereds_needs.products_offereds_detail_id', 'products_offereds_details.id')

                ->leftjoin('elements', 'products_offereds_needs.element_id', 'elements.id')

                ->select('elements.id', 'elements.code', 'elements.name', 'products_offereds_needs.cant')

                ->where('salesnotes.id', $id)->where('sales_note_details.type_item', 2)->get();

            foreach ($products as $det) {

                $pro = Inventori::where('element_id', ($det['id']))->first();

                $det['avility'] =   $pro['cant'] >= $det['cant'];

                $det['missing'] =  abs($pro['cant'] - $det['cant']);

            }

            // REVISANDO INVENTARIO PARA PRODUCTOS SIMPLES

            $inventoris = $sale->details_inventoris;

            foreach ($sale->details_inventoris  as $det) {

                $pro = Inventori::where('element_id', ($det['item_id']))->first();

                $det['avility'] =   $pro['cant'] >= $det['cant'];

                $det['missing'] =  abs($pro['cant'] - $det['cant']);

            }

            /* if (count($inventoris) > 0 ) {

                 foreach ($inventoris as $inv) {

                     $pro = Inventori::where('element_id', ($inv->item_id))->first();

                     $pro->update(['cant' => $pro->cant + $inv->cant]);

                 }
             }*/


            // REVISANDO SERVICIOS
            $services = $sale->details_services;

            return $services;

            /*

            foreach ($sale->details_inventoris  as $det) {

                    $pro = Inventori::where('element_id', ($det['item_id']))->first();

                    $pro->update(['cant' => $pro->cant - $det['cant']]);

            }*/
        } else {

            $sale = SalesNote::find($id);

            $inventoris = $sale->details_inventoris;

            foreach ($inventoris  as $det) {

                $pro = Inventori::where('element_id', ($det['item_id']))->first();

                $det['exis'] = $pro['cant'] == null ? 0 : $pro['cant'];

                $det['avility'] =   $pro['cant'] >= $det['cant'];

                $det['delivered'] =  $det['avility'] ? $det['cant'] : $pro['cant'];

                $det['missing'] =  $det['avility'] ? '' : abs($pro['cant'] - $det['cant']);

            }
            return $inventoris;
        }
    }
}
