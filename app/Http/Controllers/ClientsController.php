<?php

namespace App\Http\Controllers;

use App\Mail\MailNotyNewClient;
use App\Models\CGlobal\CGlobal;
use App\Models\Client;
use App\Models\Company;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use App\Traits\GenerateID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientsController extends Controller
{
    use GenerateID;

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

    public function sendID () {

        return $this->getID('clients');
    }

    public function files($id) {

        $cags = CGlobal::query()->with(['MotiveServices', 'MotiveProducts', 'compromise', 'user', 'status'])->where('cglobals.client_id', $id)
            ->orderBy('cglobals.moment', 'desc')
            ->get();

        $quotes =  Quote::with(['status', 'heads' => function($h) {
            $h->with('details');
        }, 'globals' => function($q){
            $q->with( 'user');
        }])->leftJoin('cglobals', 'cglobals.id', 'quotes.cglobal_id')
            ->where('cglobals.client_id', $id)
            ->select('quotes.*')
            ->orderBy('quotes.moment', 'desc')
            ->get();

        $sales =  SalesNote::with([ 'status', 'details', 'globals' => function($q){
            $q->with('user');
        }])->leftJoin('cglobals', 'cglobals.id', 'salesnotes.global_id')
            ->where('cglobals.client_id', $id)
            ->select('salesnotes.*')
            ->orderBy('salesnotes.moment', 'desc')
            ->get();

        $result = [
            'cags' => $cags,
            'quotes' => $quotes,
            'sales' => $sales
        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    // OBTINE LA LISTA DE CLIENTES Y LOS ENVIA AL FRONT PAGINADO
    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->input('filters');

        $orders =$request->input('orders');

        $datos = Client::query()->with('user')->select('*');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();


        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    // CREA CLIENTES
    public function store(Request $request)
    {

            $this->setID('clients', $request->code);
            $client = Client::query()->create($request->except(['id', 'user']));
            $data = [
                'client' => $client->name,
                'company' => Company::query()->find(1)
            ];
            Mail::to($request->email)->send(new MailNotyNewClient($data));
            return response()->json('Cliente añadido con exito!');

    }

    // MODFICA CLIENTE
    public function update(Request $request, $id)
    {
        Client::query()->where('id', $id)->update($request->except(['id', 'user']));
        return response()->json('Datos actualizados con exito!');
    }

    // ELIMINA CLIENTE
    public function destroy($id)
    {
        try {
            Client::destroy($id);
            return response()->json('Datos eliminados con exito!');
        } catch ( \Exception $e) {
            return response()->json('No se puede eliminar esta siendo usado este elemento!', 500);
        }
    }
}
