@extends('propietario.edit')

@section('renderSection')

<script type="text/javascript">


$(document).ready(function(){

	//Funcion para carghar el tooltip
	$(function () {$('[data-toggle="tooltip"]').tooltip()});

	//Funcion para eliminar mascotas
	$('.btn-delete').on('click',function(){
		var id   = $(this).data('id');
		var row  = $('#'+id+'');
		var form = $('#frmDelete');
		var ruta = form.attr('action').replace(':MASCOTA_ID',id);
		var data = form.serialize();

		if(confirm("Estas seguro de eliminar este registro?"))
		{
			$.ajax({
				url: ruta,
				type: 'post',
				dataType: 'json',
				data: data,
				
			}).done(function(respuesta){
				$('#mensaje').html(' ');

				$('#divMensajeMascota').removeClass('hidden');

				$('#divMensajeMascota').removeClass('hidden').addClass('alert-success');

				$("#mensajeMascota").html('<strong>Yeah!!</strong> ' + respuesta.message);

				$('#frmCollapse').removeAttr('aria-expanded');
				$('#frmCollapse').removeClass('in');

				//Llamamos a la funcion para resetaear campos de formulario
				$("#frmMascota").resetear();

				//Desvanezco el row
				row.fadeOut();

				
			});
		}
	});

	//Funcion para modificar mascota
	$('.btn-edit').click(function(){
		
		var id   = $(this).data('id');
		var ruta = "{{ route('mascota.index') }}" + '/' + id;
			
		//Aparezco la ventana modal
		$('#ventanaModal').modal('toggle');

		//Realizo peticion para mostrar los datos de la mascota
		$.ajax({
			url: ruta,
			type: 'get',
			dataType: 'json',
		}).done(function(respuesta){
			
			var cod = respuesta.mascota.especie_id;

			//llamada a la funcion para cargar razas
			url = "{{ url('selectRazas')}}";
			$.cargaSelect(url,'#divRaza',cod);

			//llamada a la funcion para cargar razas
			url = "{{ url('selectAlimentos')}}";
			$.cargaSelect(url,'#divAlimentos',cod);

			$('#frmMascota').llenarFormulario(respuesta.mascota);
	

		});

	});

});
</script>




@foreach($propietario->mascota as $mascota)
	<div class="row" id="{{ $mascota->id }}">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">

					<div class="pull-right">
						<button type="button" class="btn btn-circle btn-danger btn-sm btn-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-id="{{ $mascota->id }}" ><i class="fa fa-times"></i></button>
						<button type="button" class="btn btn-circle btn-primary btn-sm btn-edit" data-toggle="tooltip" data-target="#ventanaModal" data-placement="top" title="Editar" data-id="{{ $mascota->id }}"><i class="fa fa-pencil"></i></button>
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

{{ Form::open(['route' => ['mascota.destroy',':MASCOTA_ID'], 'method' => 'DELETE', 'id' => 'frmDelete']) }}

{{ Form::close() }}

@endsection