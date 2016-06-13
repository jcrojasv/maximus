@extends('propietario.edit')

@section('renderSection')
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
@endsection