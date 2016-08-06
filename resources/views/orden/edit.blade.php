@extends('layouts/app')

@section('title','Editar orden de trabajo')

@section('scriptsJs')

<!-- bootstrap date-picker  -->
<link rel="stylesheet" href="/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script src="/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/js/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>

<!-- bootstrap time-picker  -->
<link rel="stylesheet" href="/css/timepicker/bootstrap-timepicker.min.css">
<script src="/js/timepicker/bootstrap-timepicker.min.js"></script>

<!-- Bootstrap on-off -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
$(document).ready(function(){
//Carga los servicios especializado
	$('input:radio[name=tipo]').on('click',function() {
		var cod = $('input:radio[name=tipo]:checked').val();
		if(cod == 'ESP')
		{
			var ruta = "{{ route('orden.esp')}}";
			
			//lamado ajax metodo get para tomar el listado de la busqueda
			$.ajax({
				url: ruta,
				type: 'get',
				dataType: 'json',
			}).done(function(data) {

				$('#especializados').empty().append($(data));
	        	
	    	}).fail(function(data){

                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }

	    	});
		} else {

			$('#especializados').empty();

		}

	});

	
	//Cargo el datepicker
	$('#fecha').datepicker({
		format: 'dd-mm-yyyy',
		language: 'es',
		toggleActive: true,
		todayHighlight: true,
		autoclose: true,
	});

	
	//Cargo el timepicker al campo entrada
	$('#entrada').timepicker({
		template: false,
		snapToStep: true,
		minuteStep: 5,
		showInputs: false,
		disableFocus: true,
		explicitMode: true,
		showMeridian: false
	});

	//Cargo el timepicker al campo salida
	$('#salida').timepicker({
		minuteStep: 5,
		showMeridian: false,
		disableFocus: true,
		defaultTime: 'current',
		explicitMode: true,
	});

	//Cambio el checkbox de estatus a boton on-off
	$(function(){
		$('input[name=estatus]').bootstrapToggle({
	      on: 'En proceso',
	      off: 'Finalizada',
	     
	    });
	});

});
</script>
@endsection

@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Editar orden de trabajo <i class="fa fa-file-o"></i></h1>
	</div>
</div>

 @include('errors/errors')

 @include('partials/mensajes')

<div class="row">
	<div class="panel panel-info">

		<div class="panel-heading">
			<h4 class="text-primary">Datos de la mascota <i class="fa fa-github-alt"></i></h4>
		</div>
		
		<div class="panel-body">
			
			<!-- datos de la mascota, resultado de la busqueda -->
			<div class="row" >
				<br/>
				<div id="datosMascota">
											
					@include('mascota.datos')

				</div>
			</div>

		</div>
	</div>
</div>
<br/>

<div class="row">

	{!! Form::model($orden, ['route' => ['orden.update',$orden->id],'method'=>'put'])!!}
	@include('orden.forms.frmEditarOrden')
	{!! Form::close() !!}
</div>

@endsection
