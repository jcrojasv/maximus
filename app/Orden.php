<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    //
    protected $table = 'ordenes';
    protected $fillable = ['id','mascota_id','fecha','tipo','firma','observaciones','entrada',
        'salida','creado_por','modificado_por'];

    public function listadoGeneral()
    {

    	//Hago consulta de las ordenes de trabajo ordenadas por fecha DESC
        
        $ordenes = $this->join('mascotas','ordenes.mascota_id','=','mascotas.id')
        ->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->select('ordenes.*', 'mascotas.nombre', 'propietarios.nombres')
        ->orderBy('fecha','desc')
        ->paginate(10);

        return $ordenes;

    }
}
