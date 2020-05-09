<div class="container my-5">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill">@if(isset($products)){{ count($products) }} @endif</span>
      </h4>
      <ul class="list-group mb-3">

        @if(count($products) > 0)
        @php $sub_total = 0; $sub_total += $shipping_method->cost ?? 0; @endphp
          @foreach($products as $k => $product)
            @php $sub_total += $product->calculate($product->sale_price, '*', session('cart')[$k]['qty']) @endphp

        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0 text-secondary">{{ $product->title ?? '' }}</h6>
            <!-- <small class="text-muted">Brief description</small> -->
          </div>
          <span class="text-muted">&#2547; {{ $product->sale_price ?? '' }}</span>
        </li>
        @endforeach
        @endif

        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Shipping Method</h6>
            <small class="text-muted">{{ $shipping_method->name ?? '' }}</small><br>
            <small class="text-muted">{{ $shipping_method->description ?? '' }}</small>
          </div>
          <span class="text-muted">&#2547; {{ $shipping_method->cost ?? '' }}</span>
        </li>

        <li class="list-group-item d-flex justify-content-between">
          <span>Total (&#2547;)</span>
          <strong>&#2547; {{ $sub_total ?? '0.00'}}</strong>
        </li>
      </ul>

      <!-- <form class="card p-2">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Promo code">
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </div>
      </form> -->
    </div>

    <div class="col-md-8 order-md-1">
      <form class="needs-validation" novalidate="">
        <!-- shipping address -->
        <div class="" id="shipping_address_row">
          <h4 class="mb-3">Shipping Address</h4>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="firstName">First name *</label>
              <input type="text" class="form-control" id="shipping_firstName" placeholder="" value="{{ auth()->user()->first_name ?? '' }}" required="">
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="lastName">Last name *</label>
              <input type="text" class="form-control" id="shipping_lastName" placeholder="" value="{{ auth()->user()->last_name ?? '' }}" required="">
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="address">Address *</label>
            <input type="text" class="form-control" id="shipping_address_1" placeholder="1234 Main St" required="">

          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="country">Country *</label>
              <select class="custom-select d-block w-100" id="shipping_country" required="">
                <option>Bangladesh</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="state">Division *</label>
              <select class="custom-select d-block w-100" id="shipping_state" required="">
                <option value="">Choose...</option>
                <option>Dhaka</option>
                <option>Chittagong</option>
                <option>Sylhet</option>
                <option>Barisal</option>
                <option>Khulna</option>
                <option>Rajshahi</option>
                <option>Rangpur</option>
                <option>Mymensingh</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="city">City *</label>
              <input type="text" class="form-control" id="shipping_city" placeholder="Enter city name" required="">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="zip">Postal Code *</label>
              <input type="text" class="form-control" id="shipping_zip" placeholder="Enter postal code" required="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="city">Mobile No.</label>
              <input type="text" class="form-control" id="shipping_mobile" placeholder="Enter mobile no." required="">
            </div>
          </div>

        </div>
        <!--/ shipping address -->

        <hr class="mb-4">
        <h4 class="mb-3">Payment</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
            <label class="custom-control-label" for="credit">bKash</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
            <label class="custom-control-label" for="debit">Rocket</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="cash_on_delivery" name="paymentMethod" type="radio" class="custom-control-input" required="">
            <label class="custom-control-label" for="cash_on_delivery">Cash On Delivery</label>
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="button" onclick="submitCheckout()">Continue to checkout</button>
      </form>
    </div>
  </div>
</div>
