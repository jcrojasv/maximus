@extends('layouts/app')

@section('title','Ficha tecnica')

@section('scriptsJs')

<script>
$(document).ready(function(){

	$('input[name=especie]').click(function() {
		var cod = $(this).val();

		//llamada a la funcion para cargar razas
		url = "{{ url('selectRazas')}}";
		$.cargaSelect(url,'#divRaza',cod);

		//llamada a la funcion para cargar razas
		url = "{{ url('selectAlimentos')}}";
		$.cargaSelect(url,'#divAlimentos',cod);


	});

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
			
			$("#mensajeMascota").html(respuesta.message);

			$('#frmCollapse').removeAttr('aria-expanded');
			$('#frmCollapse').removeClass('in');

			//Llamamos a la funcion para resetaear campos de formulario
			$.reset('#frmMascota');

		}).fail(function(respuesta){


			$.each(respuesta.responseJSON,function (ind, elem) { 
  			
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

			});
				

		});
		

	});

	
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  $('select').addClass('form-control');

 
});

</script>
@endsection

@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
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

	<div class="panel panel-default">
		<div class="panel-heading"><h4 class="text-primary">Mascotas</h4></div>
		<div class="panel-body">

			<div id="divEncabezadoForm">
				@include('partials.mensajes',['divMensajes'=>'divMensajeMascota','pMensajes'=>'mensajeMascota'])
			</div>

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
				{!! Form::open(['route'=>'mascota.store','id'=>'frmMascota'])!!}
					@include('mascota.forms.frmMascota')
				{!! Form::close() !!}
				</div>
				
			</div>

			<br/>

			@foreach($propietario->mascota as $mascota)
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="panel panel-info">
						<div class="panel-heading">

							<div class="pull-right">
								<button type="button" class="btn btn-circle btn-danger btn-sm prueba" data-toggle="tooltip" data-placement="top" title="Eliminar" ><i class="fa fa-times"></i></button>
								<button type="button" class="btn btn-circle btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar" data-id="{{ $mascota->id }}"><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn btn-circle btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Crear orden"><i class="fa fa-file-text"></i></button>
							</div>
							<h4>{{ $mascota->nombre }}</h4>


						</div>
						<div class="panel-body">

							<div class="pull-left"> 
								<strong>Especie:</strong> {{ $mascota->raza->especie->descripcion }}<br/>
								<strong>Raza:</strong>    {{ $mascota->raza->descripcion }}<br/>
								<strong>Genero:</strong>  
								
								@if($mascota->sexo == 'F')
									<span class="fa fa-venus" aria-hidden="true"></span>
								@else
								 	<span class="fa fa-mars" aria-hidden="true"></span>
								@endif
							
								<br/>
								<strong>Color:</strong>   {{ $mascota->color->color }}<br/> 
							</div>
							<div class="pull-right">
								<div class="text-right text-muted"><strong>Registrado el: </strong>
									{{ $mascota->created_at->format('d-m-Y') }} </div>
								</div> 

							</div>
						</div>
					</div>

				</div>
				@endforeach		
			</div>

		</div>
</div>
@endsection

