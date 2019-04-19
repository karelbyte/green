<?php

namespace App\Http\Controllers;

use App\Models\LandScaper;
use App\Models\Quotes\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('pages.notifications.list');
    }


    public function Today() {

        $landscapers = LandScaper::with(['global' => function($q) {

            $q->with('client');

        }])->whereDate('moment', '<=', Carbon::now())->where('status_id', 0)->get();


        $quoteconfirm = Quote::with(['globals' => function($q) {

            $q->with('client');

        }])->whereDate('check_date', '<=', Carbon::now())->where('status_id', 3)->get();


        $quotetracing = Quote::with(['globals' => function($q) {

            $q->with('client');

        }])->whereDate('check_date', '<=', Carbon::now())->where('status_id', 7)->get();

        $data = [

            'landscapers' => $landscapers,

            'quoteconfirm' => $quoteconfirm,

            'quotetracing' =>  $quotetracing
        ];

        return response()->json($data, 200);
    }
}
