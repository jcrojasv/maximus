@extends('layouts/app')

@section('title','Ficha tecnica')

@section('scriptsJs')

<script>
$(document).ready(function(){

	//Imprime el listado de mascotas
	var ruta = "{{ route("mascota.index") }}/"+$("input[name=id]").val();

	$.ajaxRenderSection(ruta,'#listadoMascotas');

	//Imprime el formulario de agregar mascota
	$('#btnAddMascota').click(function(){
		var ruta        = "{{ route("mascota.create") }}";
		var accion      = 'Agregar';
		var propietario = $("input[name=id]").val();

		//lamado ajax metodo get para tomar el formulario
		$.get(ruta,{

			propietario: propietario,

		},function(data) {

        	$('#divFrmMascota').empty().append($(data));
        	
        	//Muestro la ventana modal
        	$('#ventanaModal').modal('toggle');

    	});
	});

});

</script>
@endsection

@section('cuerpo')


<div class="row">
	<div class="col-lg-12">
		@include('partials.menuBotones')
		<h2 class="page-header">Ficha T&eacute;cnica <i class="fa fa-folder-open-o"></i></h2>
	</div>
</div>

 @include('errors.errors')

 @include('partials.mensajes')

<div class="row">
	
	{!! Form::model($propietario, ['route' => ['propietario.update', $propietario->id],'method'=>'put'])!!}

		@include('propietario.forms.frmPropietario')
		
	{!! Form::close() !!}
</div>

<div class="row">
	<a href="#anchorMascota" id="anchorMascota"></a>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="text-primary">Mascotas</h4>
		</div>

		<div class="panel-body">

			<div class="alert alert-dismissible hidden" role="alert" id="divMensajeMascota">
			  	<button type="button" class="close" data-dismiss="alert" aria-label="close">
			  		<span aria-hidden="true">&times;</span>
			  	</button>
			    <p id="mensajeMascota"></p>
			    
			</div>

			
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<button type="button" class="btn btn-info btn-block" id="btnAddMascota" >
					 <strong>Agregar mascota ...</strong> <i class="fa fa-plus-circle"> </i></button>
				</div>
			</div>
			
			<br/>

			<div id="listadoMascotas">
				@section('renderSection')

				@endsection
			</div>
		
		</div>	

	</div>
</div>
<div id="divFrmMascota">
	@section('renderFormulario')
	@endsection
</div>

@endsection

