<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

use App\Raza;
use App\Color;
use App\Alimento;
use App\Mascota;
use App\Propietario;


class MascotaController extends Controller
{
    
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Mascota::with('propietario','raza.especie','color')->orderBy('nombre','asc')->get();
   		
        return view('mascota/list',compact('results'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        //Validacion de datos

        $this->validate($request, [

            'nombre'        => ['required','max:60'] ,
            'especie'       => ['required'] ,
            'raza_id'       => ['required'] ,
            'alimento_id'   => ['required'],
            'peso'          => ['integer']

        ],
        [
            'raza_id.required'      => "El campo raza es obligatorio",
            'alimento_id.required'  => "El campo alimento es obligatorio",
        ]
        );
        
        //Tomo los datos del formulario
        $data = $request->all();
        
        /* Genero el id de la mascota compuesto de la siguiente manera:
        *  propietario_id . max correlativo + 1
        *
        */
        $intCorrelativo = Mascota::where('propietario_id','=',$data['propietario_id'])->max('correlativo');
        
        $intCorrelativo += 1;
        
        $idMascota = $data['propietario_id'].$intCorrelativo;

        $data['id']          = $idMascota;
        $data['correlativo'] = $intCorrelativo;

        //Guardo los datos de la mascota       
        Mascota::create($data);

        //Creo una variable flash para el mensaje
        Session::flash('message','Mascota agregada correctamente');

        return redirect()->to('/propietario/'.$data['propietario_id'].'/edit');

    }

}
