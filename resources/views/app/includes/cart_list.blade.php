@php $sub_total = 0; @endphp
@if(session()->has('cart'))
  @foreach(session()->get('cart') as $c)
    @php $p = App\AppModels\Product::find($c['product_id']); $sub_total += $p->sale_price; @endphp
  @endforeach
@endif
<a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="@if(Route::has('cart')){{ route('cart') }} @endif">
  <span class="navbar-tool-label">@if(session()->has('cart')) {{ count(session()->get('cart')) }} @else 0 @endif</span><i class="fab fa-opencart icon-style"></i>
</a>
<a class="navbar-tool-text" href="@if(Route::has('cart')){{ route('cart') }} @endif">
<small>Cart</small> &#2547;
<span id="cart_price_show">{{ $sub_total }}</span>
@php $sub_total = 0; @endphp
</a>

<!-- Cart dropdown-->
<div class="dropdown-menu dropdown-menu-right" style="width: 20rem;">

  <div  id="cart_holder" class="widget widget-cart px-3 pt-2 pb-3">
      <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
        @if(session()->has('cart'))

          @foreach(session()->get('cart') as $c)
            @php $p = App\AppModels\Product::find($c['product_id']); $sub_total += $p->sale_price; @endphp
              <div class="widget-cart-item pb-2 border-bottom">
                  <button class="close text-danger" type="button" aria-label="Remove" onclick="removeFromCart({{ $c['product_id'] }})">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <div class="media align-items-center"><a class="d-block mr-2"
                          href="@if(Route::has('product')) {{ route('product', [$p->slug]) }} @endif">
                          <img width="64" src="{{ asset('storage/product_thumbs/'.$p->thumbnail->thumbnail) }}"
                              alt="Product" /></a>
                      <div class="media-body">
                          <h6 class="widget-product-title">
                            <a href="@if(Route::has('product')) {{ route('product', [$p->slug]) }} @endif">{{ substr($p->title ,0, 25).'...' }}</a>
                          </h6>
                          <div class="widget-product-meta">
                            <span class="text-accent mr-2">&#2547; {{ $p->priceExploder()[0] ?? '' }}.
                              <small>{{ $p->priceExploder()[1] ?? '' }}</small></span>
                              <span class="text-muted">x {{ $c['qty'] ?? '' }}</span>
                          </div>
                      </div>
                  </div>
              </div>
            @endforeach
          @endif
      </div>
      <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
          <div class="font-size-sm mr-2 py-2"><span
                  class="text-muted">Subtotal:</span><span
                  class="text-accent font-size-base ml-1">&#2547; {{ number_format($sub_total, 2) }} <small></small></span>
          </div>
      </div><a class="btn btn-primary btn-sm btn-block" href="@if(Route::has('cart')) {{ route('cart') }} @endif">
        <i class="czi-card mr-2 font-size-base align-middle"></i>Checkout</a>
  </div>

</div>
<script> document.getElementById('cart_price_show').innerHTML='{{ number_format($sub_total, 2) }}' </script>
