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
		@foreach($results as $result)
			<tr data-id='{{ $result->id }}'>
				<td>{{ $result->nombres }}, {{ $result->apellidos }}</td>
				<td>{{ $result->id }}</td>
				<td>{{ $result->telefono_fijo }}<br/>
				{{ $result->telefono_celular }}</td>

				<td>
					<ul>
					@foreach($result->mascota as $mascota)
						<li>{{ $mascota->nombre }}</li>
					@endforeach
					</ul>
				</td>
				<td>
					<a href="{{ route('propietario.edit',['id'=>$result->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class='fa fa-pencil'></i></a>
				
					<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="{{ $result->id }}" ><i class="fa fa-trash"></i></button>
                    
                </td>
			</tr>
		@endforeach
	</tbody>
	</table>

	</div>
@endsection