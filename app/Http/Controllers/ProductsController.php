<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pages.products.list');
    }


    public function getProduct() {

        return Product::select('id', 'name', 'init', 'end')->get();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Product::select('*');

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

        $mat = Product::where('name', $request->name)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        Product::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = Product::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        Product::where('id', $id)->update($request->all());

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        Product::destroy($id);

        return response()->json('Producto eliminado con exito!', 200);

        /*$pro = Product::find($id);

        if ($pro->used()) {

            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);

        } else {

            Product::destroy($id);

            return response()->json('Producto eliminado con exito!', 200);
        } */
    }
}
