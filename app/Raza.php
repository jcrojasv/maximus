<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    //
    protected $table = 'razas';

    public function getRazasById($especieId)
    {

    	$razas = $this->where('especie_id','=',$especieId)
    	->select('descripcion','id')
    	->orderBy('descripcion','asc')
    	->get();
    	
    	return $razas;

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
