<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    //
    protected $table = "precios";
    protected $fillable = ['precio','creado_por','modificado_por'];

    
}
