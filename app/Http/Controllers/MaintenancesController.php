<?php

namespace App\Http\Controllers;

use App\Models\Maintenances\MaintenanceDetail;
use App\Models\Client;
use App\Models\Maintenances\Maintenance;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteDetails;
use App\Models\ServicesOffereds\ServiceOfferedsDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenancesController extends Controller
{
    public function index()
    {
        return view('pages.maintenances.list');
    }

    public function details($id) {
        return MaintenanceDetail::query()->with('status')->where('maintenance_id', $id)
            ->orderBy('moment', 'desc')
            ->get();
    }

    public function confirm($id) {

        $det = MaintenanceDetail::query()->find($id);
        $main = SalesNoteDetails::find($det->maintenance->sales_note_details_id);
        $note = SalesNote::query()->find($main->sale_id);

        // RELLENANDO NOTA DE VENTA
        $newNote = $note->replicate();
        $newNote->moment = Carbon::now();
       // $newNote->strategy = $det->note . ' PRECIO: ' . $det->price;
        $newNote->origin = SalesNote::ORIGIN_SALE_NOTE;
        $newNote->status_id = 3; // EN PROCESO
        $newNote->push();

        $newNote->details()->createMany($note->details_services->toArray());

        // ACTULIZANDO MANTENIMIENTO
        MaintenanceDetail::query()->where('id', $id)
            ->update([
                'sale_id' => $note->id,
                'status_id' => 3,
          ]);
    }

    public function updateInfo(Request $request) {
        MaintenanceDetail::query()->where('id', $request->id)
            ->update([
                'note_gardener' => $request->note_gardener,
                'note_client' => $request->note_client,
                'status_id' => 4, // PROCES0 - CONFIRMADO
            ]);
        return response()->json('Datos mantenimiento confirmados y actualizados con exito!');
    }

    public function detailsUpdate(Request $request) {
        MaintenanceDetail::query()->where('id', $request->id)
            ->update([
                'moment' => $request->moment,
                'visiting_time' => $request->visiting_time,
                'price' => $request->price,
                'status_id' => 2, // PROCES0 - CONFIRMADO
            ]);
        return response()->json('Datos mantenimiento confirmados y actualizados con exito!');
    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Maintenance::with(['client', 'service', 'status'])
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

        return response()->json($result);
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

        return response()->json('Datos creado con exito!');
    }

    public function update(Request $request, $id) {

        Maintenance::query()->where('id', $id)

        ->update([
            'timer' => $request->timer,
            'status_id' =>  $request->status_id
        ]);

        return response()->json('Datos actualizados con exito!');
    }
}