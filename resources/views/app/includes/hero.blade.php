<!--Main Hero Section-->
<section>
  <div class="container my-2">
    <div class="row">


      <div id="carouselExampleIndicators" class="carousel slide w-100" data-ride="carousel">
          <ol class="carousel-indicators">
              @foreach($sliders as $k => $slider)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$k}}" class="@if($k == 0) active @endif"></li>
              @endforeach
          </ol>
          <div class="carousel-inner">
            @if(isset($sliders))
            @foreach($sliders as $k => $slider)
              <div class="carousel-item @if($k == 0) active @endif">

                @if(strlen($slider->video) > 1)
                  <a href="#" class="js-video-button w-100 slider_video position-relative" data-channel="video" data-video-url="{{request()->getHttpHost()}}/{{$slider->video ?? ''}}">
                    <i class="far fa-play-circle"></i>
                    <img data-src="{{ asset('storage/product_images/'.$slider->image) }}" alt="img" class="lozad w-100">
                  </a>
                @else
                  <img data-src="{{ asset('storage/product_images/'.$slider->image) }}" alt="img" class="lozad w-100">
                @endif

                @if($slider->title)
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $slider->title ?? '' }}</h5>
                    <p>{{ $slider->subtitle ?? '' }}</p>
                </div>
                @endif
              </div>
              @endforeach
              @endif

          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
          </a>
      </div>

  </div>
</div>
</section>
