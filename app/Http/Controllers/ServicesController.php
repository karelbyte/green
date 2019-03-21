<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return view('pages.services.list');
    }


    public function getProduct() {

        return Service::select('id', 'name', 'init', 'end', 'price')->get();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Service::select('*');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = Service::where('name', $request->name)->first();

        if (!empty($mat)) { return response()->json('Ya existe un servicio con ese nombre', 500);}

        Service::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = Service::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un servicio con ese nombre', 500);}

        Service::where('id', $id)->update($request->all());

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        Service::destroy($id);

        return response()->json('Servicio eliminado con exito!', 200);

        /*$pro = Product::find($id);

        if ($pro->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Product::destroy($id);

            return response()->json('Producto eliminado con exito!', 200);
        } */
    }
}
