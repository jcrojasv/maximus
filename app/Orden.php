<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Orden extends Model
{
    //
    protected $table = 'ordenes';
    //Le digo a eloquent que el id no es autoincrement
    public $incrementing = false;

    protected $fillable = ['id','mascota_id','fecha','estatus','tipo','firma','observaciones','observaciones_groomer','correlativo','entrada',
        'salida','creado_por','modificado_por'];

    public function listadoGeneral($year = null)
    {

        if(!$year)
        {
            $objDate = Carbon::now();
            $year = $objDate->format('Y');
        }

        //Hago consulta de las ordenes de trabajo ordenadas por fecha DESC
        
        $ordenes = $this->join('mascotas','ordenes.mascota_id','=','mascotas.id')
        ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->select('ordenes.*', 'mascotas.nombre', 'propietarios.nombres as nb_propietario',
            'propietarios.apellidos as ap_propietario',
            'propietarios.telefono_fijo as fijo','propietarios.telefono_celular as movil')
        ->where(DB::raw('YEAR(fecha)'),'=',$year)
        ->orderBy('fecha','desc')
        ->get();


        return $ordenes;

    }

    public function listadoDia($fecha)
    {

                   
        $ordenes = $this->join('mascotas','ordenes.mascota_id','=','mascotas.id')
        ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->join('especies','mascotas.especie_id','=','especies.id')
        ->join('razas','mascotas.raza_id','=','razas.id')
         ->select('ordenes.*', 'mascotas.nombre', 'propietarios.nombres as nb',
            'propietarios.apellidos as ap',
            'propietarios.telefono_fijo as fijo','propietarios.telefono_celular as movil',
            'especies.descripcion as esp','razas.descripcion as raza',
            DB::raw("IF(salida != '00:00:00',timediff(salida,entrada),'') as tiempo"))
        ->where('fecha','=',$fecha)
        ->orderBy('entrada','asc')
        ->get();

        return $ordenes;

    }

    //Funcion que realiza un promedio de tiempo de duracion de las ordenes

    public function promHoras($anio)
    {

        //->where(DB::raw('MONTH(fecha)'),'=',$mes)

        return $this->select(DB::raw('sec_to_time(avg(time_to_sec( timediff( salida, entrada ) ) )) AS total'))
        ->whereNotNull('entrada')
        ->whereNotNull('salida')
        ->where(DB::raw("YEAR(fecha)"),'=',$anio)
        ->first();

        

    }
    /*
        Funcion que arma la consulta de acumulados por mascota,\
        mas adelante se usa en diferentes contextos
    */
    public function ordenesMascotas()
    {
        return $this->join('mascotas','mascotas.id','=','ordenes.mascota_id')
                    ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
                    ->join('especies','mascotas.especie_id','=','especies.id')
                    ->join('razas','mascotas.raza_id','=','razas.id')
                    ->select(DB::raw('count(*) as total'), 'mascotas.nombre as mascota', 
                        'mascotas.id',
                        'propietarios.nombres as nb',
                        'propietarios.apellidos as ap',
                        'especies.descripcion as esp','razas.descripcion as raza')
                    ->groupBy('mascota_id')
                    ->orderBy('total','desc');
    }

    /*
        Devuelve un listado de las 10 mascotas con mas  ordenes en el year
    */
    public function topTen($year=null)
    {

        return  $this->ordenesMascotas()
                    ->where(DB::raw('YEAR(fecha)'),'=',$year)
                    ->take(10)
                    ->get();

    }
    /*
        Devuelve el total de ordenes acumuladas por mascota en el year,
        se sirve de ordenesMascotas()
    */
    public function acumuladoMascotas($year)
    {
        return $this->ordenesMascotas()->where(DB::raw('YEAR(fecha)'),'=',$year)
                    ->get();
    }

    /*
        Devuelve el total general de ordenes bien sea por el year,
        por el mes o por el dia
    */
    public function totalOrdenes($tipo,$fecha = null)
    {

        switch($tipo){

            case 'year':
                $totalOrdenes = $this->where(DB::raw('YEAR(fecha)'),'=',$fecha)->count();
                break;
            case 'mes':
                $arrFecha = explode("-",$fecha);
                $fechaInicio  = $arrFecha[0].'-'.$arrFecha[1].'-01';
                $totalOrdenes = $this->where('fecha','>=',$fechaInicio)
                ->where('fecha','<=',$fecha)->count();
                break;
            case 'day':
                $totalOrdenes = $this->where('fecha','=',$fecha)->count();
                break;
            default:
                $totalOrdenes = $this->count();
        }

        return $totalOrdenes;

    }

    public function totalXtiposXmascota($year)
    {
        return $this->join('mascotas','mascotas.id','=','ordenes.mascota_id')
                    ->join('especies','mascotas.especie_id','=','especies.id')
                    ->join('razas','mascotas.raza_id','=','razas.id')
                    ->select(DB::raw('count(*) as total'), 'mascotas.nombre as mascota',     
                        'especies.descripcion as esp','razas.descripcion as raza')
                    ->where(DB::raw('YEAR(fecha)'),'=',$year)
                    ->groupBy('mascota_id,tipo')

                    ->get();
    }
    /*
        Devuelve el total de ordenes diarias de la semana actual en comparacion
        con la semana anterior
    */
    public function totalDiarioComparativo()
    {

        return $this->select(DB::raw('count(*) as total, DAY(fecha) AS dia, DAYNAME(fecha) as dian, WEEK( fecha ) as semana, DAYOFWEEK(fecha) as diaWeek'))
            ->where(DB::raw('YEAR(fecha)'), '=', DB::raw('YEAR(NOW())'))
            ->where(DB::raw('WEEK(fecha)'), '=', DB::raw('WEEK(NOW())'))
            ->orWhere(DB::raw('WEEK(fecha)'), '=', DB::raw('WEEK(NOW())-1'))
            ->groupBy('fecha')
            ->orderBy('diaWeek','asc')->orderBy('semana','asc')
            ->get();
   
    }

    /*
        Devuelve el historial de ordenes dada el numero de ficha de la 
        mascota
    */
    public function historialMascota($id)
    {

        return $this->select(DB::raw('timediff(salida,entrada) as tiempo'),'ordenes.*')
        ->where('mascota_id','=',$id)
                    ->orderBy('fecha','desc')
                    ->get();
    }

    //Metodo para obtener la relacion con orden_arreglos
    public function ordenArreglo()
    {
        return $this->hasMany('App\ordenArreglo','orden_id');
    }


    public function prettyDate($column) 
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes[$column])->format('d/m/Y');
    }

}
