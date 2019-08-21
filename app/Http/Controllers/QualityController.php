<?php

namespace App\Http\Controllers;

use App\Mail\MailQualityCommend;
use App\Models\Client;
use App\Models\Company;
use App\Models\Qualities\Quality;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QualityController extends Controller
{

    public function index($id = 0)
    {
        return view('pages.qualities.list', ['find' => $id]);
    }

    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Quality::with([ 'status', 'global' => function($q){
            $q->with('client');
        }])->leftJoin('cglobals', 'cglobals.id', 'qualities.cglobal_id')
            ->leftJoin('clients', 'cglobals.client_id', 'clients.id');

        if ( (int) $user->position_id !== 1) {

            $datos->where('cglobals.user_id', $request->user_id_auth);
        }

        if ($filters['value'] !== null ) {

            if ( is_string($filters['value']))  {
                $datos->where($filters['field'], 'LIKE', '%'.$filters['value'].'%');
            } else {
                $datos->where($filters['field'], $filters['value']);
            }
        }

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('qualities.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list
        ];
        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    public function commends(Request $request) {

        $client = Client::query()->find($request->client_id);

        $quality = Quality::query()->find($request->id);

        $patch =  storage_path('app/public/cliente-') . $quality->global->client->code. '/cag-' .  $quality->global->id .'/recomandaciones';

        $name = $quality->id .'.'. $request->doc->getClientOriginalExtension();

        if ($request->has('doc'))  {

            $request->doc->storeAs('public/cliente-'.  $quality->global->client->code. '/cag-' .  $quality->global->id .'/recomandaciones', $name);

            $quality->url_doc = 'storage/cliente-' . $quality->global->client->code. '/cag-' .  $quality->global->id .'/recomandaciones/'.  $name;

            $quality->mime =  $request->doc->getMimeType();

        }
        $quality->status_id = 2;
        $quality->info_send_date = Carbon::now();
        $quality->save();

        // ENVIADO RECOMENDACIONES
        $data = [

            'company' => Company::query()->find(1),

            'client' =>  $client,

            'patch' => storage_path('app/public/cliente-'). $quality->global->client->code. '/cag-' .  $quality->global->id .'/recomandaciones/' .  $name,

            'namepdf' =>  $request->doc->getClientOriginalName(),

            'mime' =>  $request->doc->getMimeType()

        ];

        Mail::to($client->email)->send(new MailQualityCommend($data));

        $quality->global()->update(['status_id' => 14, 'traser' => 14]);

        return response()->json('Se envio las recomendaciones al cliente!');
    }

    public function updateCommendClient(Request $request) {

        $quality = Quality::query()->find($request->id);

        $quality->client_comment = $request->client_comment;

        $quality->confirm = Carbon::now();

        $quality->status_id = 3;

        $quality->save();

        $quality->global()->update(['status_id' => 15, 'traser' => 16]);

        return response()->json('Datos actualizados!');
    }
}
