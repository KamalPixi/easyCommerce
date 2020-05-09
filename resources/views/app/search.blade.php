@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')

  <!-- contents -->

  @if(isset($products))
  <section class="container pt-md-3 pb-5 mb-md-3">
  <h4 class="">Search Result for '{{ $keyword ?? '' }}'</h4>
  <div class="row pt-4 mx-n2">

      @foreach($products as $product)
      <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
          <div class="card product-card">
              <span class="badge badge-danger badge-shadow">Sale</span>
              <a class="card-img-top d-block overflow-hidden" href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif"><img src="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}" alt="Product"></a>
              <div class="card-body py-2"><a class="product-meta d-block font-size-xs pb-1" href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif">{{ $product->category->name ?? '' }}</a>
                  <h3 class="product-title font-size-sm"><a href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif">{{ $product->title ?? '' }}</a></h3>
                  <div class="d-flex justify-content-between">
                      <div class="product-price"><span class="text-accent">&#2547; {{ $product->priceExploder()[0] ?? '' }}. <small>{{ $product->priceExploder()[1] ?? '' }}</small></span></div>
                      <div class="star-rating"><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star"></i>
                      </div>
                  </div>
              </div>
              <div class="card-body card-body-hidden">
                  <button class="btn btn-primary btn-sm btn-block mb-2" type="button" data-toggle="toast" data-target="#cart-toast" onclick="addToCartSingle({{ $product->id ?? '' }})"><i class="fas fa-cart-plus mr-1"></i>Add to Cart</button>
              </div>
          </div>
          <hr class="d-sm-none">
      </div>
      @endforeach

      <hr class="d-sm-none">
  </div>
  </section>
  @endif


  <!-- ends contents -->

  <!--include footer-->
  @include('app.includes.footer')
@endsection
