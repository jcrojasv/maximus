@extends('layouts/app')

@section('title','Ficha tecnica')

@section('scriptsJs')

<script>
$(document).ready(function(){

	$('#btnBuscar').click(function(){
		var ruta = "{{ url('buscarMascota')}}";
		var form = $('#frmBuscar');
		var frmData = form.serialize();

		//Envio los datos de la buscada a la URL por ajax
		$.get(ruta,frmData, function(data){
			$('#listado').empty();
			$("#listado").html(data);
		}).fail(function() {
			alert('No se pudo realizar la consulta');
		});

	});
  

});

function seleccionarMascota(id){
	
	var ruta = "{{ url('getMascota')}}";

	//Envio los datos de la buscada a la URL por ajax
	$.get(ruta,id, function(data){
		$('#listado').empty();
		$("#listado").html(data);
	}).fail(function() {
		alert('No se pudo realizar la consulta');
	});
	
}
</script>
@endsection

@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ficha T&eacute;cnica</h1>
	</div>
</div>

 @include('errors/errors')

<div class="row">
	
	{!! Form::open(['method'=>'post','route'=>'propietario.store'])!!}

		@include('propietario.forms.frmPropietario')
	
	{!! Form::close() !!}
</div>
@endsection

