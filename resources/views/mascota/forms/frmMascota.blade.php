
<div class="modal fade" id='ventanaModal' tabindex="-1" role='dialog' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class="modal-header">

				<button type='button' class="close cancelar" data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class="text-primary">{{$accion}} Mascota</h4>

			</div>

			<div class="modal-body">
				@if($accion=='Editar')
					{!! Form::model($mascota, ['route' => ['mascota.update', $mascota->id],'method'=>'put','id'=>'frmMascota'])!!}	
				@else
					{!! Form::open(['route'=>'mascota.store','id'=>'frmMascota'])!!}
				@endif
				
				<!-- row 0 temporal mientras se transcriben datos -->              
				<div class="row id">

					<div class="col-lg-4 text-right">
						N&deg; Ficha:
					</div>

					<div class="col-lg-8 ">
						{!! Form::text('id',null, ['class'=>"form-control",'placeholder'=>'# Ficha','id'=>'id']) !!}

						<span class="help-block id hidden"></span>

					</div>
				</div>
				<!-- Fin row o -->

				<!-- row 1 -->              
				<div class="row nombre">
					<br/>
					<div class="col-lg-4 text-right">
						Nombre:
					</div>

					<div class="col-lg-8 ">
						{!! Form::hidden('propietario_id',$propietario->id,['id'=>'propietario_id']) !!}

						{!! Form::text('nombre',null, ['class'=>"form-control",'placeholder'=>'Mascota','id'=>'nombre']) !!}

						<span class="help-block nombre hidden"></span>

					</div>
				</div>
				<!-- Fin row 1 -->

				<!-- Row 2 -->
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						Fecha de Nacimiento:
					</div>
					<div class="col-lg-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"> </i></span>  
							{!! Form::text('fecha_nacimiento',null, ['class'=>"form-control",'placeholder'=>'dd/mm/AAAA','id'=>'fecha_nacimiento']) !!}
						</div>

					</div>
				</div>
				<!-- Fin Row 2 -->

				<!-- Row 3 -->
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						Genero:
					</div>

					<div class="col-lg-8">
						<label class="checkbox-inline">
							{!! Form::radio('sexo','F',true,['id'=>'sexo']) !!} Hembra <i class="fa fa-venus"></i>
						</label>
						<label class="checkbox-inline">
							{!! Form::radio('sexo','M',false,['id'=>'sexo']) !!} Macho <i class="fa fa-mars"></i>
						</label>
					</div>

				</div>
				<!-- Fin row 3 -->



				<!-- Row 5 -->
				<div class="row especie">
					<br/>
					<div class="col-lg-4 text-right">
						Especie:
					</div>

					<div class="col-lg-8">		

						<label class="checkbox-inline">
							{!! Form::radio('especie_id','1',false,['id'=>'especie_id','class'=>'especie']) !!} Canina
						</label>
						<label class="checkbox-inline">
							{!! Form::radio('especie_id','2',false,['id'=>'especie_id','class'=>'especie']) !!} Felina
						</label>

						<span class="help-block especie_id hidden"><br/></span>

					</div>
				</div>
				<!-- Fin row 5 -->

				<!-- Row 6 -->
				<!-- Row 7 -->
				<div class="row raza_id">
					<br/>
					<div class="col-lg-4 text-right">
						Raza:
					</div>
					<div class="col-lg-8" >
						<div id='divRaza'>
							@if(isset($razas))
								{!! Form::select('raza_id',$razas,null,['id'=>'raza_id','selected'=>$mascota->raza_id,'class'=>'form-control']) !!}
							@else
								{!! Form::select('raza_id',['0'=>'---> Seleccione Especie <---'],null,['id'=>'raza_id','class'=>'form-control']) !!}
							@endif
						</div>

						<span class="help-block raza_id hidden"></span>
					</div>



				</div>
				<!-- Fin row 6 -->

				<!-- Row 4 -->
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						Color:
					</div>
					<div class="col-lg-8">
						@if(isset($mascota))
							{!! Form::select('color_id',$colores,null,['id'=>'color_id','selected'=>$mascota->color_id,'class'=>'form-control']) !!}
						@else
							{!! Form::select('color_id',$colores,null,['id'=>'color_id','class'=>'form-control']) !!}
						@endif
					</div>
				</div>	
				<!-- Fin row 4 -->

				<!-- Row 7 -->
				<div class="row alimento_id">
					<br/>
					<div class="col-lg-4 text-right">
						Alimento que consume:
					</div>
					<div class="col-lg-8" >
						<div id="divAlimentos">
							@if(isset($alimentos))
								{!! Form::select('alimento_id',$alimentos,null,['id'=>'alimento_id','selected'=>$mascota->alimento_id,'class'=>'form-control']) !!}
							@else
								{!! Form::select('alimento_id',['0'=>'---> Seleccione Especie <---'],null,['id'=>'alimento_id','class'=>'form-control']) !!}
							@endif
						</div>
						<span class="help-block alimento_id hidden"></span>
					</div>
				</div>
				<!-- Fin Row 7 -->

				<!-- row 8 -->              
				<div class="row peso">
					<br/>
					<div class="col-lg-4 text-right">
						Peso:
					</div>

					<div class="col-lg-8">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dashboard"> </i></span>  
							{!! Form::text('peso',null, ['class'=>"form-control",'placeholder'=>'peso','id'=>'peso']) !!}
						</div>

						<span class="help-block peso hidden"></span>

					</div>
				</div>
				<!-- Fin row 8 -->

				<!-- row 9 -->              
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						Se&ntilde;al particular:
					</div>

					<div class="col-lg-8 ">
						{!! Form::text('sena',null, ['class'=>"form-control",'placeholder'=>'Se&ntilde;al particular','id'=>'sena']) !!}
					</div>
				</div>
				<!-- Fin row 9 -->

				<!-- Row 10 -->
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						&Uacute;ltima Vacuna:
					</div>
					<div class="col-lg-8">

						<label class="checkbox-inline">
							{!! Form::radio('vacuna','Al día',true,['id'=>'vacuna']) !!} Al d&iacute;a <span class="fa fa-smile-o text-success"></i></span>
						</label>

						<label class="checkbox-inline">
							{!! Form::radio('vacuna','No sabe',false,['id'=>'vacuna']) !!} No sabe <span class="fa fa-frown-o text-danger"></i></span>
						</label>

						<label class="checkbox-inline">
							{!! Form::radio('vacuna','Pendiente',false,['id'=>'vacuna']) !!} Pendiente <span class="fa fa-exclamation-triangle text-warning"></i></span>
						</label>

						<br/>
					</div>
				</div>
				<!-- Fin Row 10 -->

				<!-- Row 11 -->
				<div class="row">
					<br/>
					<div class="col-lg-4 text-right">
						&Uacute;ltima Desparasitaci&oacute;n:
					</div>
					<div class="col-lg-8">
						<label class="checkbox-inline">
							{!! Form::radio('desparasitacion','Al día',true,['id'=>'desparasitacion']) !!} Al d&iacute;a <span class="fa fa-smile-o text-success"></i></span>
						</label>

						<label class="checkbox-inline">
							{!! Form::radio('desparasitacion','No sabe',false,['id'=>'desparasitacion']) !!} No sabe <span class="fa fa-frown-o text-danger"></i></span>
						</label>

						<label class="checkbox-inline">
							{!! Form::radio('desparasitacion','Pendiente',false,['id'=>'desparasitacion']) !!} Pendiente <span class="fa fa-exclamation-triangle text-warning"></i></span>
						</label>

						<br/>
						<br/>

					</div>
				</div>
				<!-- Fin Row 11 -->

				<!-- Row 12 -->
				<div class="modal-footer">
					<br/>
					<button type="button" class="btn {{ ($accion == 'Agregar') ? 'btn-primary' : 'btn-warning' }}" id="btnMascota">
						<i class="fa {{ ($accion == 'Agregar') ? 'fa-plus' : 'fa-pencil' }}"></i> {{$accion}} Mascota 
					</button>
					&nbsp;&nbsp;
					<a href="#" data-dismiss="modal" class="cancelar">Cancelar</a>
				</div>
				<!-- Fin Row 12 -->
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>