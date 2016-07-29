<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    //
    protected $table = 'alimentos';
    protected $fillable = ['id','nombre','correlativo','especie_id'];

    public function getAlimentosById($especieId)
    {

    	$alimentos = $this->where('especie_id','=',$especieId)
    	->select('nombre','id')
    	->orderBy('nombre','asc')
    	->lists('nombre','id');
    	
    	return $alimentos;

    }

    public function getUltimoCorrelativo($especieId)
    {
        return $this->where('especie_id','=',$especieId)->max('correlativo');


    }

    public function mascota()
    {
         return $this->hasMany('App\Mascota','alimento_id');
    }

    public function especie()
    {
         return $this->belongsTo('App\Especie','especie_id');
    }
}
