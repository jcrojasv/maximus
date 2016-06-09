<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //
    protected $table = 'colores';

    //Metodo para obtener la relacion con mascotas
    public function mascota()
    {
        return $this->hasMany('App\Mascota','color_id');
    }
}
