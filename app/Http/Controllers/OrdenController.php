<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mascota;
use App\Arreglo;

class OrdenController extends Controller
{
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        if($request->ajax())
        {

            //Tomo los datos de la peticion
            $data = $request->all();
            $mascotaId = $data['mascota_id'];

            //Cargo los datos de los arreglos
            $arreglosGen = Arreglo::where('tipo','=','GEN')->orderBy('descripcion','asc')->lists('descripcion','id');

            //Paso los datos de la vista a una variable para poder volcar en 
            $view = view('orden.create',compact('arreglosGen','mascotaId'));

            //Tomo solo los datos de las secciones que contiene la vista
            $sections = $view->renderSections();

            //Retorno los datos en formato json para volcar el formulario en la vista
            return response()->json($sections['sectionFrmOrden']);
        }

        return view('orden.create');

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Separo los datos de los formularios
        $data = $request->all();

       //Validacion de datos

        $this->validate($request, [

            'fecha'         => ['required','','date'],
            'entrada'       => ['required'],
            'tipo'          => ['required'],
            'arregloGen'    => ['required'],
            'arregloEsp'    => ['required_if:tipo,ESP']
         
        ],[

            'entrada.required'       => 'La hora de entrada es requedida',
            'tipo.required'          => 'El tipo de servicio es requerido',
            'arregloGen.required'    => 'Debe seleccionar al menos un arreglo general',
            'arregloEsp.required_if' => 'Debe seleccionar al menos un arreglo especializado'

        ]

        );
        
        //Genero la orden
        $orden = Orden::create($data);

        //Almaceno en la tabla Orden_arreglos, los arreglos generales
        foreach ($data['arregloGen'] as $value) {
            ArregloOrden::create(array('orden_id'=>$orden->id,'arreglo_id'=>$value));
        }

        if(isset($arregloEsp))
        {
            //Genero los datos de los arreglos
            foreach ($data['arregloEsp'] as $value) {
                ArregloOrden::create(array('orden_id'=>$orden->id,'arreglo_id'=>$value));
            }
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Busqueda de mascotas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return object
     */

    public function buscarMascota(Request $request)
    {

        if($request->ajax())
        {
             //Cargo los datos de los arreglos
            $arreglosGen = Arreglo::where('tipo','=','GEN')->orderBy('descripcion','asc')->lists('descripcion','id');

            $data = $request->all();

            //Inicializo la variable mascotaId para que no de error en las plantillas renderizadas
            $mascotaId = '';

            //Tomo los datos del formulario
            $strMascota = (!is_null($data['mascota'])) ? $data['mascota'] : '';
            $strPropietario = (!is_null($data['propietario'])) ? $data['propietario'] : '';

            //Realizo la consulta en el modelo
            $objTable = new Mascota();
            $objResult = $objTable->buscarMascota($strMascota,$strPropietario);

            $view = view('orden.create',compact('objResult','arreglosGen','mascotaId'));
         
            $sections = $view->renderSections();
            
            return response()->json($sections['listadoBusqueda']);

       }

       
        
    }

    /**
     * Seleccion de los datos de las mascotas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return object
     */

    public function selectMascota(Request $request)
    {

        if($request->ajax())
        {
            
            $data = $request->all();
            $mascotaId = $data['id'];

            //Realizo la consulta en el modelo
            $objTable = new Mascota();
            $resultMascota = $objTable->selectMascota($mascotaId);

            $view = view('orden.create',compact('resultMascota','mascotaId'));
         
            $sections = $view->renderSections();
            
            return response()->json($sections['sectionDatos']);

       }

       
        
    }

    /**
     * Seleccion de los datos de para las opciones especializadas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return object
     */

    public function esp(Request $request)
    {

        if($request->ajax())
        {
            
             //Cargo los datos de los arreglos
            $arreglosGen = Arreglo::where('tipo','=','GEN')->orderBy('descripcion','asc')->lists('descripcion','id');

            $data = $request->all();

            $mascotaId = '';

            //Realizo la consulta en el modelo
            $objTable = new Arreglo();
            $arreglosEsp = $objTable->where('tipo','=','ESP')->orderBy('descripcion')->lists('descripcion','id');
            
            $view = view('orden.create',compact('arreglosEsp','arreglosGen','mascotaId'));
         
            $sections = $view->renderSections();
            
            return response()->json($sections['sectionEsp']);

       }

       
        
    }
}
