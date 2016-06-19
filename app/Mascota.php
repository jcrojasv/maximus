<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    //
    protected $table = 'mascotas';

    protected $fillable = ['id','propietario_id','nombre','fecha_nacimiento','sexo','color_id',
        'raza_id','alimento_id','especie_id','sena','peso','vacuna','desparacitacion','correlativo'];

    public function buscarMascota($strMascota,$strPropietario)
    {

    	//Hago consulta tomando los datos pasados por parametros
        $objResult = $this->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->join('razas','razas.id','=','mascotas.raza_id')
        ->select('propietarios.*', 'mascotas.*','razas.descripcion')
        ->where('mascotas.nombre','LIKE','%'.$strMascota.'%')
        ->where('propietarios.nombres','LIKE','%'.$strPropietario.'%')
        ->orderBy('mascotas.nombre','desc')
        ->get();
    
        return $objResult;

    }

    public function selectMascota($id)
    {

        //Hago consulta tomando los datos pasados por parametros
        $objResult = $this->join('propietarios','mascotas.propietario_id','=','propietarios.id')
        ->join('razas','razas.id','=','mascotas.raza_id')
        ->join('especies','especies.id','=','mascotas.especie_id')
        ->join('colores','colores.id','=','mascotas.color_id')
        ->select('propietarios.*', 'mascotas.*','razas.descripcion as raza','especies.descripcion as especie','colores.color as color')
        ->where('mascotas.id','=',$id)
        ->first();
    
        return $objResult;
    }

    public function propietario()
    {
        return $this->belongsTo('App\Propietario');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function raza()
    {
        return $this->belongsTo('App\Raza');
    }

    public function especie()
    {
        return $this->belongsTo('App\Especie');
    }
}
