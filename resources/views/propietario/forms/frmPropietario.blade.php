<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="text-primary">Datos del Propietario</h4>
		</div>
		
		<!-- Datos Propietario -->
		<div class="panel-body">
			<!-- row 1 -->              
			<div class="row {{ $errors->has('id') ? ' has-error' : '' }}">

				<div class="col-lg-3 col-lg-offset-1 text-right">
	
				  Documento de Identificaci&oacute;n:
				
				</div>

				<div class="col-lg-6 ">
					{!! Form::text('id',null, ['class'=>"form-control",'placeholder'=>'Cedula']) !!}
					
					@if ($errors->has('id'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('id') }}</strong>
                        </span>
                    @endif

				</div>
			</div>
			<!-- Fin row 1 -->

			<!-- Row 2 -->
			<div class="row {{ $errors->has('email') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Email:
				</div>
				<div class="col-lg-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope-o"> </i></span>  
						{!! Form::email('email',null, ['class'=>"form-control",'placeholder'=>'ejemplo@server.com']) !!}
					</div>
					@if ($errors->has('email'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
				</div>
			</div>
			<!-- Fin Row 2 -->

			<!-- Row 3 -->
			<div class="row {{ $errors->has('nombres') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Nombres:
				</div>

				<div class="col-lg-6">
					{!! Form::text('nombres',null, ['class'=>"form-control",'placeholder'=>'Nombres']) !!}
					@if ($errors->has('nombres'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('nombres') }}</strong>
                        </span>
                    @endif
				</div>
				
			</div>
			<!-- Fin row 3 -->

			<!-- Row 4 -->
			<div class="row {{ $errors->has('apellidos') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Apellidos:
				</div>
				<div class="col-lg-6">
					{!! Form::text('apellidos',null, ['class'=>"form-control",'placeholder'=>'Apellidos']) !!}
					@if ($errors->has('apellidos'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('apellidos') }}</strong>
                        </span>
                    @endif
				</div>
			</div>	
			<!-- Fin row 4 -->

			<!-- Row 5 -->
			<div class="row {{ $errors->has('direccion') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Direcci&oacute;n:
				</div>
				
				<div class="col-lg-6">		
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 
						{!! Form::text('direccion',null, ['class'=>"form-control",'placeholder'=>'Direccion']) !!}
												
					</div>
					@if ($errors->has('direccion'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('direccion') }}</strong>
                        </span>
                    @endif
				</div>
			</div>
			<!-- Fin row 5 -->

			<!-- Row 6 -->
			<div class="row {{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
					Tel&eacute;fono Fijo:
				</div> 
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="input-group ">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
						{!! Form::text('telefono_fijo',null, ['class'=>"form-control",'placeholder'=>'(034)-298 73 70)']) !!}
						
					</div>
					@if ($errors->has('telefono_fijo'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('telefono_fijo') }}</strong>
                        </span>
                    @endif
				</div>
			</div>
			<!-- Fin row 6 -->

			<!-- Row 7 -->
			<div class="row {{ $errors->has('telefono_celular') ? ' has-error' : '' }}">
				<br/>
				<div class="col-lg-3 col-lg-offset-1 text-right">
				 	Tel&eacute;fono Celular
				</div> 

				<div class=" col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
						{!! Form::text('telefono_celular',null, ['class'=>"form-control",'placeholder'=>'(300)-888 60 63)']) !!}
						
					</div>
					@if ($errors->has('telefono_celular'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('telefono_celular') }}</strong>
                        </span>
                    @endif
				</div>
			</div>
			<!-- Fin Row 7 -->

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