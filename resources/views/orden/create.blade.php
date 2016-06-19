@extends('layouts/app')

@section('title','Orden de trabajo')

@section('scriptsJs')

<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>

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
	
	{!! Form::open(['method'=>'post','route'=>'orden.store'])!!}

		@include('orden.forms.frmOrden')
	
	{!! Form::close() !!}
</div>

@include('orden.forms.frmBuscarMascota')

@endsection

