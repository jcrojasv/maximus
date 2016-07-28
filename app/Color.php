<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Color extends Model
{
    //
    protected $table = 'colores';

    protected $fillable = ['color'];

    //Metodo para obtener la relacion con mascotas
    public function mascota()
    {
        return $this->hasMany('App\Mascota','color_id');
    }

     public function prettyDate($column) 
    {
        return Carbon::createFromFormat('Y-m-d',$this->attributes[$column])->format('d/m/Y');
    }
}
