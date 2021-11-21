@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Propiedades ::
@parent
@stop

{{-- Metadata --}}


@section('styles')
@parent
@stop
@section('scripts')
@parent
<script>
$(function(){


});
</script>
@stop

{{-- Content --}}
@section('content')



	<div class="container">

		<div class="row">

			@include('site/partials/search')

		</div>

		<div class="row" id="listing">

		@foreach($properties as $property)

			<div class="col-sm-6 col-md-3">

				<div class="property_listing_wrap {{ $property->property_type }}">
					<a href="/property/{{ $property->id }}">
						@if($property->sold_out)
						<div class="ribbon-wrapper"><div class="ribbon">@if($property->property_type == 'lots') SOLO RECUPERADOS @else VENDIDO @endif</div></div>
						@endif
						<div class="property_image">
							<img src="/{{ (isset( $property->folder->files[0] ) ? Config::get('sauna::frontend_route') . '/fit/720/480/' . $property->folder->files[0]->filename : 'img/properties/no-image.png') }}"  alt="" class="img-responsive" />
							<div class="property_type"> {{ Lang::get('properties::default.property_types.' .$property->property_type) }}</div>
						</div>
					</a>
					<div class="property_listing_text_padding">

						<h4><a href="/property/{{ $property->id }}">@if($property->property_type == 'lots') Fracción: @endif {{ $property->title }}</a></h4>
						<div class="intro">
							{{ $property->intro }}
						</div>
						<hr />
						<h4 class="price text-center">
						@foreach($property->property_operations as $property_operation)
						<p>
						  @if($property->property_type == "lots" && $property_operation->operation_type == "sell") Cuotas desde @else {{ Lang::get('properties::default.operation_types.' . $property_operation->operation_type) }} @endif {{ Lang::get('properties::default.currency_symbols.' .$property_operation->currency) }} {{ number_format($property_operation->price,0,',','.') }}
						</p>
						@endforeach
						</h4>

					</div>

					<div class="container-fluid property_details">

						<div class="col-xs-12 text-center">

							<div class="padding">
							COD: {{ $property->id }}
							</div>

						</div>


					</div>
					
				</div>

			</div>

		@endforeach

		</div>

		<div class="text-center">
		{{ $properties->appends(Input::all())->links() }}
		</div>

	</div><!-- /.container -->
		
@stop
