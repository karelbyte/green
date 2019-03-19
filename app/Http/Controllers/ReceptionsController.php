<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Reception;
use Illuminate\Http\Request;

class ReceptionsController extends Controller
{
    public function index()
    {
        return view('pages.receptions.list');
    }


    public function getReceptios() {

        return Reception::with('details')->get();

    }

    public function getList(Request $request) {

           $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = Reception::with('details');

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select('*')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list,

                'materials' => Material::select('id', 'name')->get()

            ];

            return response()->json($result, 200);

    }
}
