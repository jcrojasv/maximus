
  <div class="alert {{ Session::has('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible {{ Session::has('message') ? '' : ' hidden' }}" role="alert" id="{{ isset($divMensajes) ? $divMensajes : 'divMensajes' }}">
  	<button type="button" class="close" data-dismiss="alert" aria-label="close">
  		<span aria-hidden="true">&times;</span>
  	</button>
    <p id="{{ isset($pMensajes) ? $pMensajes : 'pMensajes' }}">
    	@if(Session::has('message')) 
    	  {{ Session::get('message')}}
    	@endif
   </p>
    
  </div>


