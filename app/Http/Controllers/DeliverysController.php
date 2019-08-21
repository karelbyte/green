<?php

namespace App\Http\Controllers;

use App\Models\CGlobal\CGlobal;
use App\Models\Company;
use App\Models\Element;
use App\Models\Inventori;
use App\Models\SalesNotes\SalesNote;
use App\Models\SalesNotes\SalesNoteDetails;
use App\Models\Users\User;
use Illuminate\Http\Request;


class DeliverysController extends Controller
{

    // TIPOS DE ELEMENTOS
    const PRODUCTO = 2;
    const SERVICIO = 3;
    const INVENTARIO = 1;

    public function index($id = 0)
    {
        return view('pages.delivery.list', ['find' => $id]);
    }


    public function getList(Request $request) {

        $user = User::query()->find($request->user_id_auth);

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = SalesNote::with([ 'status', 'globals' => function($q){
            $q->with('client', 'user');
        }, 'details' => function($d) {
            $d->with('measure');
        }])->leftJoin('cglobals', 'cglobals.id', 'salesnotes.global_id')
            ->leftJoin('clients', 'clients.id', 'cglobals.client_id');

        $datos->wherein('salesnotes.status_id', [4, 5, 6]);

        if ( (int) $user->position_id !== 1) {

            $datos->where('cglobals.user_id', $request->user_id_auth);
        }
        if ($filters['value'] !==  null ) {
            if ( is_string($filters['value']))  {
                $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');
            } else {
                $datos->where( $filters['field'], $filters['value']);
            }
        }

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('salesnotes.*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,

        ];

        return response()->json($result,  200, [], JSON_NUMERIC_CHECK);
    }

    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $sale = SalesNote::with('status')->where('id', $id)->first();

        $datos = CGlobal::with('client')->where('id', $sale->global_id)->first();

        $details = $this->NoteAplic($id);

        $data = [

            'company' => Company::query()->find(1),

            'data' =>  $datos,

            'sale' => $sale,

            'details' => $details,

        ];

        $html = \View::make('pages.sales.pdf_requirements', $data)->render();

        $pdf->loadHTML($html);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function NoteAplic($id) {

        $needs = $this->needs($id);

        if (count($needs) > 0) {

            foreach ($needs as $det) {

                if ($det['item_id'] !== null) {

                    $itemType = Element::query()->find($det['item_id']);

                    $pro = Inventori::query()->where('element_id', $det['item_id'])->first();

                    if ( (int) $itemType->type !== 2) {

                        $det['cant'] = (int) $det['type_item'] > 1  ? $det['cant']  * $det['cant_general'] : $det['cant'];
                    }

                    $det['exis'] = $pro['cant'] ?? 0;

                    $det['avility'] =   $pro['cant'] >= $det['cant'];

                    $det['delivered'] =  $det['avility'] ? $det['cant'] : $pro['cant'];

                    $det['missing'] =  $det['avility'] ? '' : abs($pro['cant'] - $det['cant']);
                }
            }
        }
        return $needs;
    }

    public function needs($id) {

        $products = SalesNoteDetails::query()->leftjoin('products_offereds_details', 'products_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('products_offereds_needs', 'products_offereds_needs.products_offereds_detail_id', 'products_offereds_details.id')

            ->leftjoin('elements', 'products_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item', 'elements.id as item_id',
                'elements.code', 'elements.name as descrip', 'products_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::PRODUCTO)->get();


        $services = SalesNoteDetails::query()->leftjoin('services_offereds_details', 'services_offereds_details.id', 'sales_note_details.item_id')

            ->leftjoin('services_offereds_needs', 'services_offereds_needs.services_offereds_detail_id', 'services_offereds_details.id')

            ->leftjoin('elements', 'services_offereds_needs.element_id', 'elements.id')

            ->select('sales_note_details.cant as cant_general', 'sales_note_details.type_item' , 'elements.id as item_id', 'elements.code',
                'elements.name as descrip', 'services_offereds_needs.cant')

            ->where('sales_note_details.sale_id', $id)->where('sales_note_details.type_item', self::SERVICIO)->get();

        $sale = SalesNote::query()->find($id);

        $inventoris = $sale->details_inventoris;

        $needs = $services->concat($products)->concat($inventoris);

        $finaly = $needs->reduce(function ($acumulador, $item){
            if (array_key_exists($item->item_id, $acumulador)) {
                $acumulador[$item->item_id]->cant += $item->cant;
            } else {
                $acumulador[$item->item_id] = $item;
            }
            return $acumulador;
        }, []);

        return  array_values($finaly);
    }
}
