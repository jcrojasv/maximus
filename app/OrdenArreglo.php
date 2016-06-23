<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenArreglo extends Model
{
    //
    protected $table = 'orden_arreglos';

    protected $fillable = ['orden_id','arreglo_id'];

    public function orden()
    {
        return $this->belongsTo('App\Orden');
    }

    public function arreglo()
    {
        return $this->belongsTo('App\Arreglo');
    }
}
