<?php

namespace App\Http\Controllers;

use App\Models\Qualities\Quality;
use App\Models\Users\User;
use Illuminate\Http\Request;

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
        }])->leftJoin('cglobals', 'cglobals.id', 'qualities.cglobal_id');

        if ( $user->position_id !== 1) {

            $datos->where('cglobals.user_id', $request->user_id_auth);
        }

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('qualities.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list
        ];
        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }
}
