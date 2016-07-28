<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Yajra\Datatables\Facades\Datatables;

use Session;

use App\Color;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Response;

class ColorController extends Controller
{

	

	function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the Color.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('colors.index');
	}

	/**
     * Muesta el listado general de colores
     *
     * @return \Illuminate\Http\Response
     */
    public function listado(Request $request)
    {
        
		$tabla = new Color();

        if($request->ajax())
        {
            
            $colores = $tabla->all();
     
            return Datatables::of($colores)
            ->setRowId('id')
            ->addColumn('id',function($color){
                return $color->id;
            })
            ->addColumn('color',function($color){
                return $color->color;
            })
                       
            ->addColumn('action', function ($color) {
                
                $ruta = route('colors.edit',$color->id);

                $strHtml = sprintf('<a href="#" class="btn btn-warning btn-sm btn-edit" data-toggle="tooltip" data-placement="top" title="Editar" data-id="%d"><i class="fa fa-pencil"></i></a> ',$color->id);
                $strHtml .= sprintf('<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="%d"onclick="$(this).eliminar()"><i class="fa fa-trash"></i></button>',$color->id);

                return $strHtml;
            })
            ->make(true);
        }

        return view('colors.index');

    }

	/**
	 * Show the form for creating a new Color.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		if($request->ajax())
        {

        	$accion = 'Agregar';
	            
	        $view = view('colors.forms.frmColor',compact('accion'));
	        
	        $sections = $view->renderSections();
	           
	        return response()->json($sections['renderFormulario']); 
            
        } else {

        	return view('colors');

        }
	}

	/**
	 * Store a newly created Color in storage.
	 *
	 * @param CreateColorRequest $request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

		$this->validate($request,[
			'color'    =>  'required'
			]);
		
		if($request->ajax())
        {

        	$data = $request->all();

        	$color = Color::create($data);

        	return response()->json(['message'=>'Registro creado correctamente']); 
            
        } else {

        	return view('colors');

        }

	}

	/**
	 * Display the specified Color.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$color = Color::find($id);

		if(empty($color))
		{
			Flash::error('Color not found');

			return redirect(route('colors.index'));
		}

		return view('colors.show')->with('color', $color);
	}

	/**
	 * Show the form for editing the specified Color.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit($id, Request $request)
	{
		$color = Color::find($id);

		if($request->ajax())
        {

        	if(!empty($color))
        	{

			    $accion = 'Editar';
	            
	            $view = view('colors.forms.frmColor',compact('accion','color'));
	        
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
	 * Update the specified Color in storage.
	 *
	 * @param  int              $id
	 * @param UpdateColorRequest $request
	 *
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		
		$color = Color::findOrFail($id);

		try{

			if($request->ajax())
			{

				$data = $request->all();
		
				if(empty($color))
				{
					return response()->json(['message'=>'No existe el registro']);
				
				} else {

					//Actualizo con el metodo fill
		            $color->fill($data);
		            $color->touch();
		            $color->save();

	                return response()->json(['message'=>'Los datos se modificaron correctamente']);

				}

			} else {

				return view('colors.index');

			}

		} catch (\Illuminate\Database\QueryException $e) {

            //Genero el mensaje de exito
            Session::flash('message','Error '.$e->errorInfo[1].', no fue posible actualizar la orden');
            Session::flash('error', 'alert-danger');

            return redirect()->to('/colors/');
            

        }
		
	}

	/**
	 * Remove the specified Color from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy(Request $request, $id)
	{
		//
        if($request->ajax())
        {
            try {

                Color::findOrFail($id)->delete();

                return response()->json(['message'=>'Registro eliminado correctamente']);

            }catch (\Illuminate\Database\QueryException $e) {

                /*En caso de poder eliminar el registro, capturo la excepcion y envio un mensaje con el
                * Codigo del error, y estatus 500 para que la aplicacion sepa que se trata de un error
                */

                return response()->json(['message'=>'Error '.$e->errorInfo[1].', no fue posible eliminar el registro'],500);
            }

        }
	}
}
