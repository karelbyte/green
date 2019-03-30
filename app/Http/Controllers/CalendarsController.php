<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarCollection;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarsController extends Controller
{
    public function index()
    {
        return view('pages.calendars.list');
    }

    public function getList(Request $request) {

        return CalendarCollection::collection(Calendar::all());
    }
}
