<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('pages.settings.company.new');
    }


    public function store(Request $request) {

        Company::truncate();

        Company::create($request->all());

        return response()->json('Datos creado con exito!', 200);
    }

    public function getdata() {

        return Company::find(1);
    }
}
