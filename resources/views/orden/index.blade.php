@extends('layouts/app')

@section('title','Listado de General de Ordenes') 

@section('estilos')

	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>
	
@endsection

@section('scriptsJs')
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>
<script>
$(document).ready(function(){

	//Funcion para cargar el tooltip
	$(function () {$('[data-toggle="tooltip"]').tooltip()});

	//Funcion para cargar datatable
	$('#tabla').DataTable({
    	responsive: true,
    	stateSave:  true,
	   "language": { "url": "/i18n/dataTable.spanish.lang"},
	   "processing": true,
       "serverSide": true,
       "ajax": "/orden/show",
       "columns": [
       		{data: 'id'},
       		{data: 'estatus'},
       		{data: 'mascota'},
       		{data: 'fecha'},
       		{data: 'io'},
       		{data: 'propietario'},
       		{data: 'telefonos'},
       		{data: 'action'},

       ],
       "order": [[ 3, "desc" ]],
       "aaSorting": [[ 3, "desc" ]]
	   	
    });

	
        
});

</script>
@endsection

@section('cuerpo')

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Listado de General de Ordenes <span class=""></span></h2>
	</div>
</div>


<div class="row">
	@include('partials.mensajes')
</div>


<div class="row">
		
	<table class="table table-striped table-hover table-bordered" id='tabla'>
	<thead>
		<tr>
			<th>N&deg;</th>
			<th>Estatus</th>
			<th>Mascota</th>
			<th>Fecha</th>
			<th>Ent/Sal</th>
			<th>Prop.</th>
			<th>Telf.</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	</table>
	
</div>

<!-- formulario para eliminar orden -->
{{ Form::open(['route' => ['orden.destroy',':ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) }}

{{ Form::close() }}

@endsection