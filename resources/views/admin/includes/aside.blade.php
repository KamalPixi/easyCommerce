<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <span class="brand-text font-weight-light">Dashboard</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('storage/user_images/'.auth()->guard('admin')->user()->image) }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="{{ route('admin.dashboard') }}" class="d-block">{{ auth()->guard('admin')->user()->first_name. ' ' .auth()->guard('admin')->user()->last_name }}</a>
    </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/products*') ||
                Request::is('admin/categories*') ||
                Request::is('admin/subcategories*') ||
                Request::is('admin/sub-subcategories*') ||
                Request::is('admin/sliders*') ||
                Request::is('admin/popup_banners*') ||
                Request::is('admin/brands*')) menu-open @endif"
        >
        <a href="#" class="nav-link
        @if(Request::is('admin/products*') ||
            Request::is('admin/categories*') ||
            Request::is('admin/subcategories*') ||
            Request::is('admin/sub-subcategories*') ||
            Request::is('admin/sliders*') ||
            Request::is('admin/popup_banners*') ||
            Request::is('admin/brands*')) active @endif">
            <i class="fas fa-th-list"></i>
            <p>
            Products
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('products.index')) {{ route('products.index') }} @endif" class="nav-link
                    @if(Request::is('admin/products*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Products</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="@if(Route::has('categories.index')) {{ route('categories.index') }} @endif"
                    class="nav-link @if(Request::is('admin/categories*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Categories</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="@if(Route::has('subcategories.index')) {{ route('subcategories.index') }} @endif"
                class="nav-link @if(Request::is('admin/subcategories*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SubCategories</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('sub-subcategories.index')) {{ route('sub-subcategories.index') }} @endif"
                class="nav-link @if(Request::is('admin/sub-subcategories*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sub SubCategories</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('brands.index')) {{ route('brands.index') }} @endif"
                class="nav-link @if(Request::is('admin/brands*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Brand</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('sliders.index')) {{ route('sliders.index') }} @endif"
                class="nav-link @if(Request::is('admin/sliders*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sliders</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('popup_banners.index')) {{ route('popup_banners.index') }} @endif"
                class="nav-link @if(Request::is('admin/popup_banners*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Popup Banners</p>
                </a>
            </li>

        </ul>
        </li>
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/pending_orders*') ||
            Request::is('admin/completed_orders*') ||
            Request::is('admin/order_master*') ||
            Request::is('admin/shipped_orders*'))
             menu-open @endif">
        <a href="#" class="nav-link
          @if(Request::is('admin/pending_orders*') ||
          Request::is('admin/completed_orders*') ||
          Request::is('admin/order_master*') ||
          Request::is('admin/shipped_orders*'))
           active @endif">
            <i class="fas fa-sort-amount-up-alt"></i>
            <p>
            Orders
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('pending_orders.index')) {{ route('pending_orders.index') }} @endif" class="nav-link
                    @if(Request::is('admin/pending_orders*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pending Orders</p>
                </a>
            </li>

            <li class="nav-item">
              <a href="@if(Route::has('completed_orders.index')) {{ route('completed_orders.index') }} @endif" class="nav-link
                  @if(Request::is('admin/completed_orders*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Completed Orders</p>
                </a>
            </li>

            <li class="nav-item">
              <a href="@if(Route::has('completed_orders.index')) {{ route('shipped_orders.index') }} @endif" class="nav-link
                  @if(Request::is('admin/shipped_orders*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Shipped Orders</p>
                </a>
            </li>

        </ul>
        </li>
    </ul>
    </ul>


    <!-- Customers -->
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/customers*')) menu-open @endif"
        >
        <a href="#" class="nav-link">
            <i class="fas fa-users"></i>
            <p>
            Customers
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('customers.index')) {{ route('customers.index') }} @endif" class="nav-link
                    @if(Request::is('admin/customers*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Customers</p>
                </a>
            </li>
        </ul>
        </li>
    </ul>



    <!-- setting -->
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/socials*') ||
            Request::is('admin/website-settings*') ||
            Request::is('admin/shipping-methods*')
            ) menu-open @endif"
        >
        <a href="#" class="nav-link">
            <i class="fas fa-sliders-h"></i>
            <p>
            Settings
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('shipping-methods.index')) {{ route('shipping-methods.index') }} @endif" class="nav-link
                    @if(Request::is('admin/shipping-methods*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Shipping Methods</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('socials.index')) {{ route('socials.index') }} @endif"
                class="nav-link @if(Request::is('admin/socials*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Social Links</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('website-settings.index')) {{ route('website-settings.index') }} @endif"
                class="nav-link @if(Request::is('admin/website-settings*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Site Settings</p>
                </a>
            </li>

        </ul>
        </li>
    </ul>


    <!-- supports -->
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/contacts*')) menu-open @endif"
        >
        <a href="#" class="nav-link">
            <i class="fas fa-info-circle"></i>
            <p>
            Supports
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('contacts.index')) {{ route('contacts.index') }} @endif" class="nav-link
                    @if(Request::is('admin/contacts*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Contacts</p>
                </a>
            </li>
        </ul>
        </li>
    </ul>


    <!-- User Profile -->
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview
            @if(Request::is('admin/profile*')) menu-open @endif"
        >
        <a href="#" class="nav-link">
            <i class="fas fa-address-card"></i>
            <p>
            Profile
            <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="@if(Route::has('admin.profile')) {{ route('admin.profile', ['for'=> 'profile']) }} @endif" class="nav-link
                    @if(Request::is('admin/shipping-methods*') ) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('admin.profile')) {{ route('admin.profile', ['for'=> 'password_change']) }} @endif"
                class="nav-link @if(Request::is('admin/brands*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Change Password</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="@if(Route::has('admin.logout')) {{ route('admin.logout') }} @endif"
                class="nav-link @if(Request::is('admin/logout*')) active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Logout</p>
                </a>
            </li>

        </ul>
        </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
