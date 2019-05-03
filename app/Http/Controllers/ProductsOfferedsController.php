<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Inventori;
use App\Models\Measure;
use App\Models\ProductOffereds\ProductOfferedNeed;
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

        return ProductOfferedsDetails::with('measure')->get();

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

        try {

            $product = ProductOffereds::create([

                'name' => $request->name
            ]);

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

        } catch (\Exception $e) {

            return response()->json('Ya existe un producto con ese nombre', 500);
        }


    }

    public function update(Request $request, $id) {

       try {

            $product = ProductOffereds::find($id);

            $product->update(['name' => $request->name]);

            $actuals = $product->details->pluck('id'); // IDENTIFICADORES ACTUALES

            foreach ($request->details as $det) {

                $pdetails = ProductOfferedsDetails::updateOrCreate([

                    'id' => $det['id']],
                    [
                    'products_offereds_id' => $product->id,

                    'name' => $det['name'],

                    'measure_id' => $det['measure_id'],

                    'init'=> $det['init'],

                    'end' => $det['end']
                ]);

                $actualsNeed = $pdetails->needs->pluck('id'); // IDENTIFICADORES ACTUALES NEEDS

                foreach ($det['needs'] as $need) {

                    ProductOfferedNeed::updateOrCreate([

                        'id' => $need['id']],
                        [
                            'products_offereds_detail_id' => $pdetails->id,

                            'element_id' => $need['element_id'],

                            'cant' => $need['cant'],

                        ]);
                }

                $updatesNeeds = collect($det['needs'])->pluck('id'); // IDENTIFICADORES ACTUALIZADOS NEEDS

                $ids = $actualsNeed->diff($updatesNeeds);

                ProductOfferedNeed::whereIn('id', $ids)->delete();

            }

            $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

            $ids = $actuals->diff($updates);

            ProductOfferedsDetails::whereIn('id', $ids)->delete();

            return response()->json('Datos actualizados con exito!', 200);

        } catch (\Exception $e) {

            return response()->json('Ya existe un producto con ese nombre', 500);
        }
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
