<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Measure;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function index()
    {
        return view('pages.materials.list');
    }


    public function getMaterials() {

        return Element::select('id', 'code', 'name')->material()->get();

    }

    public function getProducts()
    {
        return Element::with('measure')->where('elements.type', 1)->get();
    }

    public function getList(Request $request) {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = Element::with('measure')->Material();

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

        try {

            Element::create($request->all());

            return response()->json('Datos creado con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe un material con ese código', 500);

        }

    }

    public function update(Request $request, $id) {

        try {

            Element::where('id', $id)->update($request->except(['id', 'measure']));

            return response()->json('Datos actualizados con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe un material con ese codigo', 500);

        }

    }

    public function destroy($id)  {

        try {

            Element::destroy($id);

            return response()->json('Material eliminado con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        }

    }

}
