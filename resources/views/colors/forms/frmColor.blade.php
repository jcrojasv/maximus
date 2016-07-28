@section('renderFormulario')

<div class="modal fade" id='ventanaModal' tabindex="-1" role='dialog' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class="modal-header">
				<button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-primary">Color</h4>
			</div>

			<div class="modal-body">
				@if($accion=='Editar')
					{!! Form::model($color, ['route' => ['colors.update', $color->id],'method'=>'put','id'=>'frmColor'])!!}	
				@else
					{!! Form::open(['route'=>'colors.store','id'=>'frmColor'])!!}
				@endif
				
				<!-- row 0  -->              
				<div class="row color">

					<div class="col-lg-4 text-right">
						Color:
					</div>

					<div class="col-lg-8 ">
						{!! Form::text('color',null, ['class'=>"form-control",'placeholder'=>'Color','color'=>'color']) !!}

						<span class="help-block color hidden"></span>

					</div>
				</div>
				<!-- Fin row 0 -->

				{!! Form::close() !!}
			</div>

			<div class="modal-footer">
				<br/>
				<a href="#" class="btn {{ ($accion == 'Agregar') ? 'btn-primary' : 'btn-warning' }} btn-guardar">
					<i class="fa {{ ($accion == 'Agregar') ? 'fa-plus' : 'fa-pencil' }}"></i> {{$accion}} color 
				</a>
				&nbsp;&nbsp;
				<a href="#" data-dismiss="modal" class="cancelar">Cancelar</a>
			</div>
		</div>
	</div>
</div>
@endsection