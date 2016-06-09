<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    //
    protected $table = 'alimentos';

    public function getAlimentosById($especieId)
    {

    	$alimentos = $this->where('especie_id','=',$especieId)
    	->select('nombre','id')
    	->orderBy('nombre','asc')
    	->get();
    	
    	return $alimentos;

    }
}
