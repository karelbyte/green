<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Inventori;
use App\Models\Measure;
use App\Models\ProductOffereds\ProductOffereds;
use App\Models\ProductOffereds\ProductOfferedsDetails;
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

        $datos = ProductOffereds::with( ['details' => function($q) {
            $q->with(['measure', 'needs' => function ($n) {
                $n->with('element');
            }]);
        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $elements = Element::select('id', 'name')->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'measures' => Measure::all(),

            'elements' => $elements

        ];

        return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = ProductOffereds::where('name', $request->name)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        $product = ProductOffereds::create($request->except('details'));

        foreach ($request->details as $det) {

           $pdetails =  ProductOfferedsDetails::create([
               'products_offereds_id' => $product->id,
               'name' => $det['name'],
               'measure_id' => $det['measure_id'],
               'init'=> $det['init'],
               'end' => $det['end']
           ]);

           $pdetails->needs()->createMany($det['needs']);
        }

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = ProductOffereds::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un producto con ese nombre', 500);}

        $product = ProductOffereds::find($id);

        $product->update($request->except('details'));

        $product->details()->delete();

        foreach ($request->details as $det) {

            $pdetails =  ProductOfferedsDetails::create([
                'products_offereds_id' => $product->id,
                'name' => $det['name'],
                'measure_id' => $det['measure_id'],
                'init'=> $det['init'],
                'end' => $det['end']
            ]);

            $pdetails->needs()->createMany($det['needs']);
        }

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {

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
