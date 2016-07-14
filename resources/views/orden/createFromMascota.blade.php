@extends('layouts/app')

@section('title','Orden de trabajo')

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

	

		
	
});


</script>
@include('orden.forms.jsOrden')

@endsection

@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Orden de trabajo <i class="fa fa-file-text-o"></i></h1>
	</div>
</div>

 @include('partials.mensajes')

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
				
				@if(isset($resultMascota))
					
					@include('orden.datosMascota')

				@endif
				
				</div>
			</div>

		</div>
	</div>
</div>
<br/>
<div class="row">
	
	{!! Form::open(['method'=>'post','route'=>'orden.store','id'=>'frmOrden'])!!}
		<div id="divFrmOrden">
		
			@if(isset($arreglosGen))
				@include('orden.forms.frmOrden')
			@endif
		
		</div>

	{!! Form::close() !!}

</div>

@endsection

