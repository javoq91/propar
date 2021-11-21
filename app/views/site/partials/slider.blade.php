<!-- Swiper -->
<div id="slider_home" class="swiper-container">
    <div class="swiper-wrapper">
    @foreach(Sliders::slides('slider-home') as $slide)

        <div class="swiper-slide"><a href="{{ $slide->title }}"><img src="/{{ Config::get('sauna::frontend_route') }}/fit/1140/424/{{ $slide->filename }}" class="img-responsive"></a></div>
    
    @endforeach
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <!--
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    -->
</div>

@section('scripts')

@parent
<script>

$(function(){

  swiper = new Swiper('.swiper-container',{
    pagination: '.swiper-pagination',
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    slidesPerView: 1,
    paginationClickable: true,
    spaceBetween: 30,
    loop: true,
    autoplay: 5000,
  });

  $('.swiper-container').hover(function(){
    swiper.stopAutoplay();
  },function(){
    swiper.startAutoplay();
  });

});

</script>
@stop

@section('styles')
@parent
<style>
.swiper-container{width:100%;height:100%;}.swiper-slide{text-align:center;font-size:18px;background:#fff;display:-webkit-box;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;align-items:center;}

  .swiper-button-prev{
    background-image:url("data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 27 44'><path d='M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z' fill='%23644e1c'/></svg>");
    width: 60px;
    height: 55px;
    left:0px;
  }

  .swiper-button-next{
    background-image: url("data:image/svg+xml;charset=utf-8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 27 44'><path d='M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z' fill='%23644e1c'/></svg>");
    width: 60px;
    height: 55px;
    right:0px;
  }

  .swiper-pagination-bullet-active{
    background-color:#644e1c;
  }


</style>
@stop