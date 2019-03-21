<?php

namespace App\Http\Controllers;

use App\Models\Inventori;
use Illuminate\Http\Request;

class InventorisController extends Controller
{
    public function index()
    {
        return view('pages.inventoris.list');
    }


    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Inventori::leftjoin('elements', 'elements.id', 'inventoris.element_id')
                           ->join('measures', 'elements.measure_id', 'measures.id');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos->where('elements.type', $filters['type']['id']);

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('elements.code', 'elements.name', 'elements.price', 'inventoris.cant', 'measures.name as um')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result, 200);


    }

}
