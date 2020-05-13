@if(isset($main_products) && count($main_products) > 0)
<section class="container pt-md-3 pb-5 mb-md-3">
<h3 class="sectionHeading font-size-lg text-uppercase font-weight-bold text-dark">Trending Products</h3>
<div class="row pt-4 mx-n2">
    @foreach($main_products as $product)
    <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-4">
        <div class="card product-card">
            <span class="badge badge-danger badge-shadow">Sale</span>
            <a class="card-img-top d-block overflow-hidden" href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif">
              <img class="lozad" data-src="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail ?? '') }}" alt="{{ $product->title ?? 'product img' }}">
            </a>
            <div class="card-body py-2"><a class="product-meta d-block font-size-xs pb-1" href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif">{{ $product->category->name ?? '' }}</a>
                <h3 class="product-title font-size-sm"><a href="@if(Route::has('product')) {{ route('product', [$product->slug]) }} @endif">{{ $product->title ?? '' }}</a></h3>
                <div class="d-flex justify-content-between">

                    <div class="product-price">
                      <span class="text-accent">&#2547; @if($product->has_discount){{ $product->priceAfterDiscount() ?? '' }}@else{{ $product->priceExploder()[0] ?? '' }}@endif.<small>{{ $product->priceExploder()[1] ?? '' }}</small></span>
                      @if($product->has_discount)<del class="text-muted font-size-sm mr-3">&#2547;{{ $product->priceExploder()[0] ?? '' }}.<small>{{ $product->priceExploder()[1] ?? '' }}</small></del>@endif
                    </div>

                    <div class="star-rating">
                      <!-- print starts -->
                      @php $run = 5; @endphp
                      @for($i=0; $i < (int)$product->rating(); $i++)
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
