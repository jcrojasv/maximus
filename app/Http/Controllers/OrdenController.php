<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

use Session;

use App\Http\Requests;
use App\Mascota;
use App\Arreglo;
use App\Orden;
use App\OrdenArreglo;

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
        
        return view('orden.index');

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
            'arregloEsp'    => ['required_if:tipo,ESP'],
            'arregloGen'    => ['required'],
            
         
        ],[

            'entrada.required'       => 'La hora de entrada es requedida',
            'tipo.required'          => 'El tipo de servicio es requerido',
            'arregloEsp.required_if' => 'Debe seleccionar al menos un arreglo especializado',
            'arregloGen.required'    => 'Debe seleccionar al menos un arreglo general',
            

        ]

        );
        if($request->ajax())
        {
            //Formateo la fecha
            $arrFecha = explode('-',$data['fecha']);
            $data['fecha'] = $arrFecha['2']."-".$arrFecha['1']."-".$arrFecha['0'];
            
            //Digo quien creo el registro
            $data['creado_por'] = $request->user()->id;

            //Seteo la variable estatus
            $data['estatus'] = (isset($data['estatus']) ? 1 : 0);
           
            //Genero la orden
            $orden = Orden::create($data);

            //Almaceno en la tabla Orden_arreglos, los arreglos generales
            $this->addArreglos($data['arregloGen'],$orden->id);

            //Si ha seleccionado arreglos especializados, agrego los mismos
            if(isset($data['arregloEsp']))
            {
                
                $this->addArreglos($data['arregloEsp'],$orden->id);
                
            }
            
            Session::flash('message','Orden generada exitosamente');

            return response()->json(['ordenId'=>$orden->id]);
            
        }

        
    }

    /**
     * Esta funcion me permitira sacar el listodo general de ordenes via ajax usando datatable.
     *
    * @return \Illuminate\Http\Response->json
     */
    public function show()
    {
        //Hago la consulta general
        $tablaOrden = new Orden();
        $ordenes = $tablaOrden->listadoGeneral();

        return Datatables::of($ordenes)
        ->setRowId('id')
        ->addColumn('estatus',function($orden){
            return ($orden->estatus) ? "<strong>En proceso</strong>" : "Finalizada";
        })
        ->addColumn('mascota',function($orden){
            return ($orden->estatus) ? "<strong>$orden->nombre</strong>" : $orden->nombre;
        })
        ->addColumn('fecha',function($orden){
            return $orden->prettyDate('fecha');
        })
        ->addColumn('io',function($orden){
            return $orden->entrada."<br/>".$orden->salida;
        })
        ->addColumn('propietario', function($orden){
            return $orden->nb_propietario.', '.$orden->ap_propietario;
        })
        ->addColumn('telefonos',function($orden){
            return $orden->fijo.'<br/>'.$orden->celular;
        })
        ->addColumn('action', function ($orden) {
            $strHtml = '<a href="'.route('orden.edit',['id'=>$orden->id]).'" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a> ';
            $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%s"onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$orden->id);

            return $strHtml;
        })
        ->setRowClass(function ($orden) {
                return $orden->estatus ? 'alert-danger' : '';
            })
        ->make(true);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Tomo los datos de la orden
        $orden = Orden::find($id);

        //Formateo la fecha de la orden que viene de la BD a formato dd-mm-yyyy
        $fechaFormateada = explode('-',$orden->fecha);
        $orden->fecha = $fechaFormateada[2].'-'.$fechaFormateada[1].'-'.$fechaFormateada[0];

        //Tomo los datos de la mascota(
        $mascota       = new Mascota();
        $resultMascota = $mascota->selectMascota($orden->mascota_id);

        //Cargo los datos de los arreglos generales
        $arreglosGen = Arreglo::where('tipo','=','GEN')->orderBy('descripcion','asc')->lists('descripcion','id');
              
        //Selecciono los datos de los arreglos incluidos en la orden
        $arreglosIncluidos = OrdenArreglo::where('orden_id','=',$orden->id)->lists('arreglo_id')->toArray();

        //Cargo los datos de los arreglos especializados
        $arreglosEspecializados = Arreglo::where('tipo','=','ESP')->orderBy('descripcion','asc')->lists('descripcion','id');

        $cont = 0;
        //Verifico que existan arreglos especializados en la tabla orden arreglos, para mostrarlos
        foreach ($arreglosIncluidos as $value) {
    
            if(array_key_exists($value, $arreglosEspecializados->toArray())){
                $cont++;
            }
        }

        $arreglosEsp = ($cont > 0 ) ? $arreglosEspecializados : null;

        return view('orden.edit',compact('orden','resultMascota','arreglosGen','arreglosIncluidos','arreglosEsp'));
    
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

        //tomo los datos enviados
        $data = $request->all();
        //Primero busco la orden en la BD
        $orden = Orden::find($id);

        //Formateo la fecha
        $arrFecha = explode('-',$data['fecha']);
        $data['fecha'] = $arrFecha['2']."-".$arrFecha['1']."-".$arrFecha['0'];
            
        //Digo quien creo el registro
        $data['modificado_por'] = $request->user()->id;

        //Seteo la variable estatus
        $data['estatus'] = (isset($data['estatus']) ? 1 : 0);
        
        //Actualizo con el metodo fill
        $orden->fill($data);

        //Uso el metodo touch para actualizar el campo updated_at
        $orden->touch();
        
        //Guardo los datos
        $orden->save();


        //Actualizo los datos de orden_arreglos, primero debo buscar los arreglos existentes
        //para eliminarlos y crearlos de nuevo
        OrdenArreglo::where('orden_id','=',$id)->delete();

        //Almaceno en la tabla Orden_arreglos, los arreglos generales
        $this->addArreglos($data['arregloGen'],$id);

        //Si ha seleccionado arreglos especializados, agrego los mismos
        if(isset($data['arregloEsp']))
        {
            
            $this->addArreglos($data['arregloEsp'],$id);
            
        }

        //Genero el mensaje de exito
        Session::flash('message','Los datos de la orden se han actualizado exitosamente');

        return redirect()->to('/orden/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        if($request->ajax())
        {
            
            Orden::find($id)->delete();

            return response()->json(['message'=>'Registro eliminado correctamente']);

        }
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

    private function addArreglos($arr,$id)
    {
        
        //Almaceno en la tabla Orden_arreglos, los arreglos generales
        foreach ($arr as $value) {
            OrdenArreglo::create(array('orden_id'=>$id,'arreglo_id'=>$value));
        }

        
    }
}
