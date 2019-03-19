<?php

namespace App\Http\Controllers;

use App\Models\Measure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasuresController extends Controller
{
    public function index()
    {
        return view('pages.measures.list');
    }


    public function getMeasures() {

        return Measure::select('id', 'name')->get();

    }

    public function getList(Request $request) {

        try {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = DB::table('measures');

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select('*')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list,

            ];

            return response()->json($result, 200);

        } catch (\Exception $e) {

            return response()->json('A ocurrido un error al obtener los datos!', 500);
        }

    }

    public function store(Request $request) {

        $me = Measure::where('name', $request->measure)->first();

        if (!empty($me)) { return response()->json('Ya existe una medida con esa descripción!', 500);}

        Measure::create(['name' => $request->measures]);

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        Measure::where('id', $id)->update(['name' => $request->measures]);

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {


        Measure::destroy($id);

        return response()->json('Rol eliminado con exito!', 200);
    }

}
