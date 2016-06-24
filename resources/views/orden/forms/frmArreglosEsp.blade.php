<div class="row arregloEsp">
	<br/>
	<div class="col-lg-4 text-right">
		Arreglos Especializados:
	</div>
	
	<div class="col-lg-8">
	@foreach($arreglosEsp as $clave=>$valor)
		
		<div class="checkbox">
		<label>
			{!! Form::checkbox('arregloEsp[]',$clave,(in_array($clave,$arreglosIncluidos)),['id'=>'arregloEsp[]']) !!} 
			{{$valor}} 
		</label>
		</div>
	@endforeach	
	<span class="help-block arregloEsp hidden"></span>
	</div>

</div>