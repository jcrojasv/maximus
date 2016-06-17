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

            //Creo el html para el mensaje de exito
            $strMensajeExito = 'Mascota agregada correctamente';


            return response()->json([
                'message' => "Mascota agregada correctamente",
                'token'   => csrf_token(),

                ]);

            //return redirect()->to('/propietario/'.$data['propietario_id'].'/edit');
        }

    }

    public function lista(Request $request)
    {
       

        //Tomo los datos de la peticion
        $data = $request->all();

        $propietario = Propietario::with('mascota.color','mascota.raza.especie')->find($data['id']);

        //Datos para el select colores
        $colores = Color::lists('color','id');

        //Datos para ele select de razas
        $razas   = Raza::lists('descripcion','id');

        //Datos para ele select de alimentos
        $alimentos = Alimento::lists('nombre','id');

        if($request->ajax())
        {
           
            $view = view('propietario.mascotas',compact('propietario','colores','razas','alimentos'));
        
            $sections = $view->renderSections();
            
            return response()->json($sections['renderSection']); 
                    

        } else 

             return view('propietario.edit',compact('propietario','colores'));
    }

    public function edit(Request $request, $id)
    {
        

        if($request->ajax())
        {
            $mascota = Mascota::find($id);

            return response()->json(compact('mascota'));
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
