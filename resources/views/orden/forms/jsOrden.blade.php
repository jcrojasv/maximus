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
		}).fail(function(respuesta){

			$.each(respuesta.responseJSON,function (ind, elem) { 
  				
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

			});
		}).done(function(respuesta){
			
        	var ruta = "{{ url('orden')}}/"+respuesta.ordenId+"/edit";
        	window.location = ruta;

		});


	});

	//Cargo el datepicker
	$('#fecha').datepicker({
		format: 'dd-mm-yyyy',
		language: 'es',
		toggleActive: true,
		todayHighlight: true,
		autoclose: true,
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

	//Cambio el checkbox de estatus a boton on-off
	$(function(){
		$('input[name=estatus]').bootstrapToggle({
	      on: 'En proceso',
	      off: 'Finalizada'
	    });
	});
	

});
</script>