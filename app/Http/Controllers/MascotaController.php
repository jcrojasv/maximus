<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

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
        //Hago la consulta general
       return view('mascota.index');
        
    }
    /**
     * Muesta el listado general de mascotas
     *
     * @return \Illuminate\Http\Response
     */
    public function listado(Request $request)
    {
        
        if($request->ajax())
        {


            $tablaMascotas = new Mascota();

            $mascotas = $tablaMascotas->listadoGeneral();
            

            return Datatables::of($mascotas)
            ->setRowId('id')
            ->addColumn('id',function($mascota){
                return $mascota->id;
            })
            ->addColumn('nombre',function($mascota){
                return $mascota->nombre;
            })
            
            ->addColumn('especie',function($mascota){
                return $mascota->especie." / ".$mascota->raza;
            })
            ->addColumn('color',function($mascota){
                return $mascota->color;
            })
            ->addColumn('propietario', function($mascota){
                return $mascota->nb_propietario.', '.$mascota->ap_propietario;
            })
            ->addColumn('action', function ($mascota) {
                
                $ruta = route('mascota.edit',$mascota->id);

                $strHtml = sprintf('<button type="button" class="btn btn-warning btn-sm btn-edit" data-toggle="tooltip" data-placement="top" title="Editar" data-id="%d" onClick="$(this).editar(%d)"><i class="fa fa-pencil"></i></button> ',$mascota->id,$mascota->propietario_id);
                $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%s"onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$mascota->id);

                return $strHtml;
            })
            ->make(true);
        }

        return view('mascota.index');

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
        $colores = Color::orderBy('color','asc')->lists('color','id');

        $propietario = Propietario::find($data['propietario']);

        if($request->ajax())
        {

            $accion = 'Agregar';

            $view = view('mascota.forms.frmMascotaRenderPropietario',compact('colores','accion','propietario'));
        
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

            'id'            => ['required','integer'],
            'nombre'        => ['required','max:60'] ,
            'especie_id'    => ['required'] ,
            'raza_id'       => ['exists:razas,id'],
            'alimento_id'   => ['exists:alimentos,id'],

        ],
        [
            'id.required'         => "El campo N&deg; ficha es obligatorio",
            'especie_id.required' => "El campo especie es obligatorio",
            'raza_id.exists'      => "El campo raza es obligatorio",
            'alimento_id.exists'  => "El campo alimento es obligatorio",
            
        ]);
      
        if($request->ajax())
        {
           

            //Tomo los datos del formulario
            $data = $request->all();
            /*
            //Busco el ultimo id generado
            $lastId = Mascota::max('id');
            $data['id'] = $lastId + 1;
            */
            //Guardo los datos de la mascota       
            Mascota::create($data);

            return response()->json([
                'message' => "Mascota agregada correctamente",
                'token'   => csrf_token(),

                ]);

          
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
        $colores = Color::orderBy('color','asc')->lists('color','id');


        //hago una consulta de la tabla propietarios
        $propietario = Propietario::with('mascota','mascota.color','mascota.especie','mascota.raza')->find($data['propietario']);

        $mascota = Mascota::find($id);

        
        //Datos para el select de razas
        $objRazas = new Raza();
        $razas = $objRazas->getRazasById($mascota['especie_id']);
        

        //Datos para el select de alimentos
        $objAlimentos = new Alimento();
        $alimentos = $objAlimentos->getAlimentosById($mascota['especie_id']);
        
        if($request->ajax())
        {

            $accion = 'Editar';
            
            $view = view($data['vista'],compact('colores','accion','propietario','mascota','razas','alimentos'));
        
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

            'nombre'        => ['required','max:60'],
            'especie_id'    => ['required'],
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

            $data = $request->all();
          
            return response()->json(['message'=>'Los datos se modificaron correctamente', 'token'   => csrf_token()  ]);

            //return redirect()->to('/propietario/'.$request->input('id').'/edit');    
        }
        
    }

    
    public function destroy($id, Request $request)
    {
        if($request->ajax())
        {

            try
            {
                //Elimino el registro
                Mascota::findOrFail($id)->delete();

                return response()->json(['message'=>'Registro eliminado correctamente']);    

            } catch(\Illuminate\Database\QueryException $e) {

                return response()->json(['message'=>'Error '.$e->errorInfo[1].', no fue posible eliminar el registro'],500);

            }
            

        }
    }

    

   
}
