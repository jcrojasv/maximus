<div class="modal fade" id='ventanaModal' tabindex="-1" role='dialog' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class="modal-header">
        
        <button type='button' class="close" data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4>B&uacute;squeda de Mascota</h4>
        
      </div>
      
      <div class="modal-body">
        
        <div class="box">  
          <form class="form" role="form" id="frmBuscar" name="frmBuscar" action="javascript:void(null);">
            <div class="box-body">
             
             {{ csrf_field() }}
             <div class='row'>
               
               <div class="col-lg-4 col-md-4 col-sm-4"> 
                 <input placeholder="Mascota" class="form-control " type="text" id="mascota" name="mascota" >
               </div>
               
               <div class="col-lg-5 col-md-5 col-sm-5"> 
                 <input placeholder="Propietario" class="form-control" type="text" id="propietario" name="propietario" >
               </div>
               
                            
               <div class="col-lg-3 col-md-3 col-sm-3"> 
                 <button class="btn btn-info" id="btnBuscar" type="submit"><i class="fa fa-search"></i> Buscar</button>
               </div>
               
             </div>
             
           </div>
           
         </form>
         
       </div>
             

      <div id="listado">
        @section('listadoBusqueda')
          <script>
          //DataTable
            $('#tabla').DataTable({
              responsive: true,
              bFilter:     false,
             "language": { "url": "/i18n/dataTable.spanish.lang"},
              
            });
          </script>
          @if(isset($objResult))
          <br/>
            <table class='table table-striped table-hover' id='tabla'>
            <thead><tr><th>Mascota</th><th>Esp/Raza</th><th>Propietario</th><th>Accion</th></tr></thead>
              <tbody>
              
                  @foreach ($objResult as $objMascota) 
                  <tr data-id="{{ $objMascota->id}}" >
                      <td>{{$objMascota->nombre}}</td>
                      <td>{{ $objMascota->especie->descripcion }} / {{$objMascota->descripcion}}</td>
                      <td>{{$objMascota->nombres}}</td>
                      <td><a href='#' class='btn btn-warning btn-sm btn-select' data-id="{{$objMascota->id}}"><i class="fa fa-hand-rock-o"></i> Select</a></td></tr>
                  @endforeach                
              </tbody>
         
            </table>

          @endif
        @endsection
      </div>
       
     </div>
     
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-danger" data-dismiss='modal'>Cerrar</button> 
    </div>
    
     
  </div>
</div>
</div>
