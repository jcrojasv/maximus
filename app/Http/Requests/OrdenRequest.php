<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrdenRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        //Validacion de datos
       return [

            'fecha'         => ['required','','date'],
            'entrada'       => ['required'],
            'tipo'          => ['required'],
            'arregloEsp'    => ['required_if:tipo,ESP'],
            'arregloGen'    => ['required'],
            'salida'        => ['required_if:estatus,0']
         
        ];
       
    }

    public function messages()
    {
        return [

            'entrada.required'       => 'La hora de entrada es requedida',
            'tipo.required'          => 'El tipo de servicio es requerido',
            'arregloEsp.required_if' => 'Debe seleccionar al menos un arreglo especializado',
            'arregloGen.required'    => 'Debe seleccionar al menos un arreglo general',
            'salida'                 => 'La hora de salida es obligatoria si el proceso ha finalizado'

        ];
    }
}
