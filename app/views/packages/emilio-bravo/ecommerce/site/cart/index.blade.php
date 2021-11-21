@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Pago Online ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">

		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Pago Online</h1>

			</div>

		</div>

    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="hairline">
          <h4>Detalles</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Item</th><th>Descripción</th><th>Monto</th><th>Cantidad</th><th>Subtotal</th>
                </tr>
              </thead>
              <tbody>

                @foreach(Cart::content() as $item)
                <tr>
                  <th>{{ $item->id }}</th><td>{{ $item->name }}</td><td>{{Currency::format($item->price, 'PYG') }}</td><td>{{ $item->qty }}</td><td>{{Currency::format($item->price * $item->qty, 'PYG') }}</td>
                </tr>

                @endforeach

              </tbody>
              <tfoot>
                <tr class="info">
                  <th colspan="4">
                    Total:
                  </th>
                  <td>
                    {{Currency::format(Cart::total(), 'PYG') }}
                  </td>

                </tr>
              </tfoot>
            </table>

          </div>
          <p class="text-right"><a href="/pay" class="btn btn-lg btn-primary" >Pagar con Tarjeta de Crédito o Débito</a></p>

        </div>
      </div>

    </div>

	</div>

@stop
