@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
@parent
@stop

{{-- Metadata --}}
@section('styles')
@parent
@stop



{{-- Content --}}
@section('content')
<div id="content">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

@include('site/partials/slider')
			</div>

		</div>

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
						@if($property->property_type == "lots")
						Cuotas desde 
						@endif {{ Lang::get('properties::default.currency_symbols.' .$property->property_operations[0]->currency) }} {{ number_format($property->property_operations[0]->price,0,',','.') }}
						</h4>

					</div>

					<div class="container-fluid property_details">

						<div class="row no-gutter">

						<div class="col-xs-12 text-center">

						<div class="padding">
						COD: {{ $property->id }}
						</div>

						</div>

						</div>

					</div>
					
				</div>

			</div>

		@endforeach

		</div>

	</div><!-- /.container -->

</div> <!-- /#content -->
@stop

{{-- Scripts --}}
@section('scripts')
@parent
<script>
$(function(){


});
</script>
@stop