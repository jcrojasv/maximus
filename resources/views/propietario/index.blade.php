@extends('layouts/app')

@section('title','Listado de Propietarios') 

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
       "ajax": "/propietario/show",
       "columns": [
       		{data: 'nombres'},
       		{data: 'id'},
       		{data: 'telefonos'},
       		{data: 'mascotas'},
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
			<h2 class="page-header">Listado de Propietarios <span class="fa fa-users"></span></h2>
		</div>
	</div>

	<div class="row">
		@include('partials.mensajes')
	</div>
	
	<div class="row">
		<table class="table table-striped table-hover table-bordered" id='tabla'>
		<thead>
			<tr>
				<th>Nombres</th>
				<th>C&eacute;dula</th>
				<th>Tel&eacute;fonos</th>
				<th>Mascotas</th>
				<th>Acci&oacute;n</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>

	</div>
	<!-- formulario para eliminar orden -->
	{{ Form::open(['route' => ['propietario.destroy',':ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) }}

	{{ Form::close() }}
@endsection