<?php

namespace App\Http\Controllers;

use App\Models\Inventori;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteStatus;
use Illuminate\Http\Request;

class SalesNoteController extends Controller
{
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

        $status = 1;

        if ( (double) $request->advance > 0) {

           $status = (double) $request->advance >= (double) $total ? 3 : 2;
        }

        // ACTUALIZANDO NOTA DE VENTA
        $sale = SalesNote::find($request->id);

        $sale->advance = $request->advance;

        $sale->status_id = $status;

        $sale->save();

        $sale->globals()->update(['status_id' => 2, 'traser' => 2]);

        // REVISANDO INVENTARIO

        $inventoris  = $sale->details_inventoris;

      //  return $inventoris;

        if (count($inventoris) > 0 ) {

            foreach ($inventoris as $inv) {

                $pro = Inventori::where('element_id', ($inv->item_id))->first();

                $pro->update(['cant' => $pro->cant + $inv->cant]);

            }
        }

        // ACTUALIZANDO

        foreach ($request->details  as $det) {

            if ($det['type_item'] == 1) {

                $pro = Inventori::where('element_id', ($det['item_id']))->first();

                $pro->update(['cant' => $pro->cant - $det['cant']]);

            }
        }

        $sale->details()->delete();

        $sale->details()->createMany($request->details);

        return response()->json('Detalles guardados con exito!', 200);
    }



}
