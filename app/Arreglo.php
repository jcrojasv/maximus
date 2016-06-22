<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arreglo extends Model
{
    //
    protected $table    = 'arreglos';
    protected $fillable = ['id,descripcion,tipo,padre'];
}
