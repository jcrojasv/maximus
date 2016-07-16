@extends('layouts/app')

@section('title','Historia de Mascota') 

@section('estilos')
	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>	
@endsection

@section('scriptsJs')
<!-- Data Tables -->
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>

<script>
$(document).ready(function(){

  	//Accion busqueda de mascotas
	$('#btnBuscar').click(function(){
		var ruta = "{{ route('orden.buscarMascota')}}";
		var form = $('#frmBuscar');
		var frmData = form.serialize();
		
		//lamado ajax metodo get para tomar el listado de la busqueda
		$.ajax({
				url: ruta,
				type: 'get',
				dataType: 'json',
				data: frmData,
		}).done(function(data) {

			$('#listado').empty().append($(data));
        	
    	}).fail(function(data){

                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }


    	});

	});

	//Accion al seleccionar un mascota
	//Funcion para seleccionar la mascota del listado de la busqueda
    $('#listado').on('click','a.btn-select',function(){
      
      var ruta = "{{ route("orden.selectMascota") }}";

      var mascota = $(this).data('id');
    
      //lamado ajax metodo get para tomar el formulario
      $.get(ruta,{id : mascota},function(data) {

            $('#datosMascota').empty().append($(data)).fadeIn('slow');
            
            //Oculto la ventana modal
            $('#ventanaModal').modal('toggle');

        }).done(function(){

          //Llamo por ajax el formulario de crear si la peticion anterior tuvo exito
          var ruta = "{{ route('orden.index')}}/showHistorial/"+mascota;
 			
          $.get(ruta,null,function(data){
            
            $('#divHistorial').empty().append($(data)).fadeIn('slow');


          }).fail(function(data){

            var errors = data.responseJSON;
            if (errors) {
                $.each(errors, function (i) {
                    console.log(errors[i]);
                });
            }

          });
        });
    
    });

    
	
});

</script>
@endsection

@section('cuerpo')
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Historial de Mascotas <span class="fa fa-github-alt"></span></h1>
		</div>
	</div>

	<div class="row">
		@include('partials.mensajes')
	</div>

	<div class="row">
		<div class="panel panel-info">

			<div class="panel-heading">
				<h4 class="text-primary">Datos de la Mascota <i class="fa fa-github-alt"></i></h4>
			</div>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3">
						<button type="button" class="btn btn-info btn-block" id="btnBuscarMascota" data-toggle="modal" data-target="#ventanaModal">
						<strong>Buscar mascota ...</strong> <i class="fa fa-search"> </i></button>
					</div>
				</div>

				<!-- datos de la mascota, resultado de la busqueda -->
				<div class="row" >
					<br/>
					<div id="datosMascota">
					@section('sectionDatos')
					@if(isset($resultMascota))
						
						@include('orden.datosMascota')

					@endif
					@endsection
					</div>
				</div>

			</div>
		</div>
	</div>
	
	<!--Listado historial de mascotas -->
	<div id="divHistorial">
	@section('renderHistorial')
		@if(isset($resultHistorial))
			<script>
			//Funcion para cargar datatable
			$('#tblHistorial').DataTable({
		    	responsive: true,
		    	stateSave:  true,
			   "language": { "url": "/i18n/dataTable.spanish.lang"},
			   "processing": true,
		       "order": [[ 2, "desc" ]],
		       "aaSorting": [[ 2, "desc" ]]
			   	
		    });
			</script>
			<h3>Historial de ordenes</h3>
			<table class="table table-striped table-hover table-bordered" id='tblHistorial'>
			<thead>
				<tr>
					<th>N&deg;</th>
					<th>Tipo</th>
					<th>Fecha</th>
					<th>Ent/Sal</th>
					<th>Tiempo</th>
					<th>Acci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
			@foreach($resultHistorial as $historial)
				<tr @if($historial->estatus) class='danger' @endif>
					<td>{{$historial->id}}</td>
					<td>{{($historial->tipo=='COM') ? 'Comercial' : 'Especializado'}}</td>
					<td>{{$historial->prettyDate('fecha')}}</td>
					<td>{{$historial->entrada}} / {{$historial->salida}}</td>
					<td>{{$historial->tiempo}}</td>
					<td><a href='{{ route('orden.edit',$historial->id) }}' class="btn btn-warning btn-sm"><i class='fa fa-pencil'></i> Editar</a></td>
				</tr>
				
			@endforeach	
			</tbody>
	
			
			</table>
		@endif
	@endsection
	</div>

	@include('orden.forms.frmBuscarMascota')

@endsection