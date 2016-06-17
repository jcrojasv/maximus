@extends('layouts/app')

@section('title','Ficha tecnica')

@section('scriptsJs')

<script>
$(document).ready(function(){


	function ajaxRenderSection() {

	var ruta = "{{ route("mascota.lista") }}";
	var token = $("input[name=_token]").val();
	var dato = $("input[name=id]").val();
	
 	$.ajax({
        type: 'GET',
        url:  ruta,
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        data: { 'id' : dato},
        success: function (data) {
            $('#listadoMascotas').empty().append($(data));
        }
    });
	}

	//Imprime el listado de mascotas
	ajaxRenderSection();


	//Agrega el titulo en la ventana modal
	$('.ventanaModal').click(function(){
		$('tituloModal').html('Agregar');
	});

	//Carga los select dependientes
	$('.especie_id').click(function() {
		var cod = $(this).val();

		//llamada a la funcion para cargar razas
		url = "{{ url('selectRazas')}}";
		$.cargaSelect(url,'#divRaza',cod,null);

		//llamada a la funcion para cargar razas
		url = "{{ url('selectAlimentos')}}";
		$.cargaSelect(url,'#divAlimentos',cod,null);


	});

	//Acciones del boton cancelar mascota
	$('.cancelar').click(function(e){
		e.preventDefault();

		//Llamamos a la funcion para resetaear campos de formulario
		$("#frmMascota").resetear();
		
		$("#divFrmMascota div").removeClass('has-error');
		$("#divFrmMascota span.help-block").addClass('hidden');

		$('#divMensajeMascota').addClass('hidden');

		
	});

	//Acciones del boton Agregar mascota
	$('#btnAddMascota').click(function(){
		var frmMascota = $("#frmMascota").serialize();
		var ruta = "{{ route("mascota.store") }}";
		var token = $("input[name=_token]").val();

		$.ajax({
			url: ruta,
			headers: {'X-CSRF-TOKEN': token},
			type: 'post',
			dataType: 'json',
			data: frmMascota,
			beforeSend:  function(){
				$('span.help-block').addClass('hidden');
				$('div').removeClass('has-error');
			},

		}).done(function(respuesta) {

			$('#mensajeMascota').html(' ');

			$('#divMensajeMascota').removeClass('hidden');

			$('#divMensajeMascota').removeClass('hidden').addClass('alert-success');

			$("#mensajeMascota").html('<strong>Yeah!!</strong> ' + respuesta.message);

			//Llamamos a la funcion para resetear campos de formulario
			$("#frmMascota").resetear();

			//Desvanecemos la ventana modal
			$('#ventanaModal').modal('hide');

			ajaxRenderSection();

		}).fail(function(respuesta){

			$.each(respuesta.responseJSON,function (ind, elem) { 
  			
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

			});
				

		});
		

	});

	
 
  $('select').addClass('form-control');

 
});

</script>
@endsection

@section('cuerpo')


<div class="row">
	<div class="col-lg-12">
		@include('partials.menuBotones')
		<h1 class="page-header">Ficha T&eacute;cnica</h1>
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

			
			<div class="text-center">

				<button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#ventanaModal" class="ventanaModal">
					<i class="fa fa-plus"></i>
				</button>
				<a href="#!" data-toggle="modal" data-target="#ventanaModal" class="ventanaModal">A&ntilde;adir</a>
			</div>
			
			<br/>

			<div id="listadoMascotas">
				@section('renderSection')

				@endsection
			</div>
		
		</div>	

	</div>
</div>

@include('mascota.forms.frmMascota')
@endsection

