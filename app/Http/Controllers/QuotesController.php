<?php

namespace App\Http\Controllers;

use App\Mail\SendQuoteClient;
use App\Models\Company;
use App\Models\Quotes\Quote;
use App\Models\Quotes\QuoteDoc;
use App\Models\Quotes\QuotesNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class QuotesController extends Controller
{

    public function index($id = 0)
    {
        return view('pages.quotes.list', ['find' => $id]);
    }

    public function getQuoteFiles($id) {

        $datos = Quote::with('docs')->where('id', $id)->select('*')->first();

        return $datos;

    }

    public function getQuoteNotes($id) {

        $datos = Quote::with('notes')->where('id', $id)->select('*')->first();

        return $datos;

    }

    public function deleteQuoteNote($id) {

        QuotesNote::destroy($id);

        return response(null, 200);

    }

    public function deleteQuoteFile($id) {

        $doc = QuoteDoc::find($id);

        $patch = substr($doc->url, 8, strlen($doc->url));

       // Storage::delete(storage_path().'/app/public/' . $patch);

        Storage::disk('public')->delete($patch);

        QuoteDoc::destroy($id);

       return response(null, 200);

    }

    public function SaveNote(Request $request) {

        $quote = Quote::find($request->id);

        $quote->notes()->create($request->all());

        return response()->json('', 200);
    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Quote::with(['notes', 'details', 'TypeSend', 'docs', 'status', 'globals' => function($q){

            $q->with(['client', 'landscaper' => function ($d) {

                $d->with('user');

            }]);

        }]);

        if ( $filters['value'] !== '') $datos->where( $filters['field'], 'LIKE', '%'.$filters['value'].'%');

        $datos = $datos->orderby($orders['field'], $orders['type']);

        $total = $datos->select('*')->count();

        $list =  $datos->skip($skip)->take($request['take'])->get();

        $result = [

            'total' => $total,

            'list' =>  $list,


        ];

        return response()->json($result, 200);

    }


    public function SaveFile(Request $request) {

        $quote = Quote::find($request->id);

        $file = $request->file;

        $ext = $file->getClientOriginalExtension();

        $name = $file->getClientOriginalName();

        $patch = storage_path('app/public/') . $quote->uid .'/visit';

        File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

        $request->file->storeAs('public/'.$quote->uid .'/visit', $name);

        $quote->docs()->create(['url' => 'storage/' . $quote->uid .'/visit/'. $name, 'name' => $name, 'ext' => $ext] );

        return response()->json('', 200);
    }


    public function sendInfo(Request $request) {


        $quote = Quote::with(['notes', 'details', 'docs', 'status', 'globals' => function($q){

            $q->with(['client', 'Attended',  'landscaper' => function ($d) {

                $d->with('user');

            }]);

        }])->where('id',$request->id)->first();

        $quote->type_send_id = $request->type_send_id;

        $quote->status_id = 3;

        $quote->sends ++ ;

        $quote->save();

        $quote->globals()->update(['status_id' => 2, 'traser' => 6]);


        if ($request->type_send_id == 2) {

            // Creando rutas para guardar cotizacion

            $patch = storage_path('app/public/') . $quote->uid;

            File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

            // Generado la cotizacion

            $pdf = \App::make('snappy.pdf.wrapper');

            $data = [

                'company' => Company::find(1),

                'data' =>  $quote,

                'patch' => $patch . '/cotizacion-'. $quote->token . '.pdf',

                'namepdf' =>  'cotizacion-'. $quote->token . '.pdf'

            ];

            $html = \View::make('pages.quotes.pdf', $data)->render();

            $pdf->loadHTML($html);

            if (File::exists( $patch . '/cotizacion-'. $quote->token . '.pdf')) {

                Storage::disk('public')->delete($quote->uid. '/cotizacion-'. $quote->token . '.pdf');

            }

            $pdf->save($patch . '/cotizacion-'. $quote->token . '.pdf');

            // Enviando correo

            Mail::to($quote['globals']['client']['email'])->send(new SendQuoteClient($data));

            return response()->json('Cotización enviada al cliente via email!', 200);

        }

        return response()->json('Se actualizó el estado de envio de la información!', 200);

    }

    // GUARDAR DETALLES

    public function SaveDetails(Request $request) {

      $quote =  Quote::find($request->id);

      $quote->descrip = $request->descrip;

      $quote->specifications = $request->specifications;

      $quote->save();

      $quote->details()->delete();

      $quote->details()->createMany($request->details);

      return response()->json('Detalles guardados con exito!', 200);
    }


    public function pdf($id) {

        $pdf = \App::make('snappy.pdf.wrapper');

        $datos = Quote::with('details')->where('id', $id)->select('*')->first();

        $data = [

            'company' => Company::find(1),

            'data' =>  $datos,

        ];

        // $footer = View::make('components.footer')->render();

        $html = \View::make('pages.quotes.pdf', $data)->render();

        $pdf->loadHTML($html); //->setOption('footer-html', $footer);

        $pdfBase64 = base64_encode($pdf->inline());

        return 'data:application/pdf;base64,' . $pdfBase64;
    }
}
