<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Measure;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function index()
    {
        return view('pages.materials.list');
    }


    public function getMaterials() {

        return Material::select('id', 'code', 'name')->get();

    }

    public function getList(Request $request) {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

          //  $datos = Material::with('Measure');

            $datos = Material::leftjoin('measures', 'measures.id', 'materials.measure_id');

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select( 'materials.*', 'measures.name as measure')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list,

                'measures' => Measure::all()

            ];

            return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = Material::where('code', $request->code)->first();

        if (!empty($mat)) { return response()->json('Ya existe un material con ese código', 500);}

        Material::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = Material::where('code', $request->code)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un material con ese codigo', 500);}

        Material::where('id', $id)->update($request->except(['id', 'measure']));

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {


        Material::destroy($id);

        return response()->json('Material eliminado con exito!', 200);
    }
}
