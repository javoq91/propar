<!DOCTYPE html>
<html lang="en">
  <head>
    @include('site/partials/metadata')
  </head>


  <body>

    @include('site/partials/navbar')

    <!-- Notifications -->
    @include('site/notifications')
    <!-- ./ notifications -->

    <!-- Content -->
        @yield('content')
    <!-- ./ content -->



    @include('site/partials/footer')


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- jQuery -->
    <script src="{{asset('packages/emilio-bravo/platform/vendor/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('packages/emilio-bravo/platform/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('packages/emilio-bravo/platform/vendor/is-loading/jquery.isloading.min.js')}}"></script>
    <script src="{{asset('vendor/holderjs/holder.js')}}"></script>
    <script src="{{asset('vendor/swiper/dist/js/swiper.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-selectBox/jquery.selectBox.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>

    $(function(){
        
        // default
        $('select').selectBox({
            mobile:true
        });
        
    });

    </script>

    @yield('scripts')

    <!-- Start Google Analytics Tracker -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '{{ Settings::get('google_analytics_tracking_id') }}', 'auto');
      ga('send', 'pageview');

    </script>     
    <!-- End Google Analytics Tracker -->     
  </body>
</html>