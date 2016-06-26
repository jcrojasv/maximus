@extends('layouts/app')

@section('title','Ficha tecnica')


@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Ficha T&eacute;cnica <i class="fa fa-folder-open-o"></i></h2>
	</div>
</div>

 @include('errors/errors')

<div class="row">
	
	{!! Form::open(['method'=>'post','route'=>'propietario.store'])!!}

		@include('propietario.forms.frmPropietario')
	
	{!! Form::close() !!}
</div>
@endsection

