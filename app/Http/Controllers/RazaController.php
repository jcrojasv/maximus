<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Modelos
use App\Raza;
use App\Especie;
//Fin modelos

use App\Http\Requests;

use Yajra\Datatables\Facades\Datatables;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class RazaController extends Controller
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
        return view('razas.index');
    }

    /**
     * Muesta el listado general de colores
     *
     * @return \Illuminate\Http\Response
     */
    public function listado(Request $request)
    {
        
        $tabla = new Raza();

        if($request->ajax())
        {
            
            $razas = $tabla->all();
     
            return Datatables::of($razas)
            ->setRowId('id')
            ->addColumn('id',function($raza){
                return $raza->id;
            })
            ->addColumn('especie',function($raza){
                return $raza->especie->descripcion;
            })
            ->addColumn('descripcion',function($raza){
                return $raza->descripcion;
            })
                       
            ->addColumn('action', function ($raza) {
                
                $ruta = route('razas.edit',$raza->id);

                $strHtml = sprintf('<a href="#" class="btn btn-warning btn-sm btn-edit" data-toggle="tooltip" data-placement="top" title="Editar" data-id="%d"><i class="fa fa-pencil"></i></a> ',$raza->id);
                $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%d" onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$raza->id);

                return $strHtml;
            })
            ->make(true);
        }

        return view('razas.index');

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
                
            $view = view('razas.forms.frmRaza',compact('accion','especies'));
            
            $sections = $view->renderSections();
               
            return response()->json($sections['renderFormulario']); 
            
        } else {

            return view('razas');

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
            'descripcion'    =>  'required',
            'especie_id'     =>  'required'
            ],

            [
            'especie_id.required' => "El campo especie es requerido",
            ]

            );

        $raza = new Raza();

        if($request->ajax())
        {

            $data = $request->all();

            $data['id'] = $this->generarId($data['especie_id']);

            $raza->create($data);

            return response()->json(['message'=>'Registro creado correctamente']); 
            
        } else {

            return view('razas');

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

        $raza = Raza::find($id);

        $especies = Especie::all()->lists('descripcion','id');

        if($request->ajax())
        {

            if(!empty($raza))
            {

                $accion = 'Editar';
                
                $view = view('razas.forms.frmRaza',compact('accion','raza','especies'));
            
                $sections = $view->renderSections();
               
                return response()->json($sections['renderFormulario']); 

            } else {

                return response()->json(['message'=>'No existe el registro indicado']);

            }

            
        } else {

            return view('colors');

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
        $raza = raza::findOrFail($id);

        try{

            if($request->ajax())
            {

                $data = $request->all();


                if(empty($raza))
                {
                    return response()->json(['message'=>'No existe el registro']);
                
                } else {

                    //Verifico la especie
                    if($data['especie_id'] == $raza->especie_id)
                    {
                        //Actualizo con el metodo fill
                        $raza->fill($data);
                        $raza->touch();
                        $raza->save(); 
                           
                    } else {

                        //Debo eliminar el registro
                        $raza->delete();
                        
                        //Genero el nuevo id
                        $data['id'] = $this->generarId($data['especie_id']);

                        //Creo el nuevo registro
                        $raza->create($data);

                    }
                    

                    return response()->json(['message'=>'Los datos se modificaron correctamente']);

                }

            } else {

                return view('razas.index');

            }

        } catch (\Illuminate\Database\QueryException $e) {

            //Genero el mensaje de exito
            Session::flash('message','Error '.$e->errorInfo[1].', no fue posible actualizar la orden');
            Session::flash('error', 'alert-danger');

            return redirect()->to('/razas/');
            

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

                Raza::findOrFail($id)->delete();

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

        $raza = new Raza();

        $mil = $especieId * 1000;

        $id = ($raza->getUltimoCorrelativo($especieId)+1) + $mil;

        return $id;

    }
}
