<?php

/* === App Routes === */
Route::get('/', 'AppControllers\AppController@index')->name('index');
Route::get('search', 'AppControllers\AppController@search')->name('search');
Route::post('get', 'AppControllers\AppController@get');

Route::get('cart', 'AppControllers\CartController@cart')->name('cart');
Route::post('cart', 'AppControllers\CartController@addToCart');
Route::resource('checkout', 'AppControllers\CheckoutController');
Route::resource('contact', 'AppControllers\ContactController');

// Socialite
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// Test route
Route::get('test', 'TestController@test');
Route::post('testpost', 'TestController@testPost');


/* === User Routes === */
Route::resource('user', 'UserControllers\UserController');
Auth::routes();


/* === Admin Routes === */
Route::get('admin', 'Auth\AdminLoginController@showLoginForm')->name('admn.login.show');
Route::post('admin', 'Auth\AdminLoginController@login')->name('admin.login');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

// Admin Password reset routes
Route::get('admin/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.reset.form');
Route::post('admin/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.reset.send');
Route::get('admin/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.reset.token');
Route::post('admin/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.reset');

// Admin dashboard routes
Route::prefix('admin')->middleware('admin.middleware:admin')->group(function () {
    Route::get('dashboard', 'AdminControllers\AdminController@index')->name('admin.dashboard');
    Route::get('profile', 'AdminControllers\AdminController@profile')->name('admin.profile');
    Route::post('profile', 'AdminControllers\AdminController@profileUpdate')->name('admin.profile.update');

    // Categories
    Route::resource('categories', 'AdminControllers\CategoryController');
    Route::resource('subcategories', 'AdminControllers\SubCategoryController');
    Route::resource('sub-subcategories', 'AdminControllers\SubSubCategoryController');

    //products
    Route::resource('products', 'AdminControllers\ProductController');
    Route::resource('brands', 'AdminControllers\BrandController');
    Route::resource('shipping-methods', 'AdminControllers\ShippingMethodController');
    Route::resource('order_master', 'AdminControllers\OrderMasterController');
    Route::resource('pending_orders', 'AdminControllers\PendingOrderController');
    Route::resource('completed_orders', 'AdminControllers\CompletedOrderController');
    Route::resource('shipped_orders', 'AdminControllers\ShippedOrderController');
    Route::resource('sliders', 'AdminControllers\SliderController');
    Route::resource('socials', 'AdminControllers\SocialController');
    Route::resource('website-settings', 'AdminControllers\WebsiteSettingController');
    Route::resource('customers', 'AdminControllers\CustomerController');
    Route::resource('popup_banners', 'AdminControllers\PopUpBannerController');
    Route::resource('contacts', 'AdminControllers\ContactController');


});
/* === End of Admin Routes === */

// single product display
Route::get('{slug}', 'AppControllers\AppController@product')->where('slug', "^[a-z0-9]+(?:-[a-z0-9]+)*$")->name('product');
