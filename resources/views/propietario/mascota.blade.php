<!--Tab formulario datos de la mascota -->
				<div class="tab-pane" id="tab2">

					<div class="row"> <!-- fila 1 --> 
						<!-- columna 1.1 -->
						<div class="col-lg-6">
							<br/>

							<label for="nombres">Mascota</label>
							<div class="input-group">
								<input placeholder="Nombre de la mascota" class="form-control required" type="text" id="mascota" name="mascota" >
								<span class="input-group-btn">
									<button class="btn btn-info" type="button" data-toggle="modal" data-target="#ventanaModal">
										<i class="fa fa-search"> </i>
									</button>
								</span>
							</div>
						</div>
						<!-- Fin columna 1.1 --> 

						<!-- columna 1.2 -->
						<div class="col-lg-6">
							<br/>
							<label>Especie</label>
							<div>

								<label class="radio-inline">
									<input name="idEspecie" id="idEspecie" value="1" type="radio">Canina
								</label>
								<label class="radio-inline">
									<input name="idEspecie" id="idEspecie" value="2"  type="radio">Felina
								</label>
							</div>

						</div>  
						<!-- Fin columna 1.2 -->  
					</div>
					<!--Fin row 1 -->

					<!-- Row 2 -->
					<div class="row">

						<!-- columna 2.1 -->
						<div class="col-lg-6">
							<br/>
							<label for="raza">Raza</label>  
							<div id='divSelectRaza'>
								<select name="razaId" id="razaId" class="form-control">

									<option value="0"><-- Seleccione una especie --></option>

								</select>
							</div>

						</div>
						<!-- Fin columna 2.1 -->

						<!-- columna 2.2 -->
						<div class="col-lg-6">
							<br/>
							<label for="color">Color</label>
							<div id='divSelectRaza'>  
								<select name="idColor" class="form-control">
									@foreach($colores as $color)
									<option value="{{ $color->id}}">{{ $color->color }}</option>
									@endforeach
								</select>
							</div>

						</div>
						<!-- Fin columna 2.1 -->

					</div>
					<!-- Fin Row 2 -->

					<!-- Fila 3 -->
					<div class="row">

						<!-- Columna 3.1 -->
						<div class="col-lg-6">
							<br/>
							<label>Sexo</label>
							<div>
								<label class="radio-inline">
									<input name="sexo" id="sexo" value="M" checked="" type="radio">Macho
								</label>
								<label class="radio-inline">
									<input name="sexo" id="sexo" value="F" checked="" type="radio">Hembra
								</label>
							</div>

						</div>
						<!-- Fin Columna 3.1 -->

						<!--Columna 3.2 -->
						<div class="col-lg-6">
							<br/>
							<label>Fecha de Nacimiento</label> 
							<div class="input-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
								<span class="input-group-addon"><i class="fa fa-calendar"></i>	</span>
								<input class="form-control" data-inputmask="'mask': ['99/9999']" data-mask="" type="text" name="fechaNacimiento" id="fechaNacimiento">
							</div>

						</div>
						<!-- Fin columna 3.2 -->
						<br/>
					</div> <!-- Fin row 3 -->

					<!-- Fila 4 -->
					<div class="row">

						<!-- Columna 4.1 -->
						<div class="col-lg-6">
							<br/>
							<label>Peso</label>
							<div class="input-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
								<span class="input-group-addon">
									<i class="fa fa-dashboard"></i>  
								</span>
								<input class="form-control" data-inputmask="'mask': ['999']" data-mask="" type="text" name="peso" id="peso">
							</div>

						</div>
						<!-- Fin Columna 4.1 -->

						<!--Columna 4.2 -->
						<div class="col-lg-6">
							<br/>
							<label for="nombres">Alimento que consume</label> 
							<div id='divSelectAlimentos'>
								<select name="alimentoId" id="alimentoId" class="form-control">

									<option value="0"><-- Seleccione una especie --></option>

								</select>
							</div>
							
						</div>
						<!-- Fin columna 4.2 -->
						<br/>
					</div> <!-- Fin row 4 -->

					<!--Row 5 -->
					<div class="row">
						<!-- Columna 5.1 -->

						<div class="col-lg-6">
							<br/>
							<label for="nombres">&Uacute;ltima Vacuna</label> 
							<input class="form-control" type="text" name="ultimaVacuna" id="ultimaVacuna">
						</div>
						<!-- Fin columna 5.1 -->

						<!-- Columna 5.2 -->
						<div class="col-lg-6">
							<br/>
							<label for="nombres">&Uacute;ltima Desparasitaci&oacute;n</label> 
							<input class="form-control" type="text" id="ultimaDesparasitacion" name="ultimaDesparasitacion">
						</div>
						<!-- Fin columna 5.2 -->

					</div>
					<!-- Fin row 5 -->
					<br/>
					<div class="text-right">
					 <button type='submit' class="btn btn-primary">
						<i class="fa fa-save"></i> Guardar
					  </button>
					</div>
				</div><!-- Fin Tab Mascota-->