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
        $results = Propietario::with('mascota')->orderBy('nombres','asc')->get();
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
        $propietario = Propietario::with('mascota.color','mascota.raza.especie')->find($id);

        //Datos para el select colores
        $colores = Color::lists('color','id');
        
        //Atributos para el formulario de mascotas
        $arrAtributosForm = ['strClaseForm'=>'open','strMethod'=>'post','strRuta'=>'mascota.store'];
       
        return view('propietario.edit',compact('propietario','colores','arrAtributosForm'));
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

        return view('propietario.edit',['propietario'=>$propietario]);
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

        $razas = $table->getRazasById($id);
        
        $strHtml = "<select name='raza_id' id='raza_id' class='form-control'>";
        $strHtml .= sprintf("<option value='%d'>%s</option>",0,'-->Seleccione una raza<--');
        foreach ($razas as $raza) {
        
            $strHtml .= sprintf("<option value='%d'>%s</option>",$raza->id,$raza->descripcion);   

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

        $alimentos = $table->getAlimentosById($id);
        
        $strHtml = "<select name='alimento_id' id='alimento_id' class='form-control'>";
        $strHtml .= sprintf("<option value='%d'>%s</option>",0,'-->Seleccione un alimento<--');
        foreach ($alimentos as $alimento) {
        
            $strHtml .= sprintf("<option value='%d'>%s</option>",$alimento->id,$alimento->nombre);

        }
        $strHtml .= "</select>";

        return $strHtml;
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
            
            //Tomo los datos del formulario
            $strMascota = (!is_null($request->input('mascota'))) ? $request->input('mascota') : '';
            $strPropietario = (!is_null($request->input('propietario'))) ? $request->input('propietario') : '';

            //Realizo la consulta en el modelo
            $objTable = new Mascota();
            $objResult = $objTable->buscarMascota($strMascota,$strPropietario);

            $strHtml = "<table class='table table-striped table-hover'>";
            $strHtml.= "<thead><tr><th>Mascota</th><th>Raza</th><th>Propietario</th><th>Accion</th></tr></thead><tbody>";
     
            foreach ($objResult as $objMascota) 
            {
            
                $strHtml.=sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td><button type='button' onClick='return miFuncion(%d);' class='btnSelect'>Select</button></td></tr>",
                
                $objMascota->nombre,
                $objMascota->descripcion,
                $objMascota->nombres,
                $objMascota->id
                );

            }

            $strHtml.="</tbody></table>";
       
            return $strHtml;

       }
        
    }
    
    
}
