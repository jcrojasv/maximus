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

        return view('mascota.list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

        //Tomo los datos de la peticion
        $data = $request->all();

        //Datos para el select colores
        $colores = Color::lists('color','id');

        $propietario = Propietario::find($data['propietario']);

        if($request->ajax())
        {

            $accion = 'Agregar';

            $view = view('mascota.forms.frmMascota',compact('colores','accion','propietario'));
        
            $sections = $view->renderSections();
           
            return response()->json($sections['renderFormulario']); 
            
        }
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
            'especie_id'    => ['required'] ,
            'peso'          => ['integer'],
            'raza_id'       => ['exists:razas,id'],
            'alimento_id'   => ['exists:alimentos,id'],

        ],
        [
            'especie_id.required' => "El campo especie es obligatorio",
            'raza_id.exists'      => "El campo raza es obligatorio",
            'alimento_id.exists'  => "El campo alimento es obligatorio",
            
        ]);
      
        if($request->ajax())
        {
           

            //Tomo los datos del formulario
            $data = $request->all();

            /* Genero el id de la mascota compuesto de la siguiente manera:
            *  propietario_id . max correlativo + 1
            */
            
            $intCorrelativo = Mascota::where('propietario_id','=',$data['propietario_id'])->max('correlativo');
            
            $intCorrelativo += 1;
            
            $idMascota = $data['propietario_id'].$intCorrelativo;

            $data['id']          = $idMascota;
            $data['correlativo'] = $intCorrelativo;

            //Guardo los datos de la mascota       
            Mascota::create($data);

            return response()->json([
                'message' => "Mascota agregada correctamente",
                'token'   => csrf_token(),

                ]);

            //return redirect()->to('/propietario/'.$data['propietario_id'].'/edit');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        //

         //hago una consulta de la tabla propietarios
        $propietario = Propietario::with('mascota','mascota.color','mascota.especie','mascota.raza')->find($id);

       if($request->ajax())
        {
           
            $view = view('propietario.mascotas',compact('propietario'));
        
            $sections = $view->renderSections();
            
            return response()->json($sections['renderSection']); 
    
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request, $id)
    {
        
        //Tomo los datos de la peticion
        $data = $request->all();

        //Datos para el select colores
        $colores = Color::lists('color','id');



        //hago una consulta de la tabla propietarios
        $propietario = Propietario::with('mascota','mascota.color','mascota.especie','mascota.raza')->find($data['propietario']);

        $mascota = Mascota::find($id);

        
        //Datos para el select de razas
        $razas = Raza::where('especie_id','=',$mascota['especie_id'])->lists('descripcion','id');

        //Datos para el select de alimentos
        $alimentos = Alimento::where('especie_id','=',$mascota['especie_id'])->lists('nombre','id');
        
        if($request->ajax())
        {

            $accion = 'Editar';

            $view = view('mascota.forms.frmMascota',compact('colores','accion','propietario','mascota','razas','alimentos'));
        
            $sections = $view->renderSections();
           
            return response()->json($sections['renderFormulario']); 
            
        }
       
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validacion de datos

        $this->validate($request, [

            'nombre'        => ['required','max:60'] ,
            'especie_id'    => ['required'] ,
            'peso'          => ['integer'],
            'raza_id'       => ['exists:razas,id'],
            'alimento_id'   => ['exists:alimentos,id'],

        ],
        [
            'especie_id.required' => "El campo especie es obligatorio",
            'raza_id.exists'      => "El campo raza es obligatorio",
            'alimento_id.exists'  => "El campo alimento es obligatorio",
            
        ]);

        if($request->ajax())
        {
            //Primero busco el propietario en la BD
            $mascota = Mascota::find($id);

            //Actualizo con el metodo fill
            $mascota->fill($request->all());
            $mascota->save();


            return response()->json([
                'message' => "Mascota modificada correctamente",
                'token'   => csrf_token(),

                ]);

            return redirect()->to('/propietario/'.$request->input('id').'/edit');    
        }
        
    }

    
    public function destroy($id, Request $request)
    {
        if($request->ajax())
        {

            //Elimino el registro
            Mascota::find($id)->delete();

            return response()->json(['message'=>'Registro eliminado correctamente']);

        }
    }

   
}
