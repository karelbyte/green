<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        return view('pages.clients.list');
    }

    public function newview()
    {
        return view('pages.clients.new');
    }


    public function getProviders() {

        return Client::select('id', 'name', 'code', 'contact')->get();

    }

    // OBTINE LA LISTA DE CLIENTES Y LOS ENVIA AL FRONT PAGINADO
    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->input('filters');

        $orders =$request->input('orders');

        $datos = Client::select('*');

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

    // CREA CLIENTES
    public function store(Request $request)
    {

        $provider = Client::where('code', $request->code)->first();

        if (!empty($provider)) return response()->json('Ya existe un cliente con ese codigo!', 500);

        Client::create($request->all());

        return response()->json('Cliente añadido con exito!', 200);
    }

    // MODFICA CLIENTE
    public function update(Request $request, $id)
    {

        Client::where('id', $id)->update($request->all());

        return response()->json('Datos actualizados con exito!', 200);
    }

    // ELIMINA CLIENTE CON SU ROL EN EL SISTEMA
    public function destroy($id)
    {

        Client::destroy($id);

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
