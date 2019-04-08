<?php

namespace App\Http\Controllers;

use App\Models\Measure;
use App\Models\ServiceOffereds;
use App\Models\ServiceOfferedsDetails;
use Illuminate\Http\Request;

class ServicesOfferedsController extends Controller
{
    public function index()
    {
        return view('pages.servicesoffereds.list');
    }


    public function getServices() {

        return ServiceOfferedsDetails::all();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = ServiceOffereds::with( ['details' => function ($q) {

            $q->with('measure');

        }])-> select('*');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'measures' => Measure::all()

        ];

        return response()->json($result, 200);


    }

    public function store(Request $request) {

        $mat = ServiceOffereds::where('name', $request->name)->first();

        if (!empty($mat)) { return response()->json('Ya existe un servicio con ese nombre', 500);}

        $service = ServiceOffereds::create($request->except('details'));

        foreach ($request->details as $det) {

            $service->details()->create([
                'name' => $det['name'],
                'init' => $det['init'],
                'end' => $det['end'],
                'price' => $det['price'],
                'measure_id' => $det['measure']['id']
            ]);
        }

        return response()->json('Datos creado con exito!', 200);
    }

    public function update(Request $request, $id) {

        $mat = ServiceOffereds::where('name', $request->name)->where('id', '<>', $id)->first();

        if (!empty($mat)) { return response()->json('Ya existe un servicio con ese nombre', 500);}

        $ser = ServiceOffereds::find($id);

        $ser->update($request->except('details'));

        $ser->details()->delete();

        foreach ($request->details as $det) {

            $ser->details()->create([
                'name' => $det['name'],
                'init' => $det['init'],
                'end' => $det['end'],
                'price' => $det['price'],
                'measure_id' => $det['measure']['id']
            ]);
        }

        return response()->json('Datos actualizados con exito!', 200);
    }

    public function destroy($id)  {


        $ser = ServiceOffereds::find($id);

        $ser->details()->delete();

        ServiceOffereds::destroy($id);

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
