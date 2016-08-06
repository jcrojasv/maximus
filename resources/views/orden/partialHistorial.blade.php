<!--Listado historial de mascotas -->
@if(isset($resultHistorial))
	<script>
	//Funcion para cargar datatable
	$('#tblHistorial').DataTable({
    	responsive: true,
    	stateSave:  true,
	   "language": { "url": "/i18n/dataTable.spanish.lang"},
	   "processing": true,
	   	
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
