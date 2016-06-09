<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    //
    protected $table = 'especies';

    public function raza()
    {
         return $this->hasMany('App\Raza','raza_id');
    }
}
