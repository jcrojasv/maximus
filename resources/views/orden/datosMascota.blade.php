<div class="row" id="{{ $resultMascota->id }}">
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel panel-info">
		<div class="panel-heading">

			<h4><span class='text-muted'>Nombre:</span> {{ $resultMascota->nombre }}</h4>


		</div>
		<div class="panel-body">
			
			<div class="col-lg-6"> 
				<strong>Especie:</strong> {{ $resultMascota->especie }}<br/>
				<strong>Raza:</strong>    {{ $resultMascota->raza }}<br/>
				<strong>Genero:</strong>  
				
				@if($resultMascota->sexo == 'F')
					<span class="fa fa-venus" aria-hidden="true"></span>
				@else
				 	<span class="fa fa-mars" aria-hidden="true"></span>
				@endif
			
				<br/>
				<strong>Color:</strong>   {{ $resultMascota->color }}<br/>
				<strong>Registrado el: </strong>
					{{ $resultMascota->created_at->format('d-m-Y') }}
				 
			</div>
			<div class="col-lg-6">
				<strong>Propietario:</strong> {{$resultMascota->nombres}}, {{$resultMascota->apellidos}}  
				<br/>
				<strong>Tel&eacute;fonos:</strong> 
				<br/>
				<i class="fa fa-phone "></i> {{$resultMascota->telefono_fijo}}
				<br/>
				<i class="fa fa-mobile fa-2x "></i> {{$resultMascota->telefono_celular}}  
			</div>
		</div>
	</div>
</div>
</div>