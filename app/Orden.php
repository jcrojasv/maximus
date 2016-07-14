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
            'especies.descripcion as esp','razas.descripcion as raza')
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

    public function ordenesMascotas()
    {
        return $this->join('mascotas','mascotas.id','=','ordenes.mascota_id')
                    ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
                    ->join('especies','mascotas.especie_id','=','especies.id')
                    ->join('razas','mascotas.raza_id','=','razas.id')
                    ->select(DB::raw('count(*) as total'), 'mascotas.nombre as mascota', 'propietarios.nombres as nb',
                        'propietarios.apellidos as ap',
                        'especies.descripcion as esp','razas.descripcion as raza')
                    ->groupBy('mascota_id')
                    ->orderBy('total','desc');
    }

    public function topTen($year=null)
    {

        return  $this->ordenesMascotas()
                    ->where(DB::raw('YEAR(fecha)'),'=',$year)
                    ->take(10)
                    ->get();

    }

    public function acumuladoMascotas($year)
    {
        return $this->ordenesMascotas()->where(DB::raw('YEAR(fecha)'),'=',$year)
                    ->get();
    }

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
