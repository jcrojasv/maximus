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
    $('#tabla').DataTable({
    	"order": [[ 0, "desc" ]],
    	responsive: true,
    	stateSave:  true,
	   "language": { "url": "/i18n/dataTable.spanish.lang"},
	   
	   	
    });

        
});

</script>
@endsection

@section('cuerpo')
	
<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Listado de General de Ordenes <span class=""></span></h1>
		</div>
	
	
	<table class="table table-striped table-hover table-bordered" id='tabla'>
	<thead>
		<tr>
			<th>N&deg; Orden</th>
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
	@foreach($ordenes as $orden)
		<tr data-id='{{ $orden->id }}' @if($orden->estatus) class='success' @endif>
			<td>{{ $orden->id }}</td>
			<td>@if($orden->estatus) <strong>En proceso</strong> @else Finalizada @endif</td>
			<td>@if($orden->estatus) <strong>{{ $orden->nombre }}</strong> @else {{ $orden->nombre }} @endif </td>
			<td>{{ $orden->fecha }}</td>
			<td>{{ $orden->entrada }} <br/> {{ $orden->salida }}</td>
			<td>{{ $orden->nb_propietario }}, {{ $orden->ap_propietario }}</td>
			<td>{{ $orden->fijo }}<br/>
			{{ $orden->movil }}</td>

			<td>
				{{ link_to_route('orden.edit', 'Editar', ['id'=> $orden->id ], ['class'=>'btn btn-warning btn-sm']) }}
            	
            	{{ link_to_route('orden.destroy', 'Eliminar', ['id'=> $orden->id ], ['class'=>'btn btn-danger btn-sm']) }}
                
            </td>
		</tr>
	@endforeach
	</tbody>
	</table>

</div>
@endsection