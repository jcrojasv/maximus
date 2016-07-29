<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    //
    protected $table = 'razas';
    protected $fillable = ['id','descripcion','especie_id','correlativo'];

    public function getRazasById($especieId)
    {

    	$razas = $this->where('especie_id','=',$especieId)
    	->select('descripcion','id')
    	->orderBy('descripcion','asc')
    	->lists('descripcion','id');
    	
    	return $razas;

    }

    public function getUltimoCorrelativo($especieId)
    {
        return $this->where('especie_id','=',$especieId)->max('correlativo');


    }

    public function mascota()
    {
         return $this->hasMany('App\Mascota','raza_id');
    }

    public function especie()
    {
         return $this->belongsTo('App\Especie','especie_id');
    }
}
