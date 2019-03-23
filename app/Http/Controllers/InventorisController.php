<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Inventori;
use Illuminate\Http\Request;

class InventorisController extends Controller
{
    public function index()
    {
        return view('pages.inventoris.list');
    }


    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Inventori::leftjoin('elements', 'elements.id', 'inventoris.element_id')

                           ->leftjoin('measures', 'elements.measure_id', 'measures.id');

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos->where('elements.type', $filters['type']['id']);

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('elements.code', 'elements.name', 'elements.price', 'inventoris.cant', 'measures.name as um')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result, 200);

    }

    public function pdf($type) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = Inventori::leftjoin('elements', 'elements.id', 'inventoris.element_id')

            ->leftjoin('measures', 'elements.measure_id', 'measures.id')

            ->where('elements.type', $type)

            ->select('elements.code', 'elements.name', 'elements.price', 'inventoris.cant', 'measures.name as um')->get();

        $data = [

            'company' => Company::find(1),

            'data' =>  $datos,

            'type' => $type

        ];

       // $footer = View::make('components.footer')->render();

        $html = \View::make('pages.inventoris.pdf', $data)->render();

        $pdf->loadHTML($html); //->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

}
