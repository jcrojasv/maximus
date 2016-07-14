<script>
$(document).ready(function(){
	

	//Carga los select dependientes dependiendo de la accion click en el elemento especie
	$('input:radio[name=especie_id]').click(function() {
		var cod = $('input:radio[name=especie_id]:checked').val();
		
		//llamada a la funcion para cargar razas
		url = "{{ url('selectRazas')}}";
		$.cargaSelect(url,'#divRaza',cod,null);

		//llamada a la funcion para cargar razas
		url = "{{ url('selectAlimentos')}}";
		$.cargaSelect(url,'#divAlimentos',cod,null);


	});

	//Acciones del boton Agregar mascota
	$('#btnMascota').click(function(){
		
		var form = $('#frmMascota');
		var ruta = form.attr('action');
		var data = form.serialize();
		var token = $("input[name=_token]").val();

		$.ajax({
			url: ruta,
			headers: {'X-CSRF-TOKEN': token},
			type: 'post',
			dataType: 'json',
			data: data,
			beforeSend:  function(){
				$('span.help-block').addClass('hidden');
				$('div').removeClass('has-error');
			},

		}).done(function(respuesta) {

			//Recargo los datos en datatable para que muestre los cambios recientes
			$('#tabla').DataTable().ajax.reload();
			
			//Desvanecemos la ventana modal
			$('#ventanaModal').modal('hide');

			$('#mensaje').html(' ');

			$('#divMensajes').removeClass('hidden').addClass('alert-success').fadeIn();

			$("#pMensajes").html('<strong>Yeah!!</strong> ' + respuesta.message);

	
		}).fail(function(respuesta){

			$.each(respuesta.responseJSON,function (ind, elem) { 
  			
  				$('div.'+ind).removeClass('hidden').addClass('has-error');
  				
  				$('span.'+ind).removeClass('hidden');

  				$('span.'+ind).html(' ');
  				$('span.'+ind).html('<strong>'+elem+'</strong>');

			});
				

		});
		

	});

	
});

</script>