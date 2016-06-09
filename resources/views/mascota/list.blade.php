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
	
	
	<table class="table table-striped table-hover table-bordered" id='tabla'>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Especie</th>
			<th>Raza</th>
			<th>Color</th>
			<th>Propietario</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		@foreach($results as $result)
			<tr data-id='{{ $result->id }}'>
				<td>{{ $result->nombre }}</td>
				<td>{{ $result->raza->especie->descripcion }}</td>
				<td>{{ $result->raza->descripcion }}</td>
				<td>{{ $result->color->color}}</td>
				<td>{{ $result->propietario->nombres}}, {{ $result->propietario->apellidos }}</td>
				
				<td>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar" id="Editar">
						<i class="fa fa-pencil"></i>
					</button>

					<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar" id="Eliminar">
						<i class="fa fa-trash"></i>
					</button>
                    
                </td>
			</tr>
		@endforeach
	</tbody>
	</table>

	</div>
@endsection