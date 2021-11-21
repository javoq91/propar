@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Lote {{{ $lote['codigo_lote'] }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">

		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Lote {{ $lote['codigo_lote'] }}</h1>

			</div>

		</div>

		<div class="row">

			<div class="col-md-6">

				<table class="table">

					<tbody>
						<tr>
							<th>Cuotas atrasadas</th><td>{{ $lote['cuotas_atrasadas']}}</td>
						</tr>
						<tr>
							<th>Fecha vencimiento</th><td>{{ $lote['fecha_vencimiento']}}</td>
						</tr>
						<tr>
							<th>Cuotas pagadas</th><td>{{ $lote['cuotas_pagadas']}}</td>
						</tr>
						<tr>
							<th>Total Cuotas</th><td>{{ $lote['total_cuotas']}}</td>
						</tr>
						<tr>
							<th>N&ordm; próxima cuota</th><td>{{ $lote['numero_cuota_a_pagar']}}</td>
						</tr>
					</tbody>

				</table>

			</div>

			<div class="col-md-6 bg_gris">

					<table class="table">

						<tbody>
							<tr>
								<th>Cuota N&ordm;</th><td>{{ $lote['detalle_cuotas'][0]['numero_cuota']}}</td>
							</tr>
							<tr>
								<th>Vencimiento</th><td>{{ $lote['detalle_cuotas'][0]['vencimiento']}}</td>
							</tr>
							<tr>
								<th>Monto</th><td>{{ Currency::format($lote['detalle_cuotas'][0]['monto_cuota'], 'PYG')}}</td>
							</tr>
							<tr>
								<th>Fecha Pago</th><td>{{ $lote['detalle_cuotas'][0]['fecha_pago']}}</td>
							</tr>
							<tr>
								<th>Interés</th><td>{{ Currency::format($lote['detalle_cuotas'][0]['interes'], 'PYG')}}</td>
							</tr>
							<tr>
								<th>Cantidad de cuotas</th><td>{{ $lote['detalle_cuotas'][0]['cantidad_sumatoria_cuotas']}}</td>
							</tr>
							<tr>
								<th>Monto sumatoria cuotas</th><td>{{ Currency::format($lote['detalle_cuotas'][0]['monto_sumatoria_cuotas'], 'PYG')}}</td>
							</tr>
							<tr>
								<th>Interés total</th><td>{{ Currency::format($lote['detalle_cuotas'][0]['interes_total'], 'PYG')}}</td>
							</tr>
							<tr>
								<th>Total a pagar</th><td><strong>{{ Currency::format($lote['detalle_cuotas'][0]['monto_total_a_pagar'], 'PYG')}}</strong></td>
							</tr>
						</tbody>

					</table>

			</div>

		</div>

	</div>

@stop
