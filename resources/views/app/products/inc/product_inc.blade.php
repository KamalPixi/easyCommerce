<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between align-items-center py-2 py-lg-3">
      <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
            <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="fas fa-home"></i>Home</a></li>
            <li class="breadcrumb-item text-nowrap active" aria-current="page">Product View</li>
          </ol>
        </nav>
      </div>
      <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
        <h1 class="h3 text-light mb-0">{{ $product->title ?? '' }}</h1>
        <p class="h6 text-muted pt-2">{{$product->category->name ?? ''}}
          @if(!empty($sub_categories[0]))
            > {{$sub_categories[0]}}
          @endif

          @if(!empty($sub_categories[1]))
            > {{$sub_categories[1]}}
          @endif
        </p>
      </div>
    </div>
</div>



<!-- Page Content-->
<div class="container">
  <!-- Gallery + details-->
  <div class="bg-light shadow rounded-lg px-2 py-3 mb-5">
    <div class="px-lg-3">
      <div class="row">
        <!-- Product gallery-->
        <div class="col-lg-6 p-lg-4 mr-lg-4">
            <div class="cz-product-gallery">

              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  @foreach($product->images as $k => $image)
                    <div class="carousel-item @if($k==0) active @endif">
                      <a href="{{ asset('storage/product_images/'.$image->image) }}" data-lightbox="{{$product->id ?? ''}}">
                        <img class="d-block w-100" src="{{ asset('storage/product_images/'.$image->image) }}" alt="{{$product->title ?? ''}}">
                      </a>
                    </div>
                  @endforeach

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
        <!-- Product details-->
        <div class="col-lg-5 pt-4 pt-lg-0">
          <div class="ml-auto pt-lg-4 pb-3">
            <div class="mb-2 text-muted">
                <small>{{ $product->totalSold() ?? 0 }} Sold</small>
            </div>
            <div class=""><span class="h3 font-weight-normal text-primary mr-1">&#2547; @if($product->has_discount){{ $product->priceAfterDiscount() ?? '' }}@else{{ $product->priceExploder()[0] ?? '' }}@endif.<small>{{ $product->priceExploder()[1] ?? '' }}</small></span>
              @if($product->has_discount)<del class="text-muted font-size-lg mr-3">&#2547; {{ $product->priceExploder()[0] ?? '' }}.<small>{{ $product->priceExploder()[1] ?? '' }}</small></del>@endif
              <span class="badge badge-danger badge-shadow align-middle mt-n2">Sale</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3"><a href="#reviews" data-scroll>
                <span class="d-inline-block font-size-sm text-body align-middle mt-1 ">{{ number_format($product->rating(), 2) ?? 0}} / {{ $product->totalRating() ?? 0 }}</span>
                <span class="d-inline-block font-size-sm text-body align-middle mt-1 mx-1">|</span>
                <div class="star-rating">
                  @php $run = 5; @endphp
                  @for($i=0; $i < (int)$product->rating(); $i++)
                    <i class="fas fa-star sr-star active"></i>
                    @php $run--; @endphp
                  @endfor

                  @for($i=0; $i < $run; $i++)
                    <i class="fas fa-star sr-star"></i>
                  @endfor
                </div>
                <span class="d-inline-block font-size-sm text-body align-middle mt-1 mx-1">|</span>
                <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1">{{ $product->totalRating() ?? 0 }} {{'Review'}}@if($product->totalRating() > 1){{'s'}}@endif</span></a>
            </div>

            <form id="product_cart_form" class="mb-grid-gutter" action="@if(Route::has('cart')) {{ route('cart') }} @endif" method="post">
              @csrf
              <input type="hidden" name="product_id" id="product_id" value="{{ $product->id ?? '' }}">
              <script>let att_val_size = {{count($product->attributes)}}</script>
              <div id="attribute_value_container">
              </div>


              @foreach($product->attributes as $attribute)
                <div class="font-size-md mb-1"><span class="text-heading mr-1">{{ $attribute->key ?? '' }}</span></div>
                <div class="position-relative mr-n4 mb-3">
                  @foreach($attribute->values as $value)
                    <button type="button" value="{{ $value->id ?? '' }}" class="btn btn-outline-dark btn-sm product-variation-row-{{$attribute->id ?? ''}}" onclick="variationClicked(this, {{$attribute->id ?? ''}}, {{$value->id ?? ''}})">
                      {{ $value->value ?? '' }}
                    </button>
                  @endforeach
                </div>
              @endforeach

              <div class="form-group d-flex align-items-center">
                <span class="h6 text-muted align-middle mr-2 mb-0">Quantity</span>
                <input class="form-control form-control-sm" type="number" min="1" id="qty" name="qty" max="{{$product->stock}}" value="1">
              </div>
              <button id="add-to-cart" name="add-to-cart" class="btn btn-outline-primary btn-shadow w-45" type="button" onclick="addToCart('add_to_cart')">Add to Cart</button>
              <button id="buy" name="buy" class="btn btn-primary btn-shadow w-45" type="button" onclick="addToCart('buy_now')">Buy Now</button>
            </form>
            <!-- Sharing-->
            <div class="d-flex align-items-center">
              <h6 class="d-inline-block align-middle font-size-base my-2 mr-2">Share:</h6>
              <iframe src="https://www.facebook.com/plugins/share_button.php?href={{route('product', $product->slug)}}&layout=button&size=small&appId=582716849015861&width=68&height=20" width="68" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
<li class="nav-item">
  <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
</li>
<li class="nav-item">
  <a class="nav-link" data-toggle="tab" href="#reviews">Reviews</a>
</li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
<div id="description" class="tab-pane active"><br>
  <!-- Product description-->
  <div class="row align-items-center py-md-3 mb-lg-3">
    <div class="col py-4 order-md-1">
      <h2 class="h3 mb-4 pb-2"> {{ $product->title ?? '' }}</h2>
      <p class="font-size-sm text-muted pb-2">{!! $product->description ?? '' !!}</p>
    </div>
  </div>
</div>
<div id="reviews" class="tab-pane fade"><br>
    <!-- Reviews-->
    <div class="my-lg-3 pt-2 pb-5">
        <div class="container pt-md-2" id="reviews">
        <!--
        <div class="row pb-3">
            <div class="col-lg-4 col-md-5">
            <h2 class="h3 mb-4">74 Reviews</h2>
            <div class="star-rating mr-2"><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star active"></i><i class="fas fa-star sr-star"></i></div><span class="d-inline-block align-middle">4.1 Overall rating</span>
            <p class="pt-3 font-size-sm text-muted">58 out of 74 (77%)<br>Customers recommended this product</p>
            </div>
            <div class="col-lg-8 col-md-7">
            <div class="d-flex align-items-center mb-2">
                <div class="text-nowrap mr-3"><span class="d-inline-block align-middle text-muted">5</span><i class="fas fa-star sr-star active font-size-xs ml-1"></i></div>
                <div class="w-100">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div><span class="text-muted ml-3">43</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="text-nowrap mr-3"><span class="d-inline-block align-middle text-muted">4</span><i class="fas fa-star sr-star active font-size-xs ml-1"></i></div>
                <div class="w-100">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 27%; background-color: #a7e453;" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div><span class="text-muted ml-3">16</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="text-nowrap mr-3"><span class="d-inline-block align-middle text-muted">3</span><i class="fas fa-star sr-star active font-size-xs ml-1"></i></div>
                <div class="w-100">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 17%; background-color: #ffda75;" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div><span class="text-muted ml-3">9</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="text-nowrap mr-3"><span class="d-inline-block align-middle text-muted">2</span><i class="fas fa-star sr-star active font-size-xs ml-1"></i></div>
                <div class="w-100">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" role="progressbar" style="width: 9%; background-color: #fea569;" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div><span class="text-muted ml-3">4</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-nowrap mr-3"><span class="d-inline-block align-middle text-muted">1</span><i class="fas fa-star sr-star active font-size-xs ml-1"></i></div>
                <div class="w-100">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 4%;" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div><span class="text-muted ml-3">2</span>
            </div>
            </div>
        </div>
        <hr class="mt-4 pb-4 mb-3">
      -->
        <div class="row">
            <!-- Reviews list-->
            <div class="col-md-7">
            <div class="d-flex justify-content-end pb-4">
                <div class="form-inline flex-nowrap">
                <label class="text-muted text-nowrap mr-2 d-none d-sm-block" for="sort-reviews">Sort by:</label>
                <select class="custom-select custom-select-sm" id="sort-reviews">
                    <option>Newest</option>
                    <option>Oldest</option>
                    <option>Popular</option>
                    <option>High rating</option>
                    <option>Low rating</option>
                </select>
                </div>
            </div>

            <!-- Review-->
            <!-- print reviews -->
            @foreach($reviews as $review)
            <div class="product-review pb-4 mb-4 border-bottom">
                <div class="d-flex mb-3">
                <div class="media media-ie-fix align-items-center mr-4 pr-2"><img class="rounded-circle" width="50" src="@if($review->user->image) {{ asset('storage/user_images/'.$review->user->image) }} @else {{ asset('storage/user_images/default.png') }} @endif" alt="{{ $review->user->last_name ?? 'Unknown' }}"/>
                    <div class="media-body pl-3">
                    <h6 class="font-size-sm mb-0">{{ $review->user->last_name ?? 'Unknown' }}</h6><span class="font-size-ms text-muted">{{ $review->created_at ?? '' }}</span>
                    </div>
                </div>
                <div>
                    <div class="star-rating">
                      <!-- print starts -->
                      @php $run = 5; @endphp
                      @for($i=0; $i < $review->rating; $i++)
                        <i class="fas fa-star sr-star active"></i>
                        @php $run--; @endphp
                      @endfor

                      @for($i=0; $i < $run; $i++)
                        <i class="fas fa-star sr-star"></i>
                      @endfor

                      <!-- <i class="fas fa-star sr-star active"></i>
                      <i class="fas fa-star sr-star"></i> -->
                    </div>
                    <!-- <div class="font-size-ms text-muted">83% of users found this review helpful</div> -->
                </div>
                </div>
                <p class="font-size-md mb-2">
                  {{ substr($review->review, 0, 500) }}
                </p>
                <ul class="list-unstyled font-size-ms pt-1">
                </ul>
                <!-- <div class="text-nowrap">
                <button class="btn btn-like" type="button"><i class="far fa-thumbs-up"></i></button><span class="align-middle">17</span>
                <span class="ml-2 align-middle">|</span>
                <button class="btn btn-dislike" type="button"><i class="far fa-thumbs-down"></i></button><span class="align-middle">06</span>
                </div> -->
            </div>
            @endforeach

            <div class="text-center">
                <button class="btn btn-outline-primary" type="button"><i class="fas fa-redo-alt mr-2"></i>Load more reviews</button>
            </div>
            </div>
            <!-- Leave review form-->
            <div class="col-md-5 mt-2 pt-4 mt-md-0 pt-md-0">

            @if($user_bought_this)
            <div class="bg-secondary py-grid-gutter px-grid-gutter rounded-lg">
                <h3 class="h4 pb-2">Write a review</h3>
                <form class="needs-validation" action="{{ route('user.store') }}" method="post">
                  <input type="hidden" name="for" value="review">
                  <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                  @csrf

                <div class="form-group">
                    <label for="review-rating">Rating<span class="text-danger">*</span></label>
                    <select class="custom-select" name="rating" required id="review-rating">
                    <option value="">Choose rating</option>
                    <option value="5">5 stars</option>
                    <option value="4">4 stars</option>
                    <option value="3">3 stars</option>
                    <option value="2">2 stars</option>
                    <option value="1">1 star</option>
                    </select>
                    <div class="invalid-feedback">Please choose rating!</div>
                </div>
                <div class="form-group">
                    <label for="review-text">Review<span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="6" required id="review-text" name="review"></textarea>
                    <div class="invalid-feedback">Please write a review!</div><small class="form-text text-muted">Your review must be at least 50 characters.</small>
                </div>
                <button class="btn btn-primary btn-shadow btn-block" type="submit">Submit a Review</button>
                </form>
            </div>
            @endif

            </div>
        </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Inject lightbox css & js -->
@push('meta')
<meta property="og:image" content="{{ asset('storage/product_images/'.$product->images[0]->image ?? '') }}" />
  <meta property="og:title" content="{{ $product->title ?? '' }}" />
  <meta property="og:site_name" content="{{ config('app.name', 'E-commerce') }}" />
  <meta property="og:description" content="{{ substr($product->description, 100) }}" />
@endpush

@push('css')
  <link rel="stylesheet" href="{{ asset('frontend/css/lightbox.css') }}">
@endpush

@push('js')
  <script src="{{ asset('frontend/js/lightbox.js') }}"></script>
@endpush
