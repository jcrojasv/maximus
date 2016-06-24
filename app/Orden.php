<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    //
    protected $table = 'ordenes';
    protected $fillable = ['id','mascota_id','fecha','estatus','tipo','firma','observaciones','entrada',
        'salida','creado_por','modificado_por'];

    public function listadoGeneral()
    {

    	//Hago consulta de las ordenes de trabajo ordenadas por fecha DESC
      
        $ordenes = $this->join('mascotas','ordenes.mascota_id','=','mascotas.id')
        ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->select('ordenes.*', 'mascotas.nombre', 'propietarios.nombres as nb_propietario',
            'propietarios.apellidos as ap_propietario',
            'propietarios.telefono_fijo as fijo','propietarios.telefono_celular as movil')->get();

        return $ordenes;

    }

    //Metodo para obtener la relacion con orde_arreglos
    public function ordenArreglo()
    {
        return $this->hasMany('App\ordenArreglo','orden_id');
    }
}
