@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{ $property->title }} ::
@parent
@stop


{{-- Metadata --}}


@section('styles')
@parent

<link rel="stylesheet" type="text/css" href="{{ asset('packages/emilio-bravo/properties/vendor/leaflet/dist/leaflet.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/Leaflet.fullscreen/dist/leaflet.fullscreen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('packages/emilio-bravo/properties/vendor/Leaflet.awesome-markers/dist/leaflet.awesome-markers.css') }}">

<style>
#map{
	height: 300px;
}
</style>
@stop

@section('scripts')
@parent
<script src="{{asset('vendor/carouFredSel/jquery.carouFredSel-6.2.1-packed.js')}}"></script>
<script src="{{asset('vendor/carouFredSel/helper-plugins/jquery.mousewheel.min.js')}}"></script>
<script src="{{asset('vendor/carouFredSel/helper-plugins/jquery.transit.min.js')}}"></script>
<script src="{{asset('vendor/carouFredSel/helper-plugins/jquery.ba-throttle-debounce.min.js')}}"></script>
<script src="{{ asset('packages/emilio-bravo/properties/vendor/leaflet/dist/leaflet.js') }}"></script>
<script src="{{ asset('vendor/Leaflet.fullscreen/dist/Leaflet.fullscreen.min.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>	
<script src="{{ asset('packages/emilio-bravo/properties/vendor/leaflet-plugins/layer/tile/Google.js') }}"></script>
<script src="{{ asset('packages/emilio-bravo/properties/vendor/Leaflet.awesome-markers/dist/leaflet.awesome-markers.min.js') }}"></script>
<script>
$(function(){

			// Creates a red marker with the coffee icon
			var redMarker = L.AwesomeMarkers.icon({
				icon: 'home',
				prefix: 'fa',
				markerColor: 'darkgreen'
			});

			var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				ggl_roadmap = new L.Google('ROADMAP'),
				ggl_terrain = new L.Google('TERRAIN'),
				ggl_satellite = new L.Google('SATELLITE'),
				ggl_hybrid = new L.Google('HYBRID'),
				osmAttrib = '',
				osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
				map = new L.Map('map', {fullscreenControl: true, layers: [ggl_hybrid,ggl_terrain], center: new L.LatLng({{ $property->lat ?: "-25.2822" }}, {{ $property->lng ?: "-57.6351" }}), zoom: 15 });
				map.addControl(new L.Control.Layers( {'Google Hybrid':ggl_hybrid,'Google Terrain':ggl_terrain}, {}));

			var property_location = L.marker([{{ $property->lat ?: "-25.2822" }}, {{ $property->lng ?: "-57.6351" }}],{icon: redMarker}).bindPopup('LAT: {{ $property->lat ?: "-25.2822" }} LNG: {{ $property->lng ?: "-57.6351" }}');
			var drawnItems = new L.FeatureGroup([property_location]);

			map.addLayer(drawnItems);

	//	Scrolled by user interaction
	$('#foo2').carouFredSel({
		auto: {
			pauseOnHover: 'resume',
			onAfter:function(data){
				console.log(data.items.visible[0]);

    var $str1 = $(data.items.visible[0]);//this turns your string into real html 


    var src = $str1.find('img').eq(0).attr('src');
		src = src.replace( "200/200", "750/500");
		$('#slider_img').attr('src',src);
			}
		},
		scroll: 1,
		prev: '#prev2',
		next: '#next2',
		pagination: "#pager",
		mousewheel: true,
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});

	$('.list_carousel li img').on('click',function(){
		var src = $(this).attr('src');
		src = src.replace( "200/200", "750/500");
		$('#slider_img').attr('src',src);
		console.log($(this).attr('src'));
	});

	$('#btn_map_fullscreen_toggle').on('click',function(){
		map.toggleFullscreen();
	});

});
</script>
@stop

{{-- Content --}}
@section('content')

	<div class="container property">

		<div class="row">

			<div class="col-md-8">

				<div class="row">

					<div class="col-sm-12">

						<div class="title marron">
							<h4>@if($property->property_type == 'lots') Fracción: @endif {{ $property->title }}</h4>
						</div>

						<div id="slider_wrapper">
							@if($property->sold_out)
							<div class="ribbon-wrapper"><div class="ribbon">@if($property->property_type == 'lots') SOLO RECUPERADOS @else VENDIDO @endif</div></div>
							@endif
							<div id="slider">
								<img id="slider_img" src="/{{ (isset( $property->folder->files[0] ) ? Config::get('sauna::frontend_route') . '/fit/750/500/' . $property->folder->files[0]->filename : 'img/properties/no-image.png') }}" class="img-responsive" />
							</div>
						</div>

						<div class="list_carousel responsive">
							<ul id="foo2">
								@foreach ($property->folder->files as $file)
								<li>
									<img src="/uploads/fit/200/200/{{ $file->filename}}" alt="" class="img-responsive" data-thumb="/uploads/fit/200/200/{{ $file->filename}}" />
								</li>
								@endforeach
							</ul>
							<div class="clearfix"></div>
							<div id="timer1" class="timer"></div>
							<a id="prev2" class="prev" href="#">&lt;</a>
							<a id="next2" class="next" href="#">&gt;</a>
							<div id="pager2" class="pager"></div>
						</div>

					</div>

				</div>

				<div class="row">

					<div class="col-sm-6">

						<div class="title anaranjado">
							<h4>Descripción</h4>
						</div>

						{{ $property->description }}

						<hr />
						@foreach($property->property_operations as $property_operation)
						<p>
						 @if($property->property_type == "lots" && $property_operation->operation_type == "sell") <b>Cuotas desde</b> @else <b>Precio {{ Lang::get('properties::default.operation_types.' . $property_operation->operation_type) }}</b> @endif {{ Lang::get('properties::default.currency_symbols.' .$property_operation->currency) }} {{ number_format($property_operation->price,0,',','.') }}
						</p>
						@endforeach

					</div>

					<div class="col-sm-6">

						<div class="title verde">
							<h4>Ubicación</h4>
						</div>
 
						<div id="map">
						</div>

						<button class="btn btn-lg btn-primary" id="btn_map_fullscreen_toggle">Agrandar mapa</button>

					</div>

				</div>

			</div>

			<div class="col-md-4">

				<div class="sidebar bg_gris">

			@include('site/partials/sidebar_search')

				</div>
			</div>

		</div>

	</div>
		
@stop
