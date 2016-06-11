@if(! $errors->isEmpty())
  <div class="alert alert-danger alert-dismissible" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="close">
  		<span aria-hidden="true">&times;</span>
  	</button>
    <p><strong>Ooops!</strong> Ha ocurrido un error, por favor corrija lo que mas abajo se indica</p>
    <div id="mensajeError">
    </div>
  </div>
@endif

