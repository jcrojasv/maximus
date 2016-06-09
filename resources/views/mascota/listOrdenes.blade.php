@extends('layouts/app')

@section('title','Listado de ordenes') 

@section('cuerpo')
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Listado General de ordenes</h1>
		</div>
	
	
	<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Orden N&deg;</th>
			<th>Mascota</th>
			<th>Fecha</th>
			<th>Entrada</th>
			<th>Salida</th>
			<th>Propietario</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ordenes as $orden)
			<tr @if(is_null($orden->salida)) class='success' @endif>
				<td>{{ $orden->id }}</td>
				<td>{{ $orden->nombre }}</td>
				<td>{{ $orden->fecha }}</td>
				<td>{{ $orden->entrada }}</td>
				<td>{{ $orden->salida }}</td>
				<td>{{ $orden->nombres }}</td>
				<td>
                	<button class="btn btn-warning btn-sm open-modal" value="{{$orden->id}}">
                	 <i class="fa fa-pencil"></i> Editar</button>
                    <button class="btn btn-danger btn-sm btn-delete delete-task" value="{{$orden->id}}"><i class="fa fa-trash"></i> Eliminar</button>
                </td>
			</tr>
		@endforeach
	</tbody>
	</table>

	{!! $ordenes->render() !!}
	</div>
@endsection