<?php

namespace App\Http\Controllers;

use App\Models\CGlobal\CGlobal;
use App\Models\Maintenances\MaintenanceDetail;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraficsController extends Controller
{
    public function getDataMonth() {

        $month = Carbon::now()->month;
        $month_last = Carbon::now()->subMonth()->month;

        // CLIENTES ATENDIDOS EN EL MES ACTUAL
        $client_care_month = CGlobal::query()->whereMonth('moment', $month)->count();
        // CLIENTES ATENDIDOS EN EL MES ANTERIOR
        $client_care_month_last = CGlobal::query()->whereMonth('moment', $month_last)->count();

        // VENTAS EN EL MES ACTUAL
        $sale_month = SalesNote::query()->whereMonth('moment', $month)->where('status_id', '<>', 3 )->count();
        // VENTAS EN EL MES ANTERIOR
        $sale_month_last = SalesNote::query()->whereMonth('moment', $month_last)->where('status_id', '<>', 3 )->count();

        // COTIZACIONES EN EL MES ACTUAL
        $quote_month = Quote::query()->whereMonth('moment', $month)->count();
        // COTIZACIONES EN EL MES ANTERIOR
        $quote_month_last = Quote::query()->whereMonth('moment', $month_last)->count();

        // MATENIMIENTOS EN EL MES ACTUAL
        $maintenance_month = MaintenanceDetail::query()->whereMonth('moment', $month)->where('status_id', '>', 1 )->count();
        // MANTENIMIENTOS EN EL MES ANTERIOR
        $maintenance_month_last = MaintenanceDetail::query()->whereMonth('moment', $month_last)->where('status_id', '>', 1)->count();

        // MOTO VENTAS EN EL MES ACTUAL
        $amout_sale_month = SalesNote::query()->whereMonth('moment', $month)->selectRaw('sum(advance) as total')->get();
        $amout_sale_month_last = SalesNote::query()->whereMonth('moment', $month_last)->selectRaw('sum(advance) as total')->get();


        $data = [
            'client_care_month' => $client_care_month,
            'client_care_month_last' => $client_care_month_last,

            'sale_month' => $sale_month,
            'sale_month_last' => $sale_month_last,

            'quote_month' => $quote_month,
            'quote_month_last' => $quote_month_last,

            'maintenance_month' => $maintenance_month,
            'maintenance_month_last' => $maintenance_month_last,

            'amout_sale_month' => $amout_sale_month[0]->total,
            'amout_sale_month_last' => $amout_sale_month_last[0]->total
        ];

        return response()->json($data,  200, [], JSON_NUMERIC_CHECK);
    }

}
