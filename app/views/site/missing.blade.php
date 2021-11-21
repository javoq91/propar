@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Error 404 - Página no encontrada ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">

		<div class="row">

			<div class="col-sm-12 bg_gris">

				<h1>Error 404 - Página no encontrada</h1>

			</div>

		</div>

		<div class="row">

			<div class="col-md-8 text-center">

				<br /><br />

				<h1><i class="fa fa-exclamation-triangle fa-3x"></i></h1>

				<br />

				<p>La página que está buscando no existe.</p>

			</div>

			<div class="col-md-4 bg_gris">

				<div class="sidebar">

					<div class="row">

						<div class="col-xs-12">

							<select>

								<optgroup label="Tipo de operación">

									<option value="0">Compra</option>
									<option value="0">Venta</option>
									<option value="0">Alquiler</option>
									
								</optgroup>

							</select>
							
						</div>

						<div class="col-xs-12">

							<select>

								<optgroup label="Seleccione el tipo de inmueble">

									<option value="0">Terreno / Lote</option>
									<option value="0">Casa</option>
									<option value="0">Departamento</option>
									
								</optgroup>

							</select>
							
						</div>

						<div class="col-xs-12">

							<select>

								<optgroup label="Ciudad">

									<option value="0">Asunción</option>
									<option value="0">Encarnación</option>
									<option value="0">Ciudad del Este</option>
									<option value="0">Paraguarí</option>
									<option value="0">San Bernardino</option>
									<option value="0">Caacupe</option>
									<option value="0">Kurusú de Hierro</option>
									
								</optgroup>

							</select>
							
						</div>

						<div class="col-xs-12">

							<button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
							
						</div>

					</div>

				</div>
			</div>

		</div>

	</div>
		
@stop
