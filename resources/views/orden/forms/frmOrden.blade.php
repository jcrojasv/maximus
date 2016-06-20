<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="text-primary">Datos de la orden</h4>
		</div>
		
		<!-- Datos Propietario -->
		<div class="panel-body">
			<!-- row 1 -->              
			<div class="row {{ $errors->has('fecha') ? ' has-error' : '' }}">

				<div class="col-lg-3 col-lg-offset-1 text-right">
	
				 Fecha del Servicio:
				
				</div>

				<div class="col-lg-3">

					<div class="input-group date" data-provide="datepicker">
						{!! Form::text('fecha',null, ['id'=>'fecha','class'=>'form-control','data-provide'=>'datepicker','data-date-format'=>'dd-mm-yyyy']) !!}
				        <div class="input-group-addon">
					        <span class="fa fa-calendar"></span>
					    </div>
					</div>					
					
					@if ($errors->has('fecha'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('fecha') }}</strong>
                        </span>
                    @endif

				</div>
			</div>
			<!-- Fin row 1 -->

			<!-- Row 2 -->
			<div class="row {{ $errors->has('entrada') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Hora de entrada / Hora de salida:
				</div>
				<div class="col-lg-3">
					<div class="input-group bootstrap-timepicker timepicker">
						{!! Form::text('entrada',null, ['id'=>'entrada','class'=>'form-control input-small']) !!}
						<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
					</div>
					 
					@if ($errors->has('entrada'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('entrada') }}</strong>
                        </span>
                    @endif
				</div>

				<div class="col-lg-3">
					<div class="input-group bootstrap-timepicker timepicker">
						{!! Form::text('salida',null, ['id'=>'salida','class'=>'form-control input-small']) !!}
						<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
					</div>
					 
					@if ($errors->has('salida'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('salida') }}</strong>
                        </span>
                    @endif
				</div>
			</div>
			<!-- Fin Row 2 -->
				
			<!-- Row 3 -->
			<div class="row">
				<br/>
				<div class="col-lg-4 text-right">
					Tipo de servicio:
				</div>

				<div class="col-lg-8">
					<label class="checkbox-inline">
						{!! Form::radio('tipo','1',true,['id'=>'tipo']) !!} Comercial 
					</label>
					<label class="checkbox-inline">
						{!! Form::radio('tipo','2',false,['id'=>'tipo']) !!} Especializado
					</label>
				</div>

			</div>
			<!-- Fin row 3 -->
			

			<!-- Row 8 -->
			<div class="row">
				<br/>
				<div class="col-lg-12 text-center">
				
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save"></i> Guardar 
					</button>
					&nbsp;&nbsp;
					<a href="#">Cancelar</a>

				</div>
			</div>
			<!-- Fin Row 8 -->

		</div> <!-- Fin panel-body -->

		
	</div>