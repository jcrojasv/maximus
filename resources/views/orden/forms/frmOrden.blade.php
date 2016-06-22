
@section('sectionFrmOrden')

<script>
$(document).ready(function(){
//Carga los servicios especializado
	$('input:radio[name=tipo]').on('click',function() {
		var cod = $('input:radio[name=tipo]:checked').val();
		if(cod == 'ESP')
		{
			var ruta = "{{ route('orden.esp')}}";
			
			//lamado ajax metodo get para tomar el listado de la busqueda
			$.ajax({
				url: ruta,
				type: 'get',
				dataType: 'json',
			}).done(function(data) {

				$('#especializados').empty().append($(data));
	        	
	    	}).fail(function(data){

                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }

	    	});
		} else {

			$('#especializados').empty();

		}

	});

	//Peticion ajax para grabar datos del formulario, al darle click al boton grabar
	$('#btnAddOrden').click(function(){

		var ruta = "{{ route('orden.store') }}";
		var form = $('#frmOrden').serialize();
		var token = $("input[name=_token]").val();
		
		$.ajax({url: ruta,
			headers: {'X-CSRF-TOKEN': token},
			type: 'post',
			dataType: 'json',
			data: form,
			beforeSend:  function(){
				$('span.help-block').addClass('hidden');
				$('div').removeClass('has-error');
			},
		}).done(function(){
			alert('Funciona');
		}).fail(function(respuesta){

			$.each(respuesta.responseJSON,function (ind, elem) { 
  				alert(ind+' --->'+elem);
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

			});
		});


	});

	//Cargo el timepicker al campo entrada
	$('#entrada').timepicker({
		template: false,
		snapToStep: true,
		minuteStep: 5,
		showInputs: false,
		disableFocus: true,
		explicitMode: true,
		showMeridian: false
	});

	//Cargo el timepicker al campo salida
	$('#salida').timepicker({
		
		template: false,
		snapToStep: true,
		minuteStep: 5,
		showInputs: false,
		disableFocus: true,
		explicitMode: true,
		defaultTime: false,
		showMeridian: false
	});

});
</script>

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
			
			</div>

			<div class="col-lg-3">

				<div class="input-group date" data-provide="datepicker">
					
					{!! Form::hidden('mascota_id',$mascotaId,['id'=>'mascota_id'])!!}

					{!! Form::text('fecha',null, ['id'=>'fecha','class'=>'form-control','data-provide'=>'datepicker','data-date-format'=>'dd-mm-yyyy']) !!}
			        <div class="input-group-addon">
				        <span class="fa fa-calendar"></span>
				    </div>
				</div>					
				
				<span class="help-block fecha hidden"></span>
                
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
				
					<div class="row arregloEsp">
						<br/>
						<div class="col-lg-4 text-right">
							Arreglos Especializados:
						</div>
						
						<div class="col-lg-8">
						@foreach($arreglosEsp as $clave=>$valor)
							
							<div class="checkbox">
							<label>
								{!! Form::checkbox('arregloEsp[]',$clave,null,['id'=>'arregloEsp[]']) !!} 
								{{$valor}} 
							</label>
							</div>
						@endforeach	
						<span class="help-block arregloEsp hidden"></span>
						</div>

					</div>
				

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
		
		<!-- row 6 -->              
		<div class="row">

			<div class="col-lg-3 col-lg-offset-1 text-right">

			 Observaciones:
			
			</div>

			<div class="col-lg-8">
				
				{!! Form::text('observaciones',null, ['id'=>'observaciones','class'=>'form-control']) !!}	

			</div>
		</div>
		<!-- Fin row 6 -->

		<!-- Row 8 -->
		<div class="row">
			<br/>
			<div class="col-lg-12 text-center">
			
				<button type="button" class="btn btn-primary" id="btnAddOrden">
					<i class="fa fa-save"></i> Guardar 
				</button>
				&nbsp;&nbsp;
				<a href="#">Cancelar</a>

			</div>
		</div>
		<!-- Fin Row 8 -->

	</div> <!-- Fin panel-body -->

		
</div>
@endsection