@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Mi Cuenta ::
@parent
@stop

{{-- Content --}}
@section('content')

	<div class="container">

		<div class="row">

			<div class="col-sm-12 bg_marron">

				<h1>Mi cuenta</h1>

			</div>

		</div>

    <div class="row">

      <div class="col-sm-12 col-md-6">

        <h2>Olvidé mi contraseña</h2>

        <p>Ingrese la cuenta de correo con la que se registró y le enviaremos un e-mail de recuperación.</p>

        <form method="POST" action="{{ URL::to('/users/forgot_password') }}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

            <div class="form-group">
                <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
                <div class="input-append input-group">
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="{{{ Lang::get('confide::confide.forgot.submit') }}}">
                    </span>
                </div>
            </div>

            @if (Session::get('error'))
                <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
            @endif

            @if (Session::get('notice'))
                <div class="alert">{{{ Session::get('notice') }}}</div>
            @endif
        </form>

      </div>

    </div>

	</div>


@stop
