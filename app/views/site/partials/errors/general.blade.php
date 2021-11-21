@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Error ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">

		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Error</h1>

			</div>

		</div>

		<div class="row">

			<div class="col-md-8">
				<br  />
					<br  />
						<br  />
				<p class="text-center">
					<i class="fa fa-exclamation-triangle fa-5x" aria-hidden="true"></i>
					<br />
					Ha ocurrido un errror.

				</p>

			</div>

			<div class="col-md-4 bg_gris">

				<div class="sidebar">

			@include('site/partials/sidebar_search')

				</div>
			</div>

		</div>

	</div>

@stop
