<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    //
    protected $table = 'propietarios';

    protected $fillable = ['id','nombres','apellidos','email','direccion','telefono_fijo','telefono_celular'];

    //Metodo para obtener la relacion con mascotas
    public function mascota()
    {
        return $this->hasMany('App\Mascota','propietario_id');
    }
}
