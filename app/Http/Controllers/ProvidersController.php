<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function index()
    {
        return view('pages.providers.list');
    }

    public function newview()
    {
        return view('pages.providers.new');
    }

    public function getProviders() {

        return Provider::select('id', 'name', 'code', 'contact')->get();

    }

    // OBTINE LA LISTA DE PROVEEDORES Y LOS ENVIA AL FRONT PAGINADO
    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->input('filters');

        $orders =$request->input('orders');

        $datos = Provider::select('*');

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

    // CREA PROVEEDOR
    public function store(Request $request)
    {

        $provider = Provider::where('code', $request->code)->first();

        if (!empty($provider)) return response()->json('Ya existe un proveedor con ese codigo!', 500);

        Provider::create($request->all());

        return response()->json('Proveedor añadido con exito!', 200);
    }

    // MODFICA PROVEEDOR
    public function update(Request $request, $id)
    {

       Provider::where('id', $id)->update($request->all());

       return response()->json('Datos actualizados con exito!', 200);
    }

    // ELIMINA USUARIO CON SU ROL EN EL SISTEMA
    public function destroy($id)
    {

        Provider::destroy($id);

        return response()->json('Datos eliminados con exito!', 200);


        /*$pro = Product::find($id);

        if ($pro->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Product::destroy($id);

            return response()->json('Producto eliminado con exito!', 200);
        } */
    }
}
