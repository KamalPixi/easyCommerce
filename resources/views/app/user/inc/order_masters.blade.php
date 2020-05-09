<div class="container">
  <div class="row bg-offwhite">
    <div class="col px-0">
      <nav class="nav">
        <a class="nav-link @if(request()->getQueryString() == 'for=all' || request()->getQueryString() == '') border-bottom-danger @endif w-20 text-center text-dark" href="{{ route('user.index', ['for'=>'all']) }}">All</a>
        <a class="nav-link w-20 text-center text-dark @if(request()->getQueryString() == 'for=shipped') border-bottom-danger @endif" href="{{ route('user.index', ['for'=>'shipped']) }}">Shipped</a>
        <a class="nav-link w-20 text-center text-dark @if(request()->getQueryString() == 'for=completed') border-bottom-danger @endif" href="{{ route('user.index', ['for'=>'completed']) }}">Completed</a>
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col">

      @if(isset($order_masters))
        @foreach($order_masters as $order_master)
        <div class="border my-4 border-light p-2">

          <div class="d-flex align-items-center px-2 my-2">
            <div class="">
              <span class="font-weight-bold">Order id:</span> {{ $order_master->id  ?? '' }}
            </div>
            <div class="ml-auto">
              <span class="font-weight-bold">Date:</span> {{ $order_master->created_at ?? '' }}
            </div>
          </div>

          <hr class="my-0">
          @foreach($order_master->orders as $order)
            <div class="d-flex mb-2">
              <div class="d-inline-block">
                <img src="{{ asset('storage/product_thumbs/'.$order->product->thumbnail->thumbnail) }}" alt="product image" width="80" height="80"/>
              </div>
              <div class="">
                <p class="mb-0 text-dark">{{ $order->product->title ?? '' }}</p>
                <span class="text-secondary">x {{ $order->qty ?? '' }}  </span>
                <div class="text-secondary">
                  @foreach($order->orderProductAttributes as $k2 => $order_p_attr)
                    {{ $order_p_attr->productAttribute->key ?? '' }}:
                    {{ $order_p_attr->productAttributeValue->value ?? '' }}
                    |
                  @endforeach
                </div>
              </div>


              <div class="ml-auto">
                @if($order->has_discount)
                  <span class="font-size-half"><del> &#2547; {{ number_format($order->unit_sale_price, 2) }}</del></span>
                  <br>
                  <span class="font-size-small font-weight-bold"> &#2547; {{ number_format($order->priceAfterDiscount(), 2) }} </span>
                @else
                  <span class="font-size-small font-weight-bold"> &#2547; {{ number_format($order->unit_sale_price, 2) }}</span>
                @endif
              </div>


            </div>
          @endforeach

          <div class="d-flex align-items-center p-2 bg-secondary">

            <div class="ml-auto">
              <div class="d-inline-block text-right">
                <span class="">Shipping:</span> <br>
                <span class="">Total:</span>
              </div>
              <div class="d-inline-block">
                <span class="font-weight-bold">&#2547; {{ number_format($order_master->shipping_cost, 2) }}</span><br>
                <span class="font-weight-bold">&#2547; {{ number_format($order_master->total_price, 2) }}</span>
              </div>

            </div>

          </div>

        </div>

        @endforeach
      @endif

    </div>
  </div>
</div>
