@extends('layouts/app')

@section('title','Colores') 

@section('estilos')

	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>
	
@endsection

@section('scriptsJs')
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>
<script>
$(document).ready(function(){
    $('#tabla').DataTable({
    	responsive: true,
    	stateSave:  true,
	   "language": { "url": "/i18n/dataTable.spanish.lang"},
	   "processing": true,
       "serverSide": true,
       "ajax": "/colors/listado",
       "columns": [
			{data: 'id'},
       		{data: 'color'},
       		{data: 'action'}

       ]
	   	
    });

    $(function(){
    	$('[data-toggle="tooltip"]').tooltip();
    });


    //Funcion para modificar mascota
	$('#tabla').on('click','a.btn-edit',function(){
		
		var ruta  = "{{ route("colors.index") }}/"+ $(this).data('id')+"/edit";
		

		//lamado ajax metodo get para tomar el formulario
		$.get(ruta,'',function(data) {

        	$('#divFrmEdit').empty().append($(data));
        	
        	//Muestro la ventana modal
        	$('#ventanaModal').modal('toggle');

    	});
	
	});

	//Funcion para modificar mascota
	$('.btn-add').click(function(){
		
		var ruta  = "{{ route("colors.create") }}";
		

		//lamado ajax metodo get para tomar el formulario
		$.get(ruta,'',function(data) {

        	$('#divFrmEdit').empty().append($(data));
        	
        	//Muestro la ventana modal
        	$('#ventanaModal').modal('toggle');

    	});
	
	});

	//Funcion para crear o modificar color
	$('#divFrmEdit').on('click','a.btn-guardar',function(){
		
		var token = $("input[name=_token]").val(); 
		
		$.grabarRegistro('frmColor', token)
		
	});
    
	

});

</script>
@endsection

@section('cuerpo')
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Colores <div class="pull-right"><button class="btn btn-primary btn-add"><i class="fa fa-pencil"></i> Nuevo</button></div></h1>
		</div>
	</div>

	<div class="row">
		@include('partials.mensajes')
	</div>

	<table class="table table-striped table-hover" id='tabla'>
	<thead>
		<tr>
			<th width="10%">Id</th>
			<th width="70%">Color</th>
			
			<th width="20%">Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	</table>


	<!-- formulario para eliminar color -->
	{!! Form::open(['route' => ['colors.destroy',':ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) !!}

	{!! Form::close() !!}

	<!--Formulario para agregar o editar  -->
	<div id="divFrmEdit">
	@section('renderFormulario')
	@endsection
	</div>
@endsection