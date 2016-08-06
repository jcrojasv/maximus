@extends('layouts/app')

@section('title','Historia de Mascota') 

@section('estilos')
	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>	
@endsection

@section('scriptsJs')
<!-- Data Tables -->
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>

@endsection

@section('cuerpo')
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Historial de Mascotas <span class="fa fa-github-alt"></span></h1>
		</div>
	</div>

	<div class="row">
		@include('partials.mensajes')
	</div>

	<div class="row">
		<div class="panel panel-info">

			<div class="panel-heading">
				<h4 class="text-primary">Datos de la Mascota <i class="fa fa-github-alt"></i></h4>
			</div>
			
			<div class="panel-body">
				

				<!-- datos de la mascota, resultado de la busqueda -->
				<div class="row" >
					<br/>
					<div id="datosMascota">
					
					@if(isset($resultMascota))
						
						@include('mascota.datos')

					@endif
					
					</div>
				</div>

			</div>
		</div>
	</div>
	
	<!--Listado historial de mascotas -->
	<div id='divHistorial'>
		@include('orden.partialHistorial')
	</div>

@endsection