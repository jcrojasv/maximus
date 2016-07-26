<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

use Session;

use App\Orden;
use App\Raza;
use App\Color;
use App\Alimento;
use App\Mascota;
use App\Propietario;


class PropietarioController extends Controller
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
        
        return view('propietario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        
         
        return view('propietario/create');

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
            'nombres'       => ['required','max:25'] ,
            'apellidos'     => ['required','max:25'] ,
            
            'direccion'     => ['required','max:120'],

        ],
        [
            'id.required'   => "El campo cedula es obligatorio",
            'id.integer'    => "El campo cedula debe ser un n&uacute;mero",
        ]
        );
        
        try 
        {
            //Separo los datos de los formularios
            $data = $request->all();

            if($data['email']=='')
                $data['email'] = NULL;

            Propietario::create($data);

            Session::flash('message','Propietario creado exitosamente');

            return redirect()->to('/propietario/'.$request->input('id').'/edit');

        } catch (\Illuminate\Database\QueryException $e) {

            //Genero el mensaje de error
            Session::flash('message','Error '.$e->errorInfo[1].', no se pudo grabar la informacion');
            Session::flash('error', 'alert-danger');

            return view('propietario/create');

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        if($request->ajax())
        {
            //
            $results = Propietario::with('mascota.especie')->orderBy('nombres','asc')->get();

            return Datatables::of($results)
            ->setRowId('id')
            ->addColumn('nombres', function($result){
                return $result->nombres.', '.$result->apellidos;
            })
            ->addColumn('telefonos',function($result){
                return $result->telefono_fijo.'<br/>'.$result->telefono_celular;
            })
            ->addColumn('mascotas',function($result){
                $strHtml = '<ul>';
                foreach ($result->mascota as $mascota) 
                {
                    $strHtml .= sprintf("<li>%s</li>",$mascota->nombre);
                }
                $strHtml .= '</ul>';
                return $strHtml;
            })
            ->addColumn('action', function ($result) {
                $strHtml = '<a href="'.route('propietario.edit',['id'=>$result->id]).'" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a> ';
                $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%s"onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$result->id);

                return $strHtml;
                })
            
            ->make(true);    
        }

        return view('propietario.index');
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //hago una consulta de la tabla propietarios
        $propietario = Propietario::with('mascota','mascota.color','mascota.especie','mascota.raza')->find($id);
       
        return view('propietario.edit',compact('propietario'));
       
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
        
        try {
            //Primero busco el propietario en la BD
            $propietario = Propietario::find($id);

            //Separo los datos de los formularios
            $data = $request->all();

            if($data['email']=='')
                $data['email'] = NULL;
            
            //Actualizo con el metodo fill
            $propietario->fill($request->all());
            $propietario->save();

            //Genero el mensaje de exito
            Session::flash('message','Datos actualizados exitosamente');

            return redirect()->to('/propietario/'.$request->input('id').'/edit');

        } catch (\Illuminate\Database\QueryException $e) {

            //Genero el mensaje de exito
            Session::flash('message','Error '.$e->errorInfo[1].', no fue posible actualizar los datos del propietario');
            Session::flash('error', 'alert-danger');

            return redirect()->to('/propietario/'.$request->input('id').'/edit');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        if($request->ajax())
        {
            try {

                Propietario::findOrFail($id)->delete();

                return response()->json(['message'=>'Registro eliminado correctamente']);

            }catch (\Illuminate\Database\QueryException $e) {

                /*En caso de poder eliminar el registro, capturo la excepcion y envio un mensaje con el
                * Codigo del error, y estatus 500 para que la aplicacion sepa que se trata de un error
                */

                return response()->json(['message'=>'Error '.$e->errorInfo[1].', no fue posible eliminar el registro'],500);

            }

        }
    }


     /**
     * Selecciona las razas segun la especie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return json
     */
    public function cargarRazasJquery(Request $request)
    {

        $table = new Raza();

        $id = $request->input('id');
        $idSeleccionado = $request->input('idSeleccionado');

        $razas = $table->getRazasById($id);
        
        $strHtml = "<select name='raza_id' id='raza_id' class='form-control'>";
        $strHtml .= sprintf("<option value='%d'>%s</option>",0,'-->Seleccione una raza<--');
        
        foreach ($razas as $clave=>$valor) {
            $selected = ($clave == $idSeleccionado) ? 'selected' : '';
            $strHtml .= sprintf("<option value='%d' %s>%s</option>",$clave,$selected, $valor);   

        }
        $strHtml .= "</select>";

        return $strHtml;
    }

    /**
     * Selecciona los alimentos segun la especie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return html
     */
    public function cargarAlimentosJquery(Request $request)
    {

        $table = new Alimento();

        $id = $request->input('id');
        $idSeleccionado = $request->input('idSeleccionado');

        $alimentos = $table->getAlimentosById($id);
        
        $strHtml = "<select name='alimento_id' id='alimento_id' class='form-control'>";
        $strHtml .= sprintf("<option value='%d'>%s</option>",0,'-->Seleccione un alimento<--');
        foreach ($alimentos as $clave => $valor) {
            $selected = ($clave == $idSeleccionado) ? 'selected' : '';
            $strHtml .= sprintf("<option value='%d' %s>%s</option>",$clave,$selected,$valor);

        }
        $strHtml .= "</select>";

        return $strHtml;
    }

        
    
}
