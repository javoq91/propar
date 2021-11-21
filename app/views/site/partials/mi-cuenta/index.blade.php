@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Mi Cuenta ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">
		<!--
		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Mi Cuenta</h1>

			</div>

		</div>
		-->
		<div class="row">

			<div class="col-md-12">

				<table class="table">

          <thead>
            <tr>
              <th>Lote</th><th>Cuotas pagadas</th><th>Cuotas vencidas</th><th>Total pagado</th><th>Total vencido</th><th>Opciones</th>
            </tr>
          </thead>

					<tbody>
						<tr>
              <td>300-001-0001</td><td>36</td><td>-4</td><td>???</td><td>Gs. 100.000</td><td><a href="/lotes/300-001-0001" class="btn btn-default">Detalles</a> <a href="/lotes/300-001-0001/add-to-cart" class="btn btn-primary">Pagar online</a></td>
						</tr>
					</tbody>

				</table>

			</div>
		</div>

	</div>

@stop
