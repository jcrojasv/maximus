<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Modelos
use App\Alimento;
use App\Especie;
//Fin modelos

use App\Http\Requests;

use Yajra\Datatables\Facades\Datatables;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class AlimentoController extends Controller
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
        return view('alimentos.index');
    }

    /**
     * Muesta el listado general de colores
     *
     * @return \Illuminate\Http\Response
     */
    public function listado(Request $request)
    {
        
        $tabla = new Alimento();

        if($request->ajax())
        {
            
            $alimentos = $tabla->all();
     
            return Datatables::of($alimentos)
            ->setRowId('id')
            ->addColumn('id',function($alimento){
                return $alimento->id;
            })
            ->addColumn('especie',function($alimento){
                return $alimento->especie->descripcion;
            })
            ->addColumn('nomnbre',function($alimento){
                return $alimento->nombre;
            })
                       
            ->addColumn('action', function ($alimento) {
                
                $ruta = route('alimentos.edit',$alimento->id);

                $strHtml = sprintf('<a href="#" class="btn btn-warning btn-sm btn-edit" data-toggle="tooltip" data-placement="top" title="Editar" data-id="%d"><i class="fa fa-pencil"></i></a> ',$alimento->id);
                $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%d" onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$alimento->id);

                return $strHtml;
            })
            ->make(true);
        }

        return view('alimentos.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $especies = Especie::all()->lists('descripcion','id');

        if($request->ajax())
        {

            $accion = 'Agregar';
                
            $view = view('alimentos.forms.frmAlimento',compact('accion','especies'));
            
            $sections = $view->renderSections();
               
            return response()->json($sections['renderFormulario']); 
            
        } else {

            return view('alimentos');

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
        //
        $this->validate($request,[

            'nombre'         =>  'required',
            'especie_id'     =>  'required'
            
            ],

            [
            'especie_id.required' => "El campo especie es requerido",
            ]

            );

        $alimento = new Alimento();

        if($request->ajax())
        {

            $data = $request->all();

            $data['id'] = $this->generarId($data['especie_id']);

            $data['correlativo'] = $alimento->getUltimoCorrelativo($data['especie_id'])+1;

            $alimento->create($data);

            return response()->json(['message'=>'Registro creado correctamente']); 
            
        } else {

            return view('alimentos');

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
    public function edit($id, Request $request)
    {
        //

        $alimento = Alimento::find($id);

        $especies = Especie::all()->lists('descripcion','id');

        if($request->ajax())
        {

            if(!empty($alimento))
            {

                $accion = 'Editar';
                
                $view = view('alimentos.forms.frmAlimento',compact('accion','alimento','especies'));
            
                $sections = $view->renderSections();
               
                return response()->json($sections['renderFormulario']); 

            } else {

                return response()->json(['message'=>'No existe el registro indicado']);

            }

            
        } else {

            return view('alimentos');

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
        //
        $alimento = Alimento::findOrFail($id);

        try{

            if($request->ajax())
            {

                $data = $request->all();


                if(empty($alimento))
                {
                    return response()->json(['message'=>'No existe el registro']);
                
                } else {

                    //Verifico la especie
                    if($data['especie_id'] == $alimento->especie_id)
                    {
                        //Actualizo con el metodo fill
                        $alimento->fill($data);
                        $alimento->touch();
                        $alimento->save(); 

                    } else {

                        //Debo eliminar el registro
                        $alimento->delete();
                        
                        //Genero el nuevo id
                        $data['id'] = $this->generarId($data['especie_id']);

                        $data['correlativo'] = $alimento->getUltimoCorrelativo($data['especie_id'])+1;

                        //Creo el nuevo registro
                        $alimento->create($data);

                    }
                    

                    return response()->json(['message'=>'Los datos se modificaron correctamente']);

                }

            } else {

                return view('alimentos.index');

            }

        } catch (\Illuminate\Database\QueryException $e) {

            //Genero el mensaje de exito
            Session::flash('message','Error '.$e->errorInfo[1].', no fue posible actualizar la orden');
            Session::flash('error', 'alert-danger');

            return redirect()->to('/alimentos/');
            

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        if($request->ajax())
        {
            try {

                Alimento::findOrFail($id)->delete();

                return response()->json(['message'=>'Registro eliminado correctamente']);

            }catch (\Illuminate\Database\QueryException $e) {

                /*En caso de poder eliminar el registro, capturo la excepcion y envio un mensaje con el
                * Codigo del error, y estatus 500 para que la aplicacion sepa que se trata de un error
                */

                return response()->json(['message'=>'Error '.$e->errorInfo[1].', no fue posible eliminar el registro'],500);
            }

        }
    }

    public function generarId($especieId)
    {

        $alimento = new Alimento();

        $mil = $especieId * 1000;

        $id = ($alimento->getUltimoCorrelativo($especieId)+1) + $mil;

        return $id;

    }
}
