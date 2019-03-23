<?php

namespace App\Http\Controllers;

use App\Models\CGlobal;
use Illuminate\Http\Request;

class CGlobalsController extends Controller
{
    public function index()
    {
        return view('pages.cags.list');
    }


    public function getCglobals() {

        return CGlobal::all();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = CGlobal::with('measure')->Material();

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'measures' => Measure::all()

        ];

        return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = Element::where('code', $request->code)->material()->first();

        if (!empty($mat)) { return response()->json('Ya existe un material con ese código', 500);}

        Element::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = Element::where('code', $request->code)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un material con ese codigo', 500);}

        Element::where('id', $id)->update($request->except(['id', 'measure']));

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        $element = Element::find($id);

        if ($element->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Element::destroy($id);

            return response()->json('Material eliminado con exito!', 200);
        }
    }
}
