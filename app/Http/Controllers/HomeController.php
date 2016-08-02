<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Orden;
use Carbon\Carbon;
use App\Mascota;

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


        $year = $date->format('Y');

        $fechaActual = $date->format('Y-m-d');

        $strMes = $date->format('F-Y');

        //Numero de la semana actual
        $intSemana = $date->format('W');

        //fecha actual en string
        $strFecha = $date->toFormattedDateString();
     
        //Promedio de tiempo de las ordenes mensual    
        $tblOrden = new Orden();
        $promHoras = $tblOrden->promHoras($fechaActual);

        //Formateo el promedio de horas para quitarle los segundos
        $arrHoras = explode(':',$promHoras->total);
        if(count($arrHoras)>1)
            $promHoras = $arrHoras[0].":".$arrHoras[1]."'";
        else
            $promHoras = 0;

        $resultTop = $tblOrden->topTen($year);

        //Total de ordenes en el anio
        $totalOrdenesAnual = $tblOrden->totalOrdenes('year',$year);

        //Total de ordenes en el mes
        $totalOrdenesMes = $tblOrden->totalOrdenes('mes',$fechaActual);

        //Total de ordenes en el dia
        $totalOrdenesDia = $tblOrden->totalOrdenes('day',$fechaActual);

        //Ordenes actuales
        $ordenes = $tblOrden->listadoDia($fechaActual);

        //Datos para el grafico ordenes diarias
        $datosGrafico = $tblOrden->totalDiarioComparativo();
        $flag = false;
        $arrGrafico = array();

        foreach ($datosGrafico as $datos) 
        {
           
           if(!$flag) {
             $semana = $datos->semana;
             $flag = true;
           }

           
           if(!in_array($datos->dian,$arrGrafico) && $semana == $datos->semana)
             $arrGrafico[$datos->dian]['a'] = $datos->total;
           else
             $arrGrafico[$datos->dian]['b'] = $datos->total;


        }
        
        return view('home',compact('promHoras','resultTop','totalOrdenesAnual','totalOrdenesMes','totalOrdenesDia','strMes','year','strFecha','ordenes','arrGrafico','intSemana'));
    }
}
