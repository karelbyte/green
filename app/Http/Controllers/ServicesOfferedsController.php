<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Measure;
use App\Models\ServicesOffereds\ServiceOfferedNeed;
use App\Models\ServicesOffereds\ServiceOffereds;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
use Illuminate\Http\Request;

class ServicesOfferedsController extends Controller
{
    public function index()
    {
        return view('pages.servicesoffereds.list');
    }


    public function getServices() {

        return ServiceOfferedsDetails::with('measure')->get();

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = ServiceOffereds::with( ['details' => function($q) {
            $q->with(['measure', 'needs' => function ($n) {
                $n->with('element');
            }]);
        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $elements = Element::select('id', 'name')->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'measures' => Measure::all(),

            'elements' => $elements

        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    public function store(Request $request) {

        try {

            $service = ServiceOffereds::create([
                'name' => $request->name
            ]);

            foreach ($request->details as $det) {

              try {

                    $ser =  $service->details()->create([

                        'name' => $det['name'],

                        'init' => $det['init'],

                        'end' => $det['end'],

                        'price' => $det['price'],

                        'measure_id' => $det['measure_id']
                    ]);

                    $ser->needs()->createMany($det['needs']);
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

       /* try {*/

            $service = ServiceOffereds::find($id);

            $service->update(['name' => $request->name]);

            $actuals = $service->details->pluck('id'); // IDENTIFICADORES ACTUALES

            foreach ($request->details as $det) {

             $ser = ServiceOfferedsDetails::updateOrCreate([

                    'id' => $det['id']],
                    [
                    'services_offereds_id' => $id,

                    'name' => $det['name'],

                    'init' => $det['init'],

                    'end' => $det['end'],

                    'price' => $det['price'],

                    'measure_id' => $det['measure_id']
                ]);

                $actualsNeed = $ser->needs->pluck('id'); // IDENTIFICADORES ACTUALES NEEDS

                foreach ($det['needs'] as $need) {

                    ServiceOfferedNeed::updateOrCreate([

                        'id' => $need['id']],
                        [
                            'services_offereds_detail_id' => $ser->id,

                            'element_id' => $need['element_id'],

                            'cant' => $need['cant'],

                        ]);
                }

                $updatesNeeds = collect($det['needs'])->pluck('id'); // IDENTIFICADORES ACTUALIZADOS NEEDS

                $ids = $actualsNeed->diff($updatesNeeds);

                ServiceOfferedNeed::whereIn('id', $ids)->delete();
            }

            $updates = collect($request->details)->pluck('id'); // IDENTIFICADORES ACTUALIZADOS

            $ids = $actuals->diff($updates);

            try {

                ServiceOfferedsDetails::whereIn('id', $ids)->delete();

            } catch (\Exception $e) {

                return response()->json('Trato de eliminar elementos en uso, se rechazaron esas operaciones!', 512);

            }

            return response()->json('Datos actualizados con exito!', 200);

      /*  } catch ( \Exception $e) {

            return response()->json('Ya existe un servicio con esa descripción', 500);

        }*/
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
