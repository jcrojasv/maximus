@extends('layouts/app')

@section('title','Acumulado de Ordenes por Mascota') 

@section('estilos')

	<!-- Bootstrap Core CSS -->
    <link href='/css/dataTables.bootstrap.css' type="text/css" rel="stylesheet"/>
	
@endsection

@section('scriptsJs')
<script src='/js/jquery.dataTables.min.js' type="text/javascript"> </script>
<script src='/js/dataTables.bootstrap.min.js' type="text/javascript"></script>
<script>
$(document).ready(function(){

	
	//Funcion para cargar datatable
	$('#tabla').DataTable({
    	responsive: true,
    	stateSave:  true,
	   "language": { "url": "/i18n/dataTable.spanish.lang"},
	   "processing": true,
       "serverSide": true,
       "ajax": "/orden/listAcumulado",
       "columns": [
       		{data: 'mascota'},
       		{data: 'esp'},
       		{data: 'propietario'},
       		{data: 'cant'},
       		{data: 'action'},

       ],
       "order": [[ 3, "desc" ]],
       "aaSorting": [[ 3, "desc" ]]
	   	
    });

	
        
});

</script>
@endsection

@section('cuerpo')

<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Acumulado de Ordenes por Mascota {{ $year }}<span class=""></span></h2>
	</div>
</div>


<div class="row">
	@include('partials.mensajes')
</div>


<div class="row">
		
	<table class="table table-striped table-hover" id='tabla'>
	<thead>
		<tr>
			<th>Mascota</th>
			<th>Esp / Raza</th>
			<th>Prop.</th>
			<th>Cant.</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	</table>
	
</div>

@endsection