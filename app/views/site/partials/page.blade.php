@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
{{{ $page->title }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">
		<!--
		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>{{ $page->title }}</h1>

			</div>

		</div>
		-->
		<div class="row">

			<div class="col-md-8">

				{{ $page->body }}

			</div>

			<div class="col-md-4 bg_gris">

				<div class="sidebar">

			@include('site/partials/sidebar_search')

				</div>
			</div>

		</div>

	</div>
		
@stop
