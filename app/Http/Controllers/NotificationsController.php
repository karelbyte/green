<?php

namespace App\Http\Controllers;

use App\Entities\NotificationDaily;
use App\Models\Users\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('pages.notifications.list');
    }


    public function Today(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $daily = new NotificationDaily($request->user_id_auth, $user->position->id);

        return response()->json($daily->Daily());
    }
}
