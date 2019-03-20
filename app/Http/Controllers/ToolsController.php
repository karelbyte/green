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

            return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = Element::tool()->where('code', $request->code)->first();

        if (!empty($mat)) { return response()->json('Ya existe un herramienta con es código', 500);}

        Element::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        Element::where('id', $id)->update(['code' => $request->code, 'name' => $request->name]);

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        $element = Element::find($id);

        if ($element->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Element::destroy($id);

            return response()->json('Herramienta eliminada con exito!', 200);
        }
    }
}
