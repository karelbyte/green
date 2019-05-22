<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index()
    {
        return view('pages.tools.list');
    }

    public function getTools() {

        return Element::select('id', 'name', 'code')->tool()->get();

    }

    public function getList(Request $request) {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = Element::tool();

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select( '*')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list,

            ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);

    }

    public function store(Request $request) {

        try {

            Element::create($request->all());

            return response()->json('Datos creado con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe una herramienta con ese código', 500);

        }
    }

    public function update(Request $request, $id) {

        try {

            Element::where('id', $id)->update(['code' => $request->code, 'name' => $request->name]);

            return response()->json('Datos actualizados con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe una herramienta con ese codigo', 500);

        }
    }

    public function destroy($id)  {

        try {

            Element::destroy($id);

            return response()->json('Herramienta eliminada con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        }
    }
}
