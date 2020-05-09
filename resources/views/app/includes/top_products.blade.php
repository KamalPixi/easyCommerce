@if(isset($top_products))
<!-- TopTen Products owl Slider -->
<section class="topTenProduct pt-5">
<div class="container">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col">
            <h3 class="sectionHeading font-size-lg text-uppercase">Top Sold Products</h3>
        </div>
        <div class="col-auto">
            <div class="owl-nav">
                <div class="btn trendingSliderNext p-0"><i class='fas fa-chevron-left'></i></div>
                <div class="btn trendingSliderPrev p-0"><i class='fas fa-chevron-right'></i></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="trendingSlider owl-carousel owl-theme">

      @foreach($top_products as $top_product)
      <div class="card product-card">
          <a class="card-img-top d-block overflow-hidden" href="@if(Route::has('product')) {{ route('product', [$top_product->slug]) }} @endif"><img src="{{ asset('storage/product_thumbs/'.$top_product->thumbnail->thumbnail) }}" alt="{{ $top_product->title ?? '' }}"></a>
          <div class="card-body py-2"><a class="product-meta d-block font-size-xs pb-1" href="@if(Route::has('product')) {{ route('product', [$top_product->slug]) }} @endif">{{ $top_product->category->name ?? '' }}</a>
              <h3 class="product-title font-size-sm"><a href="@if(Route::has('product')) {{ route('product', [$top_product->slug]) }} @endif">{{ $top_product->title ?? '' }}</a></h3>
              <div class="d-flex justify-content-between">
                  <div class="product-price"><span class="text-accent">&#2547; {{ $top_product->priceExploder()[0] ?? '' }}.<small>{{ $top_product->priceExploder()[1] ?? '' }}.</small></span></div>
                  <div class="star-rating">
                    @php $run = 5; @endphp
                    @for($i=0; $i < (int)$top_product->rating(); $i++)
                      <i class="fas fa-star sr-star active"></i>
                      @php $run--; @endphp
                    @endfor

                    @for($i=0; $i < $run; $i++)
                      <i class="fas fa-star sr-star"></i>
                    @endfor
                  </div>
              </div>
          </div>
          <div class="card-body card-body-hidden">
              <button class="btn btn-primary btn-sm btn-block mb-2" type="button" data-toggle="toast" data-target="#cart-toast" onclick="addToCartSingle({{ $top_product->id ?? '' }})"><i class="fas fa-cart-plus mr-1"></i>Add to Cart</button>
          </div>
      </div>
      @endforeach

    </div>
</div>
</section>
@endif
