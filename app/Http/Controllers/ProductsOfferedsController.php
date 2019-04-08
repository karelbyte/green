<?php

namespace App\Http\Controllers;

use App\Models\ProductOffereds;
use App\Models\ProductOfferedsDetails;
use Illuminate\Http\Request;

class ProductsOfferedsController extends Controller
{
    public function index()
    {
        return view('pages.productsoffereds.list');
    }


    public function getProduct() {

        return ProductOfferedsDetails::all();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = ProductOffereds::with('details');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = ProductOffereds::where('name', $request->name)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        $product = ProductOffereds::create($request->except('details'));

        $product->details()->createMany($request->details);

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = ProductOffereds::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        $product = ProductOffereds::find($id);

        $product->update($request->except('details'));

        $product->details()->delete();

        $product->details()->createMany($request->details);

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

        $product = ProductOffereds::find($id);

        $product->details()->delete();

        ProductOffereds::destroy($id);

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
