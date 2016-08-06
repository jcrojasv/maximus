<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Orden;
use Carbon\Carbon;

class ReportesController extends Controller
{
    //

    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function ordenesDiarias(Request $request)
    {
    	$tblOrden = new Orden();

    	$date = Carbon::now();

    	if($request->ajax())
    	{
    		$data = $request->all();

    		$arrFecha = explode('-',$data['fecha']);

    		$fechaBD = $arrFecha['2'].'-'.$arrFecha[1].'-'.$arrFecha['0'];

    		//Ordenes de la fecha determinada
        	$ordenes = $tblOrden->listadoDia($fechaBD);

        	//fecha actual en string
       	    $strFecha = $date->toFormattedDateString();

    		$view = view('reportes.ordenesDiarias',compact('ordenes','strFecha'));

    		$sections = $view->renderSections();

    		return response()->json($sections['renderSection']);
    	}

    	return view('reportes.ordenesDiarias');
    }
}
