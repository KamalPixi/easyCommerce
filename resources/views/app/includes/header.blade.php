@php
  $cats = App\AppModels\Category::where('category_id', null)->where('is_active', 1)->get();
  $website_setting = App\AppModels\WebsiteSetting::first();
@endphp

<header>
<div class="topbar">
    <div class="container d-flex justify-content-between">
        <!--TopBar for Small & lower Devices-->
        <div class="dropdown d-md-none">
            <a class="dropdown-toggle" href="/" data-toggle="dropdown"><i class="fas fa-link"></i>Useful
                Links</a>
            <ul class="dropdown-menu z_index-10k">
                <li><a class="dropdown-item" href=""><i class="fas fa-headset"></i><span
                            class="text-muted">Hotline </span>{{ $website_setting->mobile ?? '' }}</a></li>
                <li><a class="dropdown-item" href="/contact?subject=Want to sell my own product."><i class="fas fa-search-dollar"></i>Sell Your Product</a></li>
            </ul>
        </div>
        <div class=" d-md-none">
            <a href="/"><i class="fas fa-question"></i>Help</a>
        </div>

        <!--TopBar for Medium & upper Devices-->
        <div class="d-none d-md-block">
            <i class="fas fa-headset"></i>
            <span class="text-muted">Hotline </span>
            <a href="tel:+1234567890">{{ $website_setting->mobile ?? '' }}</a>
        </div>
        <div class="d-none d-md-block">
            <a href="/contact?subject=Want to sell my own product."><i class="fas fa-search-dollar"></i></i>Sell Your Product</a>
        </div>
        <div class="d-none d-md-block">
            <a href="/"><i class="fas fa-question"></i>Help</a>
        </div>
    </div>
</div>

<!--ToolBar-->
<div class="toolbar .navbar-sticky bg-light">
    <div class="navbar navbar-expand-lg bg-light navbar-light sticky-top custom-navbar">
        <div class="container">
            <a class="navbar-brand icon-style" href="/"> <img class="brand-logo" src="{{ asset('storage/media') }}/{{ $website_setting->logo ?? '' }}" alt="{{ $website_setting->name ?? '' }} logo" width="40" height="40"> <span>
                    {{ $website_setting->name ?? '' }}</span></a>
            <!--Search Bar-->
            <div class="input-group input-group-md d-none d-lg-flex mx-4 position-relative">
                <input id="search_input" class="ml-lg-2 form-control form-inline" type="text" placeholder="Search for products" onkeyup="search(this)">
                <div class="input-group-append" onclick="submitSearch()"><span class="input-group-text">
                  <i class="fas fa-search"></i></span>
                </div>
                <!-- holds search results -->
                <div class="seacrh-result"></div>
            </div>
            <!--User Info & Cart-->
            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">

                @if(Auth::check())
                  <a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="{{ route('login') }}">
                      <div class="navbar-tool-icon-box"><i class="fas fa-user-alt icon-style"></i></div>
                      <div class="navbar-tool-text ml-n2"><small>Hello, {{ Auth::user()->last_name ?? '' }}</small>My Account</div>
                  </a>
                @else
                  <a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="{{ route('login') }}">
                      <div class="navbar-tool-icon-box"><i class="fas fa-user-alt icon-style"></i></div>
                      <div class="navbar-tool-text ml-n2"><small>Hello, Sign in</small>Account</div>
                  </a>
                @endif

                <!-- cart -->
                <div id="cart_holder" class="navbar-tool dropdown ml-3">
                    <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="@if(Route::has('cart')){{ route('cart') }} @endif">
                        <span class="navbar-tool-label">@if(session()->has('cart')) {{ count(session()->get('cart')) }} @else 0 @endif</span><i class="fab fa-opencart icon-style"></i>
                    </a>
                    <a class="navbar-tool-text" href="@if(Route::has('cart')){{ route('cart') }} @endif">
                      <small>Cart</small> &#2547;
                      <!-- it get update by js, see below -->
                      <span id="cart_price_show">0.00</span>
                    </a>

                    <!-- Cart dropdown-->
                    <div class="dropdown-menu dropdown-menu-right" style="width: 20rem;">

                        <div class="widget widget-cart px-3 pt-2 pb-3">
                            <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">

                              @php $sub_total = 0; @endphp
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

                </div>
                <!-- /cart -->

            </div>
            <!--User Cart Finish-->
        </div>
    </div>

    <!-- Navbar-->
    <nav class="navbar navbar-expand-lg bg-light navbar-light pt-0 custom-navbar">
        <div class="container">
            <!--Search Bar-->
            <div class="col mobile_search_bar input-group input-group-md d-flex d-lg-none mr-2 p-0 position-relative">
                <input id="search_input_mobile" class="form-control form-inline" type="text" placeholder="Search for products" onkeyup="search(this)">
                <div class="input-group-append" onclick="submitSearch()"><span class="input-group-text">
                    <i class="fas fa-search"></i></span></div>


                    <!-- holds search results -->
                  <div class="seacrh-result"></div>

            </div>
            <!--navbar toggler icon-->
            <button class="col-auto navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--Categories-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown categories-menu"><a class="nav-link dropdown-toggle pl-0 mt-3 mt-lg-0" href="#" data-toggle="dropdown">
                        <i class="fas fa-bars mr-2"></i>
                        Categories</a>


                        <ul class="dropdown-menu">
                          <!-- Category -->
                          @foreach($cats as $cat)
                            <li class="dropdown dropdown-submenu">
                              <a class="dropdown-item dropdown-toggle" onclick="location.href='@if(Route::has('search')){{ route('search', ['keyword'=>$cat->slug]) }} @endif'" href="javascript:void(0)" data-toggle="dropdown">{{ $cat->name ?? '' }}</a>
                                <ul class="dropdown-menu">
                                  <!-- cat child 1 -->
                                  @foreach($cat->categories as $child_a)
                                    @if($child_a)
                                      <li class="dropdown dropdown-submenu"><a class="dropdown-item dropdown-toggle" onclick="location.href='@if(Route::has('search')){{ route('search', ['keyword'=>$child_a->slug]) }} @endif'" href="javascript:void(0)">{{ $child_a->name ?? '' }}</a>
                                        @if(count($child_a->childrenCategories) > 0)
                                          <ul class="dropdown-menu">
                                            <!-- cat child 2 -->
                                            @foreach($child_a->childrenCategories as $child_b)
                                                <li><a class="dropdown-item" href="@if(Route::has('search')){{ route('search', ['keyword'=>$child_b->slug]) }} @endif">{{ $child_b->name ?? '' }}</a></li>
                                            @endforeach
                                          </ul>
                                        @endif
                                      </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach

                        </ul>


                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><!--NavBar Finish-->
</div><!--ToolBar Finish-->

</header>

<!-- set total price in cart  -->
<script> document.getElementById('cart_price_show').innerHTML='{{ number_format($sub_total, 2) }}' </script>
