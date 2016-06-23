<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arreglo extends Model
{
    //
    protected $table    = 'arreglos';
    protected $fillable = ['id,descripcion,tipo,padre'];

    public function ordenArreglo()
    {
        return $this->hasMany('App\OrdenArreglo','arreglo_id');
    }
}
