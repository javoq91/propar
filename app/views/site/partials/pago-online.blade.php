@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Pago Online ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">
		<!--
		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Pago Online</h1>

			</div>

		</div>
		-->
		<div class="row">

			<div class="col-md-8">

        <h3>Complete el formulario con sus datos.</h3>

        <p>Podrá realizar el pago utilizando su tarjeta de crédito o débito.</p>

          <div class="form-group">
            <label for="numero_de_lote" class="col-sm-3 control-label">Número de Lote</label>
            <div class="col-sm-9">
              <input type="text" class="form-control input-lg" id="numero_de_lote" placeholder="Ingrese su número de lote" name="numero_de_lote">
            {{ $errors->first('numero_de_lote', '<span class="help-inline">:message</span>') }}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button id="send_lote" type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
          </div>

			</div>

			<div class="col-md-4 bg_gris">

				<div class="sidebar">

			@include('site/partials/sidebar_search')

				</div>
			</div>

		</div>

	</div>

@stop

@section('scripts')
<script type="text/javascript" src="/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
  $('#numero_de_lote').mask('000/000/0000', {placeholder: "___/___/____"});
	$('#send_lote').on('click',function(){
		var numero_de_lote = $('#numero_de_lote').val();
		var numero_de_lote_dashed = numero_de_lote.replace(/\//g, "-");
		var add_to_cart_url = '/lotes/' + numero_de_lote_dashed + '/add-to-cart';
		window.location.replace(add_to_cart_url);
	});
});
</script>
@endsection
