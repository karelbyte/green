<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Measure;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolsController extends Controller
{
    public function index()
    {
        return view('pages.tools.list');
    }

    public function getTools() {

        return Tool::select('id', 'name', 'code')->get();

    }

    public function getList(Request $request) {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = DB::table('tools');

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select( 'tools.*')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list,

            ];

            return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = Tool::where('code', $request->code)->first();

        if (!empty($mat)) { return response()->json('Ya existe un herramienta con es código', 500);}

        Tool::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        Tool::where('id', $id)->update(['code' => $request->code, 'name' => $request->name]);

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        Tool::destroy($id);

        return response()->json('Herramienta eliminada con exito!', 200);
    }
}
