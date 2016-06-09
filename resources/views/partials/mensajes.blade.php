@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="close">
  		<span aria-hidden="true">&times;</span>
  	</button>
    <p>{{ Session::get('message')}}</p>
    
  </div>
@endif

