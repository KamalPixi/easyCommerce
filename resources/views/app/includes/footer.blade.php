@php
  $website_setting = App\AppModels\WebsiteSetting::first();
  $socials = App\AppModels\Social::where('is_active', 1)->get();
@endphp
<footer class="bg-darker">
<div class="pt-5">
    <div class="container">
        <div class="row pb-3 justify-content-center">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="media"><i class="fas fa-truck text-primary" style="font-size: 2.25rem;"></i>
                    <div class="media-body pl-3">
                        <h6 class="font-size-base text-light mb-1">Fast and free delivery</h6>
                        <p class="mb-0 font-size-ms text-secondary">Free delivery for all orders</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="media"><i class="fas fa-headset text-primary" style="font-size: 2.25rem;"></i>
                    <div class="media-body pl-3">
                        <h6 class="font-size-base text-light mb-1">24/7 customer support</h6>
                        <p class="mb-0 font-size-ms text-secondary">Friendly 24/7 customer support</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="media"><i class="fas fa-money-check-alt text-primary" style="font-size: 2.25rem;"></i>
                    <div class="media-body pl-3">
                        <h6 class="font-size-base text-light mb-1">Secure online payment</h6>
                        <p class="mb-0 font-size-ms text-secondary">We posess SSL / Secure сertificate</p>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-light pb-4 mb-3">
        <div class="row pb-2">
            <div class="col-md-6 text-center text-md-left mb-4">
                <div class="text-nowrap mb-4">
                    <a class="d-inline-block align-middle mt-n1 mr-3 text-white" href="/">
                        <img src="{{ asset('storage/media') }}/{{ $website_setting->logo ?? '' }}" class="brand-logo" width="40" alt="{{ $website_setting->name ?? '' }} logo"> {{ $website_setting->name ?? '' }}
                    </a>

                </div>
                <div class="widget">
                    <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                        <li class="mr-4"><a class="widget-list-link text-white" href="/">Support</a></li>
                        <li class="mr-4"><a class="widget-list-link text-white" href="/">Privacy</a></li>
                        <li class="mr-4"><a class="widget-list-link text-white" href="/">Terms of use</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-right mb-4">
                <div class="mb-3">

                  @foreach($socials as $social)
                    <a target="_blank" class="social-btn sb-light sb-twitter ml-2 mb-2" href="https://{{ $social->address ?? '' }}"><i class="{{ $social->icon_class ?? '' }}"></i></a>
                  @endforeach
                </div>
                <div class="mb-3">
                    <i class="fab fa-cc-visa pay-icon"></i>
                    <i class="fab fa-cc-mastercard pay-icon"></i>
                    <i class="fab fa-cc-paypal pay-icon"></i>
                    <i class="fab fa-cc-stripe pay-icon"></i>
                </div>

            </div>
        </div>
        <div class="pb-4 font-size-xs text-light opacity-50 text-center text-md-left">{{ $website_setting->name ?? '' }} © 2020 All rights reserved.</div>
    </div>
</div>
</footer>
