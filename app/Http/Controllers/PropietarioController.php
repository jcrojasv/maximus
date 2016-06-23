<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $results = Propietario::with('mascota.especie')->orderBy('nombres','asc')->get();
        
        return view('propietario/list',compact('results'));
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
            'email'         => ['required','max:60','email'] ,
            'direccion'     => ['required','max:120'],

        ],
        [
            'id.required'   => "El campo cedula es obligatorio",
            'id.integer'    => "El campo cedula debe ser un n&uacute;mero",
        ]
        );
        
        //Separo los datos de los formularios
        $data = $request->all();

        Propietario::create($data);

        Session::flash('message','Propietario creado exitosamente');

        return redirect()->to('/propietario/'.$request->input('id').'/edit');
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
        return view('propietario/create');
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
        //Primero busco el propietario en la BD
        $propietario = Propietario::find($id);

        //Actualizo con el metodo fill
        $propietario->fill($request->all());
        $propietario->save();

        //Genero el mensaje de exito
        Session::flash('message','Datos actualizados exitosamente');

        return redirect()->to('/propietario/'.$request->input('id').'/edit');
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
        return $id;
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
        foreach ($razas as $raza) {
            $selected = ($raza->id == $idSeleccionado) ? 'selected' : '';
            $strHtml .= sprintf("<option value='%d' %s>%s</option>",$raza->id,$selected, $raza->descripcion);   

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
        foreach ($alimentos as $alimento) {
            $selected = ($alimento->id == $idSeleccionado) ? 'selected' : '';
            $strHtml .= sprintf("<option value='%d' %s>%s</option>",$alimento->id,$selected,$alimento->nombre);

        }
        $strHtml .= "</select>";

        return $strHtml;
    }

        
    
}
