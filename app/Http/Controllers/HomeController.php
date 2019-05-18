<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

      if ( auth()->user()->can('board.graphic')) {
         $view = view('pages.panel.home')->render();
          return $view;
      }

      if ( auth()->user()->can('board.notification')) {
          $view = view('pages.notifications.list')->render();
          return $view;
      }

      if ( auth()->user()->can('quote')) {
          $view = view('pages.quotes.list',  ['find' => 0])->render();
          return $view;
      }

      if ( auth()->user()->can('cag')) {
            $view = view('pages.cags.list')->render();
            return $view;
      }

      return view('layouts.permisions');
    }

}
