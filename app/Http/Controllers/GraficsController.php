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

        // GRAFICA DE CAD POR ETAPAS

        $pie_data = CGlobal::query()
            ->leftJoin('cglobal_status', 'cglobal_status.id', 'cglobals.status_id')
            ->whereMonth('moment', $month)
            ->selectRaw('count(status_id) as y, cglobal_status.name as name, status_id as status')
            ->groupBy('cglobals.status_id', 'cglobal_status.name')->get();
        $pie = [
            'cant_cag' => $client_care_month,
            'data' => $pie_data
         ];

        // VENTAS DEL AÑO
        $data_sale_year = [];
        for ($i = 1; $i <=12; $i++) {
            $data = SalesNote::query()->whereMonth('moment', $i)
                ->selectRaw('sum(advance) as total')->get()[0]['total'];
            $data_sale_year[] = $data ?? 0;
        }

        // VISTIA A DOMICILIO POR ASESOR
        $home_visit_month = CGlobal::query()
            ->leftJoin('users', 'cglobals.user_id', 'users.id')
            ->whereMonth('cglobals.moment', $month)
            ->where('cglobals.status_id', 1)
            ->selectRaw('count(cglobals.user_id) as y, users.name as name, cglobals.user_id as id, cglobals.status_id as status')
            ->groupBy('cglobals.user_id', 'users.name', 'cglobals.status_id')->get();

        // VERIFICACION DE RECEPCION DE COTIZACION
        $VERIFICATION_RECEIPT_QUOTATION = CGlobal::query()
            ->leftJoin('users', 'cglobals.user_id', 'users.id')
            ->whereMonth('cglobals.moment', $month)
            ->where('cglobals.status_id', 10)
            ->selectRaw('count(cglobals.user_id) as y, users.name as name, cglobals.user_id as id, cglobals.status_id as status')
            ->groupBy('cglobals.user_id', 'users.name', 'cglobals.status_id')->get();

        // EN ESTRATEGIA DE VENTA
        $STRATEGY_SALE = CGlobal::query()
            ->leftJoin('users', 'cglobals.user_id', 'users.id')
            ->whereMonth('cglobals.moment', $month)
            ->where('cglobals.status_id', 12)
            ->selectRaw('count(cglobals.user_id) as y, users.name as name, cglobals.user_id as id, cglobals.status_id as status')
            ->groupBy('cglobals.user_id', 'users.name', 'cglobals.status_id')->get();

        // VERIFICACION DE ESTRATEGIA DE VENTA
        $STRATEGY_SALE_CONFIRM = CGlobal::query()
            ->leftJoin('users', 'cglobals.user_id', 'users.id')
            ->whereMonth('cglobals.moment', $month)
            ->where('cglobals.status_id', 13)
            ->selectRaw('count(cglobals.user_id) as y, users.name as name, cglobals.user_id as id, cglobals.status_id as status')
            ->groupBy('cglobals.user_id', 'users.name', 'cglobals.status_id')->get();

        // VERIFICACION DE ESTRATEGIA DE VENTA
        $INQUOTE = CGlobal::query()
            ->leftJoin('users', 'cglobals.user_id', 'users.id')
            ->whereMonth('cglobals.moment', $month)
            ->where('cglobals.status_id', 9)
            ->selectRaw('count(cglobals.user_id) as y, users.name as name, cglobals.user_id as id, cglobals.status_id as status')
            ->groupBy('cglobals.user_id', 'users.name', 'cglobals.status_id')->get();

        // CAGAS EN ESTADO PAGADO SIN ENTREGAR
        $PAY_NOT_DELIVERI =  CGlobal::query()
            ->leftJoin('salesnotes', 'salesnotes.global_id', 'cglobals.id')
            ->whereMonth('salesnotes.moment', $month)
            ->where('salesnotes.status_id', 2)
            ->select('cglobals.id')->get();

        $data = [
            'url' => url('/') . '/atencion/',

            'client_care_month' => $client_care_month,
            'client_care_month_last' => $client_care_month_last,

            'sale_month' => $sale_month,
            'sale_month_last' => $sale_month_last,

            'quote_month' => $quote_month,
            'quote_month_last' => $quote_month_last,

            'maintenance_month' => $maintenance_month,
            'maintenance_month_last' => $maintenance_month_last,

            'amout_sale_month' => $amout_sale_month[0]->total,
            'amout_sale_month_last' => $amout_sale_month_last[0]->total,

            'pie_cag_status' => $pie,

            'sales_for_year' => $data_sale_year,

            'home_visit_month' => [
                'data' => $home_visit_month,
                'cant' =>$home_visit_month->sum('y')
            ],

            'VERIFICATION_RECEIPT_QUOTATION' => [
                'data' => $VERIFICATION_RECEIPT_QUOTATION,
                'cant' => $VERIFICATION_RECEIPT_QUOTATION->sum('y')
            ],

            'STRATEGY_SALE' => [
                'data' => $STRATEGY_SALE,
                'cant' => $STRATEGY_SALE->sum('y')
            ],

            'STRATEGY_SALE_CONFIRM' => [
                'data' => $STRATEGY_SALE_CONFIRM,
                'cant' => $STRATEGY_SALE_CONFIRM->sum('y')
            ],

            'INQUOTE' => [
                'data' => $INQUOTE,
                'cant' => $INQUOTE->sum('y')
            ],

            // CAGAS EN ESTADO PAGADO SIN ENTREGAR
            'PAY_NOT_DELIVERI' => [
              'cant' => $PAY_NOT_DELIVERI->count(),
              'data' => $PAY_NOT_DELIVERI->pluck('id')
            ]

        ];

        return response()->json($data,  200, [], JSON_NUMERIC_CHECK);
    }

}
