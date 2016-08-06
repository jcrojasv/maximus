@extends('layouts.app')

@section('title','Reporte de Ordenes Diarias')

@section('estilos')

	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>
	
@endsection

@section('scriptsJs')

<!-- bootstrap date-picker  -->
<link rel="stylesheet" href="/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
<script src="/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/js/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>

<script>
$(document).ready(function(){
	//Cargo el datepicker
	$('#fecha').datepicker({
		format: 'dd-mm-yyyy',
		language: 'es',
		toggleActive: true,
		todayHighlight: true,
		autoclose: true,
	});

	//Funcion para enviar los datos por ajax
	$('#btn-buscar').click(function(){
		var fecha = $('#fecha').val();
		var url = "{{ route('reportes.ordenesDiarias')}}";

		$.get(url,{fecha: fecha},function(data){
			$("#listado").empty().append($(data));
		});

	});
});
    
</script>
@endsection

@section('cuerpo')

	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Reporte de Ordenes Diarias</span></h2>
		</div>
	</div>

	<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="text-primary">Seleccione Fecha</h4>
		</div>
		
		<!-- Datos Propietario -->
		<div class="panel-body">

			<!-- Row 1 -->
			<div class="row">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Seleccione el d&iacute;a:
				</div>

				<div class="col-lg-6">
					<div class="input-group">
						
						{!! Form::open(['method'=>'post','route'=>'reportes.ordenesDiarias','id'=>'frmBuscar'])!!}
							{!! Form::text('fecha',date('d-m-Y'), ['id'=>'fecha','class'=>'form-control']) !!}
						{!! Form::close() !!}

				        <div class="input-group-addon">
					        <span class="fa fa-calendar"></span>
					    </div>
					</div>					
				
				</div>
				
			</div>
			<!-- Fin row 1 -->

			<!-- Row botones -->
			<div class="row">
				<br/>
				<div class="col-lg-12 text-center">
				
					<button type="submit" class="btn btn-info" id="btn-buscar">
						<i class="fa fa-search"></i> Buscar 
					</button>
					&nbsp;&nbsp;
					<a href="{{route('home')}}">Cancelar</a>

				</div>
			</div>
			<!-- Fin botones -->

		</div> <!-- Fin panel-body -->

		
	</div>

	<div id='listado'>
	@section('renderSection')
		@if(!empty($ordenes))
            @include('reportes.partials.partialOrdenesDiarias')
        @endif
	@endsection
	</div>

@endsection