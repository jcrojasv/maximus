@extends('layouts/app')

@section('title','Ficha tecnica')


@section('cuerpo')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ficha T&eacute;cnica</h1>
	</div>
</div>

 @include('errors/errors')

<div class="row">
	
	{!! Form::open(['method'=>'post','route'=>'propietario.store'])!!}

		@include('propietario.forms.frmPropietario')
	
	{!! Form::close() !!}
</div>
@endsection

