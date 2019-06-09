<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarCollection;
use App\Models\Calendar;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarsController extends Controller
{
    public function index()
    {
        return view('pages.calendars.list');
    }

    public function getList(Request $request) {

        $sql = 'MONTH(start) = ' . $request->month . ' and ' .'YEAR(start) = ' . $request->year;

        $user = User::query()->find($request->user_id_auth);

        if ( (int) $user->position_id === 1) {

            $datos = Calendar::query()->with('user')
                ->whereRaw($sql)
                ->get();
        } else {
            $datos = Calendar::query()->with('user')
                ->whereRaw($sql)
                ->where('user_id', $request->user_id_auth)
                ->orWhere('for_user_id', $request->user_id_auth)
                ->get();
        }

        return $datos;
    }

    public function add(Request $request) {

        Calendar::query()->create([
            'user_id' => $request->user_id,
            'for_user_id' => $request->for_user_id,
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'title' => $request->title,
            'contentFull' => $request->contentFull,
            'class' => 'user'
        ]);
       return http_response_code(200);
    }

    public function update(Request $request) {

        Calendar::query()->where('id', $request->id)->update([
            'for_user_id' => $request->for_user_id,
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'title' => $request->title,
            'contentFull' => $request->contentFull,
        ]);
        return http_response_code(200);
    }

    public function eraser(Request $request)  {

        Calendar::destroy($request->id);

        return response()->json('Evento eliminado con exito!', 200);
    }
}
