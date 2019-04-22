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

        }])->select('*');

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

        try {

            $service = ServiceOffereds::create([
                'name' => $request->name
            ]);

            foreach ($request->details as $det) {

                try {

                    $service->details()->create([

                        'name' => $det['name'],

                        'init' => $det['init'],

                        'end' => $det['end'],

                        'price' => $det['price'],

                        'measure_id' => $det['measure']['id']
                    ]);
                }
                 catch ( \Exception $e) {

                    return response()->json('Ya existe un detalle con esa descripción', 500);

                }

            }

            return response()->json('Datos creado con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe un servicio con esa descripción', 500);

        }

    }

    public function update(Request $request, $id) {

        try {

            $service = ServiceOffereds::find($id);

            $service->update(['name' => $request->name]);

            $actuals = $service->details->pluck('id'); // IDENTIFICADORES ACTUALES

            foreach ($request->details as $det) {

                ServiceOfferedsDetails::updateOrCreate([
                    'id' => $det['id']
                    ],
                    [
                    'services_offereds_id' => $id,

                    'name' => $det['name'],

                    'init' => $det['init'],

                    'end' => $det['end'],

                    'price' => $det['price'],

                    'measure_id' => $det['measure']['id']

                ]);
            }

            $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

            $ids = $actuals->diff($updates);

            try {

                ServiceOfferedsDetails::whereIn('id', $ids)->delete();

            } catch (\Exception $e) {

                return response()->json('Trato de eliminar elementos en uso, se rechazaron esas operaciones!', 512);

            }

            return response()->json('Datos actualizados con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('Ya existe un servicio con esa descripción', 500);

        }
    }

    public function destroy($id)  {


        try {

            ServiceOffereds::destroy($id);

            return response()->json('Servicio eliminado con exito!', 200);

        } catch ( \Exception $e) {

            return response()->json('No se puede eliminar esta siendo usado este elemento !', 500);

        }

    }
}
