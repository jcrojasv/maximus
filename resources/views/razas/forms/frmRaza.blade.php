@section('renderFormulario')

<div class="modal fade" id='ventanaModal' tabindex="-1" role='dialog' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class="modal-header">
				<button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-primary">Razas</h4>
			</div>

			<div class="modal-body">
				@if($accion=='Editar')
					{!! Form::model($raza, ['route' => ['razas.update', $raza->id],'method'=>'put','id'=>'frmColor'])!!}	
				@else
					{!! Form::open(['route'=>'razas.store','id'=>'frmColor'])!!}
				@endif
				

				<!-- row 0  -->              
				<div class="row especie_id">

					<div class="col-lg-4 text-right">
						Especie:
					</div>

					<div class="col-lg-8 ">
						@if(isset($raza))
							{!! Form::select('especie_id',$especies,null,['id'=>'especie_id','selected'=>$raza->especie_id,'class'=>'form-control']) !!}
						@else
							{!! Form::select('especie_id',$especies,null,['id'=>'especie_id','selected'=>'--> Seleccione especie <--','class'=>'form-control']) !!}
						@endif

						<span class="help-block especie_id hidden"></span>

					</div>
				</div>
				<!-- Fin row 0 -->

				<!-- row 1  -->              
				<div class="row descripcion">
					<br/>
					<div class="col-lg-4 text-right">
						Raza:
					</div>

					<div class="col-lg-8 ">
						{!! Form::text('descripcion',null, ['class'=>"form-control",'placeholder'=>'Raza','id'=>'descripcion']) !!}

						<span class="help-block descripcion hidden"></span>

					</div>
				</div>
				<!-- Fin row 1 -->

				{!! Form::close() !!}
			</div>

			<div class="modal-footer">
				<br/>
				<a href="#" class="btn {{ ($accion == 'Agregar') ? 'btn-primary' : 'btn-warning' }} btn-guardar">
					<i class="fa {{ ($accion == 'Agregar') ? 'fa-plus' : 'fa-pencil' }}"></i> {{$accion}} raza 
				</a>
				&nbsp;&nbsp;
				<a href="#" data-dismiss="modal" class="cancelar">Cancelar</a>
			</div>
		</div>
	</div>
</div>
@endsection