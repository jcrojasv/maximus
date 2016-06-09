@extends('layouts/app')

@section('title','Ficha tecnica')

@section('scriptsJs')

	<script src="/js/input-mask/jquery.inputmask.js" type="text/javascript"></script>
	<script src="/js/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
	<script src="/js/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script>
$(document).ready(function(){

	$('input[name=especie]').click(function() {

		$.get("{{ url('selectRazas')}}",
			{ especieId: $(this).val() },
			function(data) {

				$('#divRaza').empty();
				$("#divRaza").html(data);

			});
		$.get("{{ url('selectAlimentos')}}",
			{ especieId: $(this).val() },
			function(data) {

				$('#divAlimentos').empty();
				$("#divAlimentos").html(data);

			});
	});
  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  $('select').addClass('form-control');

  //Inicializar los inputmask
  $("[data-mask='data-mask']").inputmask();
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
		 <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
	{!! Form::close() !!}
</div>

<div class="row">

	<div class="panel panel-default">
		<div class="panel-heading"><h4 class="text-primary">Mascotas</h4></div>
		<div class="panel-body">
			<div class="text-center">
				<button type="button" class="btn btn-primary btn-circle" data-toggle="collapse" data-target="#frmCollapse" aria-expanded="false" aria-controls="frmCollapse">
					<i class="fa fa-plus"></i>
				</button>
				<a data-toggle="collapse" href="#frmCollapse" aria-expanded="false" aria-controls="frmCollapse">A&ntilde;adir</a>
			</div>
			
			<!-- Div para el formulario a collapse -->
			<div class="collapse" id="frmCollapse">
				<br/>
				
				@include('mascota.forms.frmMascota')
		
			</div>

			<br/>

			@foreach($propietario->mascota as $mascota)
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="panel panel-info">
						<div class="panel-heading">

							<div class="pull-right">
								<button type="button" class="btn btn-circle btn-danger btn-sm " data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-times"></i></button>
								<button type="button" class="btn btn-circle btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></button>
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

