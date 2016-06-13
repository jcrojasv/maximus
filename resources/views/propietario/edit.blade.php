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
        },
        error: function (data) {
            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }
        }
    });
	}

	ajaxRenderSection();



	$('input[name=especie]').click(function() {
		var cod = $(this).val();

		//llamada a la funcion para cargar razas
		url = "{{ url('selectRazas')}}";
		$.cargaSelect(url,'#divRaza',cod);

		//llamada a la funcion para cargar razas
		url = "{{ url('selectAlimentos')}}";
		$.cargaSelect(url,'#divAlimentos',cod);


	});

	//Acciones del boton cancelar mascota
	$('#btnCancelar').click(function(e){
		e.preventDefault();

		//Cierro el formulario de mascota
		$('#frmCollapse').removeAttr('aria-expanded');
		$('#frmCollapse').removeClass('in');
		
		//Llamamos a la funcion para resetaear campos de formulario
		$("#frmMascota").resetear();

		$("#divFrmMascota div").removeClass('has-error');
		$("#divFrmMascota span").removeClass('help-block').addClass('hidden');

		//LLamamos a la accion para subir al top de la pagina
		$('html,body').animate({scrollTop:'0px'}, 500);

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

			$('#mensaje').html(' ');

			$('#divMensajeMascota').removeClass('hidden');

			$('#divMensajeMascota').removeClass('hidden').addClass('alert-success');

			$("#mensajeMascota").html('<strong>Yeah!!</strong> ' + respuesta.message);

			$('#frmCollapse').removeAttr('aria-expanded');
			$('#frmCollapse').removeClass('in');

			//Llamamos a la funcion para resetaear campos de formulario
			$("#frmMascota").resetear();

			ajaxRenderSection();

		}).fail(function(respuesta){

			$.each(respuesta.responseJSON,function (ind, elem) { 
  			
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden').addClass('help-block');

  				$('#divMensajeMascota').removeClass('hidden').addClass('alert-danger');
						
				$("#mensajeMascota").html('<strong>Ooops,</strong> hubo error al procesar el formulario, por favor revise el mismo');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

  				//Ir a la posicion donde esta el mensaje para visualizarlo
  				volver  = $("#anchorMascota").attr('href');
    			$('html, body').animate({scrollTop: $(volver).offset().top}, 500);

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

			
			@include('partials.mensajes',['divMensajes'=>'divMensajeMascota','pMensajes'=>'mensajeMascota'])
			

			<div class="text-center">
				<button type="button" class="btn btn-primary btn-circle" data-toggle="collapse" data-target="#frmCollapse" aria-expanded="false" aria-controls="frmCollapse">
					<i class="fa fa-plus"></i>
				</button>
				<a data-toggle="collapse" href="#frmCollapse" aria-expanded="false" aria-controls="frmCollapse">A&ntilde;adir</a>
			</div>
			
			<!-- Div para el formulario a collapse -->
			<div class="collapse" id="frmCollapse">
				<br/>
				
				<div id="divFrmMascota">
					@include('mascota.forms.frmMascota')			
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
@endsection

