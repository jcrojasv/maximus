<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Orden;
use Carbon\Carbon;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $date = Carbon::now();
 
        $mes = $date->format('m');
        

        $tblOrden = new Orden();
        $promHoras = $tblOrden->promHoras($mes);

        return view('home',compact('promHoras'));
    }
}
