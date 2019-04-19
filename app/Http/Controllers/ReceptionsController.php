<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Inventori;
use App\Models\Receptions\Reception;
use App\Models\Receptions\ReceptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionsController extends Controller
{
    public function index()
    {
        return view('pages.receptions.list');
    }


    public function getReceptios() {

        return Reception::with('details')->get();

    }

    public function getList(Request $request) {

            $skip = $request->input('start') * $request->input('take');

            $filters = $request->filters;

            $orders =  $request->orders;

            $datos = Reception::with(['status', 'types', 'user', 'details' => function ($q) {

                $q->with('element');

            }]);

            if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

            $datos = $datos->orderby($orders['field'], $orders['type']);

            $total = $datos->select('*')->count();

            $list =  $datos->skip($skip)->take($request['take'])->get();

            $result = [

                'total' => $total,

                'list' =>  $list

            ];

            return response()->json($result, 200);

    }

    public function store(Request $request) {

        $recep = Reception::create($request->reception);

        $recep->details()->createMany($request->details);

        return response()->json('Recepción guardada con exito!', 200);
   }

    public function update(Request $request, $id) {


        $recep = Reception::find($id);

        $recep->update($request->reception);

        ReceptionDetail::where('reception_id', $id)->delete();

        $recep->details()->createMany($request->details);

        return response()->json('Recepción actualizada con exito!', 200);
    }


    public function destroy($id) {

        Reception::destroy($id);

        return response()->json('Eliminada con exito!', 200);
    }

    public function aplic(Request $request) {

      $recep = Reception::find($request->id);

      foreach ($recep->details as $det) {

          $inve = Inventori::where('element_id', $det->item_id)->first();

          if (empty($inve)) {

              Inventori::create( [

                  'element_id' => $det->item_id,

                  'cant' => $det->cant
              ]);

          } else {

              $inve->cant += $det->cant;

              $inve->save();
          }
      }

      $recep->status_id = 2;

      $recep->save();

      return response()->json('Recepcion aplicada con exito al inventario!', 200);

    }


    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = Reception::with(['status', 'types', 'user', 'details' => function ($q) {

            $q->with('element');

        }])->where('id', $id)->first();

        $data = [

            'company' => Company::find(1),

            'data' =>  $datos,

        ];

        // $footer = View::make('components.footer')->render();

        $html = \View::make('pages.receptions.pdf', $data)->render();

        $pdf->loadHTML($html); //->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }

}
