<div class="panel panel-default">

	<div class="panel-heading">
		<h4 class="text-primary">Datos de la orden</h4>
	</div>
	
	<!-- Datos Propietario -->
	<div class="panel-body">
		<!-- row 1 -->              
		<div class="row fecha">

			<div class="col-lg-3 col-lg-offset-1 text-right">

			 Fecha del Servicio:
			{!! Form::hidden('mascota_id',$mascotaId,['id'=>'mascota_id'])!!}
			</div>

			<div class="col-lg-3">

				<div class="input-group">
					
					{!! Form::text('fecha',date('d-m-Y'), ['id'=>'fecha','class'=>'form-control']) !!}
					
			        <div class="input-group-addon">
				        <span class="fa fa-calendar"></span>
				    </div>
				</div>					
				
				<span class="help-block fecha hidden"></span>
                
			</div>
			<div class="col-lg-3">
				{!! Form::checkbox('estatus',1,true) !!}
			</div>
		</div>
		<!-- Fin row 1 -->

		<!-- Row 2 -->
		<div class="row entrada">
			<br/>
			<div class="col-lg-3 col-lg-offset-1 text-right">
				Hora de entrada / Hora de salida:
			</div>
			<div class="col-lg-3">
				<div class="input-group bootstrap-timepicker timepicker">
					{!! Form::text('entrada',null, ['id'=>'entrada','class'=>'form-control input-small']) !!}
					<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
				 
				<span class="help-block entrada hidden"></span>
			</div>

			<div class="col-lg-3">
				<div class="input-group bootstrap-timepicker timepicker">
					{!! Form::text('salida',null, ['id'=>'salida','class'=>'form-control input-small']) !!}
					<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				</div>
				 
				<span class="help-block salida hidden"></span>
			</div>
		</div>
		<!-- Fin Row 2 -->
			
		<!-- Row 3 -->
		<div class="row tipo">
			<br/>
			<div class="col-lg-4 text-right">
				Tipo de servicio:
			</div>

			<div class="col-lg-8">
				<label class="checkbox-inline">
					{!! Form::radio('tipo','COM',true,['id'=>'tipo']) !!} Comercial 
				</label>
				<label class="checkbox-inline">
					{!! Form::radio('tipo','ESP',false,['id'=>'tipo']) !!} Especializado
				</label>
			</div>
			<span class="help-block tipo hidden"></span>
		</div>
		<!-- Fin row 3 -->


		<div id='especializados'>
			
			@section('sectionEsp')
				@if(isset($arreglosEsp))
				
					@include('orden.forms.frmArreglosEsp',['arreglosIncluidos'=>array()])				

				@endif
			@endsection

		</div>

		<!-- Row 5 -->
		<div class="row arregloGen">
			<br/>
			<div class="col-lg-4 text-right">
				Arreglos generales:
			</div>

			
			<div class="col-lg-8">
			@foreach($arreglosGen as $clave=>$valor)
				
				<div class="checkbox">
				<label>
					{!! Form::checkbox('arregloGen[]',$clave,null,['id'=>'arregloGen']) !!} 
					{{$valor}} 
				</label>
				</div>
			@endforeach	
			<span class="help-block arregloGen hidden"></span>
			</div>
			
		</div>
		<!-- Fin row 5 -->

		<!-- Row 6 -->
		<div class="row tipo">
			<br/>
			<div class="col-lg-4 text-right">
				Precio:
			</div>

			<div class="col-lg-8">
				
				{!! Form::text('precio',null,['id'=>'precio','class'=>'form-control']) !!}
				
			</div>

			<span class="help-block precio hidden"></span>
	
		</div>
		<!-- Fin row 6 -->
		
		<!-- row 7 -->              
		<div class="row">
			<br/>
			<div class="col-lg-3 col-lg-offset-1 text-right">

			 Observaciones:
			
			</div>

			<div class="col-lg-8">
				
				{!! Form::text('observaciones',null, ['id'=>'observaciones','class'=>'form-control']) !!}	

			</div>
		</div>
		<!-- Fin row 7 -->
		
		<!-- row 8 -->              
		<div class="row">
			<br/>
			<div class="col-lg-3 col-lg-offset-1 text-right">

			 Observaciones Groomer:
			
			</div>

			<div class="col-lg-8">
				
				{!! Form::text('observaciones_groomer',null, ['id'=>'observaciones_groomer','class'=>'form-control']) !!}	

			</div>
		</div>
		<!-- Fin row 8 -->

		<!-- Row 9 -->
		<div class="row">
			<br/>
			<div class="col-lg-12 text-center">
			
				<button type="button" class="btn btn-primary" id="btnAddOrden">
					<i class="fa fa-save"></i> Guardar 
				</button>
				&nbsp;&nbsp;
				<a href="{{ URL::previous() }}">Cancelar</a>

			</div>
		</div>
		<!-- Fin Row 9 -->

	</div> <!-- Fin panel-body -->

		
</div>