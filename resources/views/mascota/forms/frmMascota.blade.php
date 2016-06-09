{!! Form::open(['method'=>'post','route'=>'mascota.store'])!!}
	<!-- row 1 -->              
	<div class="row {{ $errors->has('nombre') ? ' has-error' : '' }}">

		<div class="col-lg-3 col-lg-offset-1 text-right">
			Nombre:
		</div>

		<div class="col-lg-6 ">
			{!! Form::hidden('propietario_id',$propietario->id) !!}
			{!! Form::text('nombre',null, ['class'=>"form-control",'placeholder'=>'Mascota']) !!}
			
			@if ($errors->has('nombre'))
			<span class="help-block">
				<strong>{{ $errors->first('nombre') }}</strong>
			</span>
			@endif

		</div>
	</div>
	<!-- Fin row 1 -->

	<!-- Row 2 -->
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Fecha de Nacimiento:
		</div>
		<div class="col-lg-6">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"> </i></span>  
				{!! Form::text('fecha_nacimiento',null, ['class'=>"form-control",'placeholder'=>'dd/mm/AAAA']) !!}
			</div>
			
		</div>
	</div>
	<!-- Fin Row 2 -->

	<!-- Row 3 -->
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Genero:
		</div>

		<div class="col-lg-6">
			<label class="checkbox-inline">
				{!! Form::radio('sexo','F',true) !!} Hembra <i class="fa fa-venus"></i>
			</label>
			<label class="checkbox-inline">
				{!! Form::radio('sexo','M',false) !!} Macho <i class="fa fa-mars"></i>
			</label>
		</div>
		
	</div>
	<!-- Fin row 3 -->

	<!-- Row 4 -->
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Color:
		</div>
		<div class="col-lg-6">
			{!! Form::select('color_id',$colores) !!}
		</div>
	</div>	
	<!-- Fin row 4 -->

	<!-- Row 5 -->
	<div class="row {{ $errors->has('especie') ? ' has-error' : '' }}">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Especie:
		</div>
		
		<div class="col-lg-6">		
			<div class="col-lg-6">
				<label class="checkbox-inline">
					{!! Form::radio('especie','1',false) !!} Canina
				</label>
				<label class="checkbox-inline">
					{!! Form::radio('especie','2',false) !!} Felina
				</label>
			</div>
			@if ($errors->has('especie'))
			<span class="help-block">
				<strong>{{ $errors->first('especie') }}</strong>
			</span>
			@endif
		</div>
	</div>
	<!-- Fin row 5 -->

	<!-- Row 6 -->
	<!-- Row 7 -->
	<div class="row {{ $errors->has('raza_id') ? ' has-error' : '' }}">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Raza:
		</div>
		<div class="col-lg-6" id='divRaza'>
			{!! Form::select('raza_id',['--> Indique Especie <--']) !!}
		</div>
		@if ($errors->has('raza_id'))
			<span class="help-block">
				<strong>{{ $errors->first('raza_id') }}</strong>
			</span>
		@endif
	</div>
	<!-- Fin row 6 -->

	<!-- Row 7 -->
	<div class="row {{ $errors->has('alimento_id') ? ' has-error' : '' }}">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Alimento que consume:
		</div>
		<div class="col-lg-6" id="divAlimentos">
			{!! Form::select('alimento_id',['--> Indique Especie <--']) !!}
		</div>
		@if ($errors->has('alimento_id'))
			<span class="help-block">
				<strong>{{ $errors->first('alimento_id') }}</strong>
			</span>
		@endif
	</div>
	<!-- Fin Row 7 -->

	<!-- row 8 -->              
	<div class="row {{ $errors->has('peso') ? ' has-error' : '' }}">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Peso:
		</div>

		<div class="col-lg-6">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-dashboard"> </i></span>  
				{!! Form::text('peso',null, ['class'=>"form-control",'placeholder'=>'peso']) !!}
			</div>
			@if ($errors->has('peso'))
			<span class="help-block">
				<strong>{{ $errors->first('peso') }}</strong>
			</span>
		@endif
		</div>
	</div>
	<!-- Fin row 8 -->

	<!-- row 9 -->              
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			Se&ntilde;al particular:
		</div>

		<div class="col-lg-6 ">
			{!! Form::text('sena',null, ['class'=>"form-control",'placeholder'=>'Se&ntilde;al particular']) !!}
		</div>
	</div>
	<!-- Fin row 9 -->

	<!-- Row 10 -->
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			&Uacute;ltima Vacuna:
		</div>
		<div class="col-lg-6">

			<label class="checkbox-inline">
				{!! Form::radio('vacuna','Al dia',true) !!} Al dia <span class="fa fa-smile-o text-success"></i>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('vacuna','No sabe',false) !!} No sabe <span class="fa fa-frown-o text-danger"></i>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('vacuna','Pendiente',false) !!} Pendiente <span class="fa fa-exclamation-triangle text-warning"></i> 
			</label>
			
			<br/>
		</div>
	</div>
	<!-- Fin Row 10 -->

	<!-- Row 11 -->
	<div class="row">
		<br/>
		<div class="col-lg-3 col-lg-offset-1 text-right">
			&Uacute;ltima Desparasitaci&oacute;n:
		</div>
		<div class="col-lg-6">
			<label class="checkbox-inline">
				{!! Form::radio('desparasitacion','Al dia',true) !!} Al dia <span class="fa fa-smile-o text-success"></i>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('desparasitacion','No sabe',false) !!} No sabe <span class="fa fa-frown-o text-danger"></i>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('desparasitacion','Pendiente',false) !!} Pendiente <span class="fa fa-exclamation-triangle text-warning"></i> 
			</label>
			
			<br/>
			
		</div>
	</div>
	<!-- Fin Row 11 -->

	<!-- Row 12 -->
	<div class="row">
		<br/>
		<div class="col-lg-12 text-center">

			<button type="submit" class="btn btn-primary">
				<i class="fa fa-plus"></i> Agregar Mascota 
			</button>
			&nbsp;&nbsp;
			<a href="#">Cancelar</a>

		</div>
	</div>
	<!-- Fin Row 12 -->
{!! Form::close() !!}