<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenPrecio extends Model
{
    //
    protected $table = "orden_precio";
    protected $fillable = ['orden_id','precio','estatus','creado_por','modificado_por'];
    protected $primaryKey = 'orden_id';


    public function orden()
    {
        return $this->belongsTo('App\Orden');
    }

}
