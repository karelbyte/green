<?php

namespace App\Http\Controllers;

use App\Models\Quotes\Quote;
use App\Models\Quotes\QuoteDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QuotesController extends Controller
{

    public function index($id = 0)
    {
        return view('pages.quotes.list');
    }

    public function getQuoteFiles($id) {

        $datos = Quote::with('docs')->where('id', $id)->select('*')->first();

        return $datos;

    }

    public function deleteQuoteFile($id) {

       QuoteDoc::destroy($id);

       return response(null, 200);

    }

    public function getList(Request $request) {

        $skip = $request->input('start') * $request->input('take');

        $filters = $request->filters;

        $orders =  $request->orders;

        $datos = Quote::with(['details', 'docs', 'status', 'globals' => function($q){

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

       // $img = Image::make($request->img)->resize(400, 300);

        $ext = $file->getClientOriginalExtension();

        $name = $file->getClientOriginalName();

        $patch = storage_path('app/public/') . $quote->uid .'/visit';

        File::exists( $patch) or File::makeDirectory($patch , 0777, true, true);

        $request->file->storeAs('public/'.$quote->uid .'/visit', $name);

        $quote->docs()->create(['url' => 'storage/' . $quote->uid .'/visit/'. $name, 'name' => $name, 'ext' => $ext] );

        return response()->json('', 200);
    }
}
