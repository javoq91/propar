    <div class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            <img height="50px" src="{{ asset('img/logo-sin-borde.png')}}" />
          </a>
        </div>
      </div>
      <div class="navbar-collapse collapse">

      <div id="navbar-wrap">

      <div id="navbar-border">

        <div class="container">

          <ul class="nav navbar-nav">
            <li {{ (Request::is('/') ? 'class="active"' : '') }}><a href="/">Inicio</a></li>
            <li {{ (Request::is('nosotros') ? 'class="active"' : '') }}><a href="/nosotros">Nosotros</a></li>

            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Deseo comprar<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="/property/search?property_type=any_lot_lots&operation_type=sell&currency=any&city_id=any&price_range=NaN%2CNaN">Un terreno</a>
                </li>
                <li>
                  <a href="/property/search?property_type=farm&operation_type=sell&currency=any&city_id=any&price_range=NaN%2CNaN">Un campo / estancia</a>
                </li>
                <li>
                  <a href="/property/search?property_type=house&operation_type=sell&currency=any&city_id=any&price_range=NaN%2CNaN">Una casa</a>
                </li>
                <li>
                  <a href="/property/search?property_type=duplex&operation_type=sell&currency=any&city_id=any&price_range=NaN%2CNaN">Un duplex</a>
                </li>
                <li>
                  <a href="/property/search?property_type=apartment&operation_type=sell&currency=any&city_id=any&price_range=NaN%2CNaN">Un departamento</a>
                </li>
              </ul>
            </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Deseo alquilar<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="/property/search?property_type=house&operation_type=rent&currency=any&city_id=any&price_range=NaN%2CNaN">Una casa</a>
                </li>
                <li>
                  <a href="/property/search?property_type=duplex&operation_type=rent&currency=any&city_id=any&price_range=NaN%2CNaN">Un duplex</a>
                </li>
                <li>
                  <a href="/property/search?property_type=apartment&operation_type=rent&currency=any&city_id=any&price_range=NaN%2CNaN">Un departamento</a>
                </li>
              </ul>
            </li>

            <li><a href="/deseo-vender">Deseo vender</a></li>
            <li {{ (Request::is('preguntas') ? 'class="active"' : '') }}><a href="/preguntas">Preguntas</a></li>
            <li {{ (Request::is('contacto') ? 'class="active"' : '') }}><a href="/contacto">Contacto</a></li>
            <li {{ (Request::is('pago-online') ? 'class="active"' : '') }}><a href="/pago-online">Pago Online</a></li>
            @if(Auth::user())
            <li><a href="/users/logout"><i class="fa fa-user"></i>{{ (isset($user->name))?:'' }} {{ (isset($user->lastname))?:'' }}, Salir <i class="fa fa-sign-out"></i></a></li>
            @else
            <li><a href="/users/login">Ingresar <i class="fa fa-sign-in"></i></a></li>
            @endif
          </ul>

          <ul class="nav navbar-nav navbar-right" id="navbar-social-media">
            <li><a href="https://www.facebook.com/proprasrl" target="_blank">
              <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
              </span>
            </a> <a href="https://www.instagram.com/proparsrl" target="_blank">
              <span class="fa-stack fa-lg">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
              </span>
            </a></li>
          </ul>

        </div>

      </div>

      </div>


     </div><!--/.navbar-collapse -->
    </div>
