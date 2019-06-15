<?php

namespace App\Http\Controllers;

use App\Models\Quotes\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function quotesIndex()
    {
        return view('pages.reports.quotes');
    }

    public function dataQuotes(Request $request) {

        if ($request->all === true)  {
        $datos = Quote::query()->with('details')->leftJoin('cglobals', 'cglobals.id', 'quotes.cglobal_id')
            ->where('cglobals.user_id', $request->user_id)
            ->select('quotes.*')
            ->get();
        } else {
            $datos = Quote::query()->with('details')->leftJoin('cglobals', 'cglobals.id', 'quotes.cglobal_id')
                ->whereBetween('quotes.moment' , [Carbon::parse($request->star), Carbon::parse($request->end) ])
                ->select('quotes.*')
                ->where('cglobals.user_id', $request->user_id)->get();
        }


        return response()->json($datos,  200, [], JSON_NUMERIC_CHECK);
    }
}
