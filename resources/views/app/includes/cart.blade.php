@if(count($products) > 0)
<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">

    <div class="cart_inner">
        <div class="table-responsive">
          @include('app.includes.error');

            <form id="cart" action="{{ route('cart') }}" method="post">
                @csrf
                <input type="hidden" name="update" value="cart">

        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="font-weight:700">Products</th>
                <th scope="col" style="text-align:right;font-weight:700">Price</th>
                <th scope="col" style="text-align:center;font-weight:700">Quantity</th>
                <th scope="col" style="text-align:right;width:10rem;font-weight:700">Total</th>
            </tr>
            </thead>
            <tbody>

              @if(count($products) > 0)
              @php $sub_total = 0; @endphp
                @foreach($products as $k => $product)

                  @php $sub_total += $product->calculate($product->sale_price, '*', session('cart')[$k]['qty']) @endphp

            <tr>
                <td>
                <div class="media">
                    <div class="d-flex"> <img style="width:60px;height:60px;" src="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}" alt=""/> </div>
                    <div class="media-body">
                    <p>{{ $product->title ?? '' }}</p>
                    <input type="hidden" value="{{ $product->id }}" name="product_id[]">
                    </div>
                </div>
                </td>
                <td style="text-align:right">
                    <h5 style="font-weight:700"> &#2547; {{ $product->sale_price ?? '' }}</h5>
                </td>
                <td style="text-align:center">
                <div class="product_count">
                    <input type="text" min="1" name="qty[]" id="sst_{{ $product->id }}" maxlength="12" value="{{ session('cart')[$k]['qty'] }}" title="Quantity:" class="input-text qty"/>
                    <button
                    onclick="var result = document.getElementById('sst_{{ $product->id }}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                    class="increase items-count"
                    type="button"
                    >
                    <i class="arrow-up"><img src="{{ asset('frontend/img/arrow-up.svg') }}" alt="" style="display:inline-block;width:15px;height:15px;"></i>
                    </button>
                    <button
                    onclick="var result = document.getElementById('sst_{{ $product->id }}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
                    class="reduced items-count"
                    type="button"
                    >
                    <i class="arrow-up"><img src="{{ asset('frontend/img/arrow-down.svg') }}" alt="" style="display:inline-block;width:15px;height:15px;"></i>                    </button>
                </div>
                </td>
                <td style="text-align:right">
                    <h5 style="font-weight:700">&#2547; {{ $product->calculate($product->sale_price, '*',  session('cart')[$k]['qty']) }}</h5>
                    <a href="{{ route('cart', ['delete'=>$product->id]) }}"><img style="width:20px;height:20px;" src="{{ asset('frontend/img/delete.svg') }}" alt="delete"></a>
                </td>
            </tr>
            @endforeach
            @endif

            <tr>
                <td style=""></td>
                <td style=""></td>
                <td style="text-align:right" colspan="2">
                    <button type="submit" class="btn btn-outline-info rounded-5" href="#"> &nbsp &nbsp &nbsp &nbsp Update Cart &nbsp &nbsp &nbsp &nbsp </button>
                </td>
            </tr>

            <tr class="font-weight-normal">
                <td colspan="4">

                  <div class="col-lg-4 offset-lg-8 pl-4 pr-0">
                    <h5 class="font-weight-bold">Shipping Method</h5>

                    @foreach($shipping_methods as $sm)
                    <div class="d-flex">
                      <div class="">
                        <input onclick="shippingChoosed({{$sm->id ?? ''}})" type="radio" id="s_{{$sm->id ?? ''}}" name="shipping_method" value="{{$sm->id ?? ''}}">
                        <label for="s_{{$sm->id ?? ''}}">{{$sm->name ?? ''}} </label>
                      </div>
                      <div class="ml-auto">
                        <span class="font-weight-bold">&#2547; {{ $sm->cost ?? '' }}</span>
                      </div>
                    </div>

                    @endforeach
                  </div>
                </td>

            </tr>

            <tr>
                <td></td>
                <td></td>

                <td>
                  <h5>Total</h5>
                </td>
                <td class="text-right">
                  <h5 style="font-weight:700">&#2547; <span id="cart-subtotal">{{ $sub_total }}</span> </h5>
                </td>

            </tr>
            <tr style="text-align:right">
                <td style="width:40rem;"></td>
                <td colspan="3">
                    <div class="checkout_btn_inner">
                        <a class="btn btn-black btn-outline-secondary rounded-5" href="/">Continue Shopping</a>
                        <button type="button" name="button" onclick="checkLoginStatus()" class="btn btn-primary rounded-5">Proceed to checkout</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        </form>
        </div>
    </div>
    </div>
</section>
<!--================End Cart Area =================-->
@else
<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
    <div class="cart_inner">
        <div class="table-responsive">
        <table class="table" style="margin-top:5rem;">
            <thead>
            <tr>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td style="text-align:center">Cart is empty</td>
            </tr>

            <tr>
                <td></td>
            </tr>


            </tbody>
        </table>

        </div>
    </div>
    </div>
</section>
@endif


@if(!auth()->check())
<!-- login & regitration model -->
<div class="modal fade" id="login_registration_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header py-3 text-center">
        <h6 class="modal-title w-100" id="exampleModalLongTitle">Please Login Or Register for an Account</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Login</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Register</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <!-- login tab -->
          <div class="tab-pane fade show active mb-4 pt-2" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <!-- error container -->
            <div id="login_error_container">

            </div>

            <!-- fb -->
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=582716849015861&autoLogAppEvents=1"></script>

            <div class="form-group row mt-3">
                <label for="email" class="col-md-4 col-form-label text-md-right"></label>
                <div class="col-md-6">
                    <div class="fb-login-button" data-size="medium" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
                </div>
            </div>
            <!-- end fb -->

            <form method="POST" action="{{ route('login') }}" id="user_popup_login">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="button" class="btn btn-primary" onclick="loginUser()">
                            {{ __('Login') }}
                        </button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                        @endif
                    </div>
                </div>
            </form>
          </div>

          <!-- registration tab -->
          <div class="tab-pane fade my-4" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- error container -->
            <div id="registration_error_container">

            </div>

            <form id="cart_user_registration" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">First Name</label>
                    <div class="col-md-6">
                        <input id="first_name" type="text" class="form-control" name="first_name" value="" required autocomplete="first_name" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                    <div class="col-md-6">
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="" required autocomplete="name" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" onclick="registerUser()">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endif
