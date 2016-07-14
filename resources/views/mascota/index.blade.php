@extends('layouts/app')

@section('title','Listado de Mascotas') 

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
       "ajax": "/mascota/listado",
       "columns": [
			{data: 'id'},
       		{data: 'nombre'},
       		{data: 'especie'},
       		{data: 'color'},
       		{data: 'propietario'},
       		{data: 'action'}

       ]
	   	
    });

    $(function(){
    	$('[data-toggle="tooltip"]').tooltip();
    });


    
	

});

</script>
@endsection

@section('cuerpo')
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Listado de Mascotas <span class="fa fa-github-alt"></span></h1>
		</div>
	</div>

	<div class="row">
		@include('partials.mensajes')
	</div>

	<table class="table table-striped table-hover table-bordered" id='tabla'>
	<thead>
		<tr>
			<th>Ficha n&deg;</th>
			<th>Nombre</th>
			<th>Esp/Raza</th>
			<th>Color</th>
			<th>Propietario</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
	</table>


	<!-- formulario para eliminar mascota -->
	{{ Form::open(['route' => ['mascota.destroy',':ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) }}

	{{ Form::close() }}

	<!--Formulario para editar mascotas -->
	<div id="divFrmMascota">
	@section('renderFormulario')
	@endsection
	</div>
@endsection