@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Deseo vender ::
@parent
@stop

@section('scripts')

@parent


<script>
$(function(){



      $('#country_id').on('change',function(){

        $this = $(this);
        $('#country_name').val($('option:selected',this).text());
        var country_id = $this.val();
        $.ajax({
          url:'/states',
          data:{
            'country_id':country_id
          },
          success:function(data){

            $('#state_id').empty();
            $(data.states).each(function(k,v){

              $('<option>').val(v.id).text(v.name).appendTo('#state_id');

            });

            $('#state_id').change();
            $('#state_id').selectBox('refresh');
          }
        });

      });

      $('#state_id').on('change',function(){

        $this = $(this);
        $('#state_name').val($('option:selected',this).text());
        var state_id = $this.val();
        $.ajax({
          url:'/cities',
          data:{
            'state_id':state_id
          },
          success:function(data){

            $('#city_id').empty();
            $(data.cities).each(function(k,v){

              if(v.features == 'PPLA' || v.features == 'PPLC'){
                $('<option>').attr('selected','selected').val(v.id).text(v.name).appendTo('#city_id');
              }else{
                $('<option>').val(v.id).text(v.name).appendTo('#city_id');
              }

            });

            $('#city_id').change();
            $('#city_id').selectBox('refresh');
          }
        });

      });

      $('#city_id').on('change',function(){

        $this = $(this);
        $('#city_name').val($('option:selected',this).text());

      });

      $.ajax({
        url:'/states',
        data:{
          'country_id':187
        },
        success:function(data){

          $('#state_id').empty();
          $(data.states).each(function(k,v){

            $('<option>').val(v.id).text(v.name).appendTo('#state_id');

          });

          $('#state_id').change();
          $('#state_id').selectBox('refresh');
        }
      });

});
</script>

@stop

{{-- Content --}}
@section('content')

  <div class="container">
    <!--
    <div class="row">

      <div class="col-sm-12 bg_marron">

        <h1>Deseo vender</h1>

      </div>

    </div>
    -->

    <div class="row">

      <div class="col-md-8">

        <h3>Complete el formulario y nos comunicaremos con usted</h3>

        <p>Con mucho gusto le asesoraremos en la venta y tasación de su inmueble.</p>

        <form role="form" action="/contact" method="POST" class="form-horizontal">

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Tipo de inmueble</label>
            <div class="col-sm-9">
              <select value="-" name="property_type">
                <option value="Una casa">Una casa</option>
                <option value="Un terreno">Un terreno</option>
                <option value="Un duplex">Un duplex</option>
                <option value="Un campo">Un campo</option>
                <option value="Otro tipo de inmueble">Otro tipo de inmueble</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="country_id" class="col-sm-3 control-label">Pais</label>
            <div class="col-sm-9">
            {{ Form::select('country_id',isset($countries) ? $countries : [],Input::old('country_id', 187),['id' => 'country_id'])}}
            <input type="hidden" name="country_name" id="country_name" />
            </div>
          </div>

          <div class="form-group">
            <label for="state_id" class="col-sm-3 control-label">Departamento</label>
            <div class="col-sm-9">
            {{ Form::select('state_id',isset($states) ? $states : [],Input::old('state_id', null),['id' => 'state_id'])}}
            <input type="hidden" name="state_name" id="state_name" />
            </div>
          </div>

          <div class="form-group">
            <label for="city_id" class="col-sm-3 control-label">Ciudad</label>
            <div class="col-sm-9">
            {{ Form::select('city_id',isset($cities) ? $cities : [],Input::old('city_id', null),['id' => 'city_id'])}}
            <input type="hidden" name="city_name" id="city_name" />
            </div>
          </div>

          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="sell_name" placeholder="Ingrese su nombre" name="name">
            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
            </div>
          </div>

          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Apellido</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="sell_lastname" placeholder="Ingrese su apellido" name="lastname">
            {{ $errors->first('lastname', '<span class="help-inline">:message</span>') }}
            </div>
          </div>

          <div class="form-group">
            <label for="phone" class="col-sm-3 control-label">Teléfono</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="sell_phone" placeholder="Ingrese un número de teléfono para contactarlo" name="phone">
            {{ $errors->first('phone', '<span class="help-inline">:message</span>') }}
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">E-mail</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="sell_email" placeholder="Ingrese su e-mail si prefiere comunicarse por este medio" name="email">
            {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
            </div>
          </div>

          <div class="form-group">
            <label for="message" class="col-sm-3 control-label">Mensaje</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="sell_message" name="message" placeholder="Mensaje" rows="6"></textarea>
            </div>
          </div>
          <div class="form-group">
          <div class="col-sm-9 col-sm-offset-3">
            {{ Form::captcha() }}
          </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
            </div>
          </div>

        </form>

      </div>

      <div class="col-md-4 bg_gris">

        <div class="sidebar">

      @include('site/partials/sidebar_search')

        </div>
      </div>

    </div>

  </div>

@stop
