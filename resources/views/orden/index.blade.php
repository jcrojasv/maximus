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

	//Funcion para eliminar mascotas
	$('.btn-delete').on('click',function(){
		var row  = $(this).parents('tr');
		var id   = row.data('id');
		var form = $('#frmDelete');
		var ruta = form.attr('action').replace(':ORDEN_ID',id);
		var data = form.serialize();

		if(confirm("Estas seguro de eliminar este registro?"))
		{
			$.ajax({
				url: ruta,
				type: 'post',
				dataType: 'json',
				data: data,
				
			}).done(function(respuesta){
				
				$('#pMensajes').html(' ');

				$('#divMensajes').removeClass('hidden').addClass('alert-success').fadeIn();

				$("#pMensajes").html('<strong>Yeah!!</strong> ' + respuesta.message);

				//Desvanezco el row
				row.fadeOut();

				
			});
		}
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
	<div class="pull-right"> 
		{!! $ordenes->render() !!}
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
	@foreach($ordenes as $orden)
		<tr data-id='{{ $orden->id }}' @if($orden->estatus) class='success' @endif>
			<td>{{ $orden->id }}</td>
			<td>@if($orden->estatus) <strong>En proceso</strong> @else Finalizada @endif</td>
			<td>@if($orden->estatus) <strong>{{ $orden->nombre }}</strong> @else {{ $orden->nombre }} @endif </td>
			<td>{{ $orden->prettyDate('fecha') }}</td>
			<td>{{ $orden->entrada }} <br/> {{ $orden->salida }}</td>
			<td>{{ $orden->nb_propietario }}, {{ $orden->ap_propietario }}</td>
			<td>{{ $orden->fijo }}<br/>
			{{ $orden->movil }}</td>

			<td>
				<a href="{{ route('orden.edit',['id'=>$orden->id])}}" class="btn btn-warning btn-sm"><i class='fa fa-pencil'></i></a>
				
				<button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="{{ $orden->id }}" ><i class="fa fa-trash"></i></button>
      	            	
                
            </td>
		</tr>
	@endforeach
	</tbody>
	</table>
	<div class="text-right"> 
	{!! $ordenes->render() !!}
	</div>
</div>

<!-- formulario para eliminar orden -->
{{ Form::open(['route' => ['orden.destroy',':ORDEN_ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) }}

{{ Form::close() }}

@endsection