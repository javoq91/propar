@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')
Contacto ::
@parent
@stop

{{-- Content --}}
@section('content')

  <div class="container">
    <!--
    <div class="row">

      <div class="col-sm-12 bg_marron">

        <h1>Contacto</h1>

      </div>

    </div>
    -->
    <div class="row">

      <div class="col-md-4">

        <h3>Comuníquese con nosotros</h3>

        <form role="form" action="/contact" method="POST">

          <div class="form-group">
            <input type="text" class="form-control" id="contact_name" placeholder="Ingrese su nombre" name="name">
            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="contact_lastname" placeholder="Ingrese su apellido" name="lastname">
            {{ $errors->first('lastname', '<span class="help-inline">:message</span>') }}
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="contact_email" placeholder="Ingrese su e-mail" name="email">
            {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="contact_phone" placeholder="Ingrese su número de teléfono" name="phone">
            {{ $errors->first('phone', '<span class="help-inline">:message</span>') }}
          </div>
          <div class="form-group">
            <textarea class="form-control" id="contact_message" name="message" placeholder="Mensaje" rows="6"></textarea>
            {{ $errors->first('message', '<span class="help-inline">:message</span>') }}
          </div>
          <div class="form-group">
            {{ Form::captcha() }}
          </div>

          <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
        </form>

      </div>

      <div class="col-md-4">

      </div>

      <div class="col-md-4 bg_gris">

        <div class="sidebar">

          <div class="row">

            <div class="col-xs-12">

              <select>

                <optgroup label="Tipo de operación">

                  <option value="0">Compra</option>
                  <option value="0">Venta</option>
                  <option value="0">Alquiler</option>

                </optgroup>

              </select>

            </div>

            <div class="col-xs-12">

              <select>

                <optgroup label="Seleccione el tipo de inmueble">

                  <option value="0">Terreno / Lote</option>
                  <option value="0">Casa</option>
                  <option value="0">Departamento</option>

                </optgroup>

              </select>

            </div>

            <div class="col-xs-12">

              <select>

                <optgroup label="Ciudad">

                  <option value="0">Asunción</option>
                  <option value="0">Encarnación</option>
                  <option value="0">Ciudad del Este</option>
                  <option value="0">Paraguarí</option>
                  <option value="0">San Bernardino</option>
                  <option value="0">Caacupe</option>
                  <option value="0">Kurusú de Hierro</option>

                </optgroup>

              </select>

            </div>

            <div class="col-xs-12">

              <button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

            </div>

          </div>

        </div>
      </div>

    </div>

  </div>

@stop
