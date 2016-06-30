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

    public function listadoGeneral()
    {

    	//Hago consulta de las ordenes de trabajo ordenadas por fecha DESC
      
        $ordenes = $this->join('mascotas','ordenes.mascota_id','=','mascotas.id')
        ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->select('ordenes.*', 'mascotas.nombre', 'propietarios.nombres as nb_propietario',
            'propietarios.apellidos as ap_propietario',
            'propietarios.telefono_fijo as fijo','propietarios.telefono_celular as movil')
        ->orderBy('fecha','desc')
        ->get();

        return $ordenes;

    }

    //Funcion que realiza un promedio de tiempo de duracion de las ordenes

    public function promHoras($mes)
    {


        return $this->select(DB::raw('sec_to_time(avg(time_to_sec( timediff( salida, entrada ) ) )) AS total'))
        ->where(DB::raw('MONTH(fecha)'),'=',$mes)
        ->whereNotNull('entrada')
        ->whereNotNull('salida')
        ->first();

        

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
