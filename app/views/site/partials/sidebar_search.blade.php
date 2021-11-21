@section('styles')
@parent
<link rel="stylesheet" href="{{asset('vendor/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css')}}">
<style>
.slider.slider-horizontal {
  width:100%;
}
.slider .slider-handle {
  background-color: #587332;
  background-image: -webkit-linear-gradient(top, #587332 0, #587332 100%);
  background-image: -o-linear-gradient(top, #587332 0, #587332 100%);
  background-image: linear-gradient(to bottom, #587332 0, #587332 100%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff149bdf', endColorstr='#ff0480be', GradientType=0);
  filter: none;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  border: 0 solid transparent;
}
</style>
@stop

@section('scripts')
@parent
<script src="{{asset('vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('vendor/accountingjs/accounting.min.js')}}"></script>
<script>

var search_threshold = {{ json_encode($search_threshold) }};

function update_search_threshold(){

  $("#ex2").slider('destroy');

  var property_type,operation_type,currency;
  property_type = $('select[name=property_type]').val();
  operation_type = $('select[name=operation_type]').val();
  currency = $('select[name=currency]').val();
  if(currency=='PYG'){

    currency_symbol = 'Gs. ';
    currency_decimal = ',';
    currency_thousand = '.';

  }else if(currency=='USD'){

    currency_symbol = 'U$D ';
    currency_decimal = '.';
    currency_thousand = ',';

  }else if(currency=='any'){

    currency_symbol = '';
    currency_decimal = '.';
    currency_thousand = ',';

  }

  if(currency=='any'){
    var min = 'min_' + property_type + '_' + operation_type;
    var max = 'max_' + property_type + '_' + operation_type;
  }else{
    var min = 'min_' + property_type + '_' + operation_type + '_' + currency;
    var max = 'max_' + property_type + '_' + operation_type + '_' + currency;
  }


  $("#ex2").slider({
    min:parseInt(search_threshold[min]),
    max:parseInt(search_threshold[max]),
    value:[parseInt(search_threshold[min]),parseInt(search_threshold[max])],
    handle:'round',
    tooltip:'hide',
    formatter:function(value){
      if($.isArray(value)){

        // Available fields in options object, matching `settings.currency`:
        var options = {
          symbol : currency_symbol,
          decimal : ",",
          thousand: ".",
          precision : 0,
          format: "%s%v"
        };

        var min_price_text = accounting.formatMoney(value[0], options);
        var max_price_text = accounting.formatMoney(value[1], options);
        $('#min_price_text').text(min_price_text);
        $('#max_price_text').text(max_price_text);
      }
      return value;
    }
  });  

}

$(function(){

  $("#ex2").slider({
    min:500000,
    max:100000000,
    step:500000,
    value:[500000,100000000],
    handle:'round'
  });

  update_search_threshold();

  $('.search_control').on('change',function(e){
    update_search_threshold();
  });

  $('select[name="currency"]').on('change',function(){

    var currency = $(this).val();
    if(currency == 'any'){
      $('.price_range_controls > div').hide();
    }else{
      $('.price_range_controls > div').show();
    }

  });

});
</script>
@stop

<div class="row">



	<div class="col-xs-12">
			<div class="title marron">
				<h4>Buscador de inmuebles</h4>
			</div>

	</div>

	<div class="col-xs-12">

		{{ Form::open(['url' => '/property/search','method' => 'GET'])}}

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3">

				{{Form::select('property_type', ['any' => 'Cualquier tipo de inmueble'] + $property_types, Input::old('property_type', Input::get('property_type')),['class' => 'search_control'])}}
				
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3">

				{{Form::select('operation_type', $operation_types, Input::old('operation_type', Input::get('operation_type')),['class' => 'search_control'])}}
				
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3">

				{{Form::select('currency', ['any' => 'Todas las monedas'] + $currencies, Input::old('currency', Input::get('currency')),['class' => 'search_control'])}}
				
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3">

				{{ $cities_dropdown }}
				
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3 price_range_controls">

				<div><h5>Rango de precios:</h5></div>
				
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 price_range_controls">

				<div><input id="ex2" name="price_range" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/><div class="price_range_text_container"> <span id="min_price_text" class="pull-left">500.000</span>  <span id="max_price_text" class="pull-right">1.000.000.000</span></div></div>
				
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-3 text-right">

				<button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
				
			</div>

		</div>

		{{ Form::close() }}		

	</div>
</div>