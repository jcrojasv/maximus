
<div class="modal fade" id='ventanaModal' tabindex="-1" role='dialog' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class="modal-header">
        
        <button type='button' class="close cancelar" data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class="text-primary"><span id="tituloModal">Agregar</span> Mascota</h4>
        
      </div>
      
      <div class="modal-body" id="divFrmMascota">
	{!! Form::open(['route'=>'mascota.store','id'=>'frmMascota'])!!}
	<!-- row 1 -->              
	<div class="row nombre">

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
					{!! Form::radio('especie_id','1',false,['id'=>'especie_id','class'=>'especie_id']) !!} Canina
				</label>
				<label class="checkbox-inline">
					{!! Form::radio('especie_id','2',false,['id'=>'especie_id','class'=>'especie_id']) !!} Felina
				</label>
			
			<span class="help-block especie hidden"><br/></span>
			
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
				{!! Form::select('raza_id',['--> Indique Especie <--'],['id'=>'raza_id']) !!}
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
			{!! Form::select('color_id',$colores,['id'=>'color_id']) !!}
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
			<div id="divAlimentos">{!! Form::select('alimento_id',['--> Indique Especie <--'],['id'=>'alimento_id']) !!}</div>
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
				{!! Form::radio('vacuna','Al dia',true,['id'=>'vacuna']) !!} Al dia <span class="fa fa-smile-o text-success"></i></span>
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
				{!! Form::radio('desparasitacion','Al dia',true,['id'=>'desparasitacion']) !!} Al dia <span class="fa fa-smile-o text-success"></i></span>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('desparasitacion','No sabe',false,['id'=>'desparasitacion']) !!} No sabe <span class="fa fa-frown-o text-danger"></i></span>
			</label>

			<label class="checkbox-inline">
				{!! Form::radio('desparasitacion','Pendiente',false,['id'=>'desparasitacion']) !!} Pendiente <span class="fa fa-exclamation-triangle text-warning"></i> </span>
			</label>
			
			<br/>
			<br/>
			
		</div>
	</div>
	<!-- Fin Row 11 -->

	<!-- Row 12 -->
	<div class="modal-footer">
		<br/>
		
		<button type="button" class="btn btn-primary" id="btnAddMascota">
			<i class="fa fa-plus"></i> Agregar Mascota 
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
