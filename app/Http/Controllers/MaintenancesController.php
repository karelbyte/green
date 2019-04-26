<?php

namespace App\Http\Controllers;

use App\Models\Maintenances\MaintenanceDetail;
use App\Models\Client;
use App\Models\Maintenances\Maintenance;
use App\Models\SalesNotes\SalesNote;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenancesController extends Controller
{
    public function index()
    {
        return view('pages.maintenances.list');
    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Maintenance::with(['details', 'client', 'service', 'status'])

                ->leftJoin('clients', 'maintenances.client_id', 'clients.id');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('maintenances.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

            'clients' => Client::select('id', 'name')->get(),

            'services' => ServiceOfferedsDetails::select('id', 'name', 'price')->get()

        ];

        return response()->json($result, 200);

    }


    public function store(Request $request) {

       $maintenance = Maintenance::create([

           'client_id' => $request->client['id'],

           'service_offereds_id' => $request->service['id'],

           'timer' => $request->timer,

           'start' => $request->start,

           'status_id' => 1
       ]);

       MaintenanceDetail::create([

          'maintenance_id' => $maintenance->id,

          'moment' => $request->start,

          'note' => '',

          'price' => $request->service['price'],

          'status_id' => 1

         ]);


        return response()->json('Datos creado con exito!', 200);
    }
}
