@extends('layouts/app')

@section('title','Orden de trabajo')

@section('scriptsJs')

<!-- Data Tables -->
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>

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

	//Accion busqueda de mascotas
	$('#btnBuscar').click(function(){
		var ruta = "{{ route('orden.buscarMascota')}}";
		var form = $('#frmBuscar');
		var frmData = form.serialize();
		
		//lamado ajax metodo get para tomar el listado de la busqueda
		$.ajax({
				url: ruta,
				type: 'get',
				dataType: 'json',
				data: frmData,
		}).done(function(data) {

			$('#listado').empty().append($(data));
        	
    	}).fail(function(data){

                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }


    	});

	});

		
	
});


</script>
@endsection

@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Orden de trabajo <i class="fa fa-file-o"></i></h1>
	</div>
</div>

 @include('errors/errors')

<div class="row">
	<div class="panel panel-info">

		<div class="panel-heading">
			<h4 class="text-primary">Datos de la mascota <i class="fa fa-github-alt"></i></h4>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<button type="button" class="btn btn-info btn-block" id="btnBuscarMascota" data-toggle="modal" data-target="#ventanaModal">
					 <strong>Buscar mascota ...</strong> <i class="fa fa-search"> </i></button>
				</div>
			</div>

			<!-- datos de la mascota, resultado de la busqueda -->
			<div class="row" >
				<br/>
				<div id="datosMascota">
				@section('sectionDatos')
				@if(isset($resultMascota))
					
					@include('orden.datosMascota')

				@endif
				@endsection
				</div>
			</div>

		</div>
	</div>
</div>
<br/>
<div class="row">
	
	{!! Form::open(['method'=>'post','route'=>'orden.store','id'=>'frmOrden'])!!}
		<div id="divFrmOrden">
		@section('sectionFrmOrden')
			@if(isset($arreglosGen))
				@include('orden.forms.frmOrden')
			@endif
		@endsection
		</div>

	{!! Form::close() !!}

</div>

@include('orden.forms.frmBuscarMascota')

@endsection

