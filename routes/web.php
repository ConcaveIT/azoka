<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/generate-sitemap', function () {

    \Spatie\Sitemap\SitemapGenerator::create('https://amarshop.com.bd')->writeToFile(public_path('sitemap.xml'));

    echo 'Sitemap Generated';

});

Route::get('/make-product-slug', function () {
   foreach (\App\Product::all() as $product) {
       $product->update(['slug' => \Illuminate\Support\Str::slug($product->name)]);
   }
   echo 'Slug successfully made!';
});

Route::get('/cart-weight', function () {
   echo session()->get('cart_weight');
});

Route::post('/set-shipping-cost', function () {
    session()->put('shipping_cost', request()->get('shipping_cost'));
});

Route::get('/log', function () {
   $activities = \Spatie\Activitylog\Models\Activity::all();
   return view('log', compact('activities'));
})->middleware('can:access-manager-data');

Route::get('/compare/remove', function () {
   session()->forget(['compare']);
   return redirect()->back();
});

/*********************
 *
 *
 * FRONTEND ROUTES
 */
/*********************
 *
 */
Route::get('/', 'FrontendController@index')->name('home');
Route::get('/shop/{slug}', 'FrontendController@shop')->name('shop');
//Route::get('/shop/{shopId}/subshop/{subId}', 'FrontendController@subshop')->name('subshop');


// *Orgianl route *
//Route::get('/shop/{shopSlug}/product/{productSlug}', 'FrontendController@product_details')->name('product-details');

// *Customize route*
Route::get('/shop/{shopSlug}', 'FrontendController@product_details')->name('categoory-product');
Route::get('/shop/{shopSlug}/product/{productSlug}', 'FrontendController@product_details')->name('product-details');






Route::get('/wishlist', 'FrontendController@wishlist')->name('wishlist');
Route::get('/compare', 'FrontendController@compare')->name('compare');
Route::get('/cart', 'FrontendController@cart')->name('cart');
//Route::get('/checkout', 'FrontendController@checkout')->name('checkout');
//Route::post('/payment', 'PaymentController@index')->name('payment');
Route::get('/tag/{tagName}', 'FrontendController@tag_search')->name('tag-search');
Route::get('/brand/{brandName}', 'FrontendController@brand_search')->name('brand-search');
Route::get('/search', 'FrontendController@search')->name('search');
Route::post('/filter-product', 'AjaxController@filter_product')->name('filter-product');
Route::get('/filter-product-shop', 'AjaxController@filter_product_shop')->name('filter-product-shop');
Route::get('/filter-product-subshop', 'AjaxController@filter_product_subshop')->name('filter-product-subshop');
Route::get('/my-account', 'FrontendController@my_account')->name('my-account')->middleware('auth:customer');
Route::get('/testimonial', 'TestimonialController@edit')->middleware('auth:customer');
Route::post('/testimonial', 'TestimonialController@store')->middleware('auth:customer');
Route::patch('/my-account/update-account', 'FrontendController@update_account')->name('update-account')->middleware('auth:customer');
Route::patch('/my-account/update-address', 'FrontendController@update_address')->name('update-address')->middleware('auth:customer');
Route::get('/return/{orderId}', 'FrontendController@return_product')->name('return-product')->middleware('auth:customer');
Route::post('/return/{orderId}', 'FrontendController@return_request')->name('return-product')->middleware('auth:customer');
Route::get('/customer-login', 'CustomerController@customer_login')->name('customer-login');
Route::post('/customer-login', 'CustomerController@login_customer');
Route::post('/customer-register', 'CustomerController@register_customer');
Route::get('/contact', 'FrontendController@contact');
Route::get('/about', 'FrontendController@about');
Route::get('/amar-care/{catId}', 'FrontendController@amar_care');
Route::get('/amar-care/{catId}/vlog/{vlogId}', 'FrontendController@vlog')->name('vlog');

//AJAX CALL
Route::post('/wishlist/add', 'AjaxController@add_wishlist');
Route::post('/compare/add', 'AjaxController@add_compare');
Route::get('/wishlist/remove/{wishId}', 'AjaxController@remove_wishlist');
Route::post('/cart/add', 'AjaxController@add_cart');
Route::post('/cart/update', 'AjaxController@update_cart');
Route::get('/cart/remove/{cartId}', 'AjaxController@remove_cart');

Route::get('/remove/headercart/{cartId}', 'AjaxController@headercart');

Route::post('/cart/apply-coupon', 'AjaxController@apply_coupon')->name('apply-coupon');
Route::get('/cart/remove-coupon', 'AjaxController@remove_coupon')->name('remove-coupon');

Route::get('/product-price', 'AjaxController@product_price');

Route::get('dynamicModal/{id}',[
    'as'=>'dynamicModal',
    'uses'=> 'AjaxController@loadModal'
]);

Route::get('dynamicModalReview/{id}',[
    'as'=>'dynamicModalReview',
    'uses'=> 'AjaxController@loadModalReview'
]);

Route::post('/product/rate', 'AjaxController@rate_product')->name('rate-product');
Route::post('/vlog/comment', 'AjaxController@comment_vlog')->name('comment-vlog');

Route::get('/privacy-policy', 'PageController@privacy_policy');
Route::get('/terms-conditions', 'PageController@terms_conditions');
Route::get('/delivery-returns', 'PageController@delivery_returns');
Route::get('/about-us', 'PageController@about_us');
Route::get('/contact-us', 'PageController@contact_us');
Route::get('/returns-exchange', 'PageController@returns_exchange');
Route::get('/disclaimer', 'PageController@disclaimer');




/**************
 *
 * BACKEND ROUTES
 *
 *
 ***************/



Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::prefix('admin')->group(function () {

        Route::get('customer-care', 'PageController@customer_care')->name('customer-care');
        Route::post('customer-care', 'PageController@customer_care_store')->name('customer-care');
        Route::get('policies', 'PageController@policies')->name('policies');
        Route::post('policies', 'PageController@policies_store')->name('policies');
        Route::get('testimonial', 'TestimonialController@index');

        Route::middleware('optimizeImages')->group(function () {

            Route::resource('amar-care', 'AmarCareController');

            Route::resource('users', 'UserController', ['except' => ['show']]);
            Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
            Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
            Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
            Route::get('activities/{id}', 'AdminController@destroy_activity')->middleware('can:access-manager-data');



            Route::resource('sale', 'SaleController', ['except' => ['show']]);
            Route::resource('deal', 'DealController', ['except' => ['show']]);
            Route::resource('featured', 'FeaturedController', ['except' => ['show']]);
            Route::resource('coupon', 'CouponController', ['except' => ['show']]);



            Route::get('slider', 'SlideController@index')->name('slider');
            Route::post('slider', 'SlideController@store')->name('slider')->middleware('optimizeImages');
            Route::get('slider/{id}/delete', ['as' => 'slider.delete', 'uses' => 'SlideController@destroy']);
            Route::get('products/export', 'ProductController@exportCSV')->name('exportCSV');
            Route::resource('products', 'ProductController')->middleware('optimizeImages');
            Route::resource('categories', 'CategoryController', ['except' => ['show']]);
            Route::resource('sub_categories', 'SubCategoryController', ['except' => ['show']]);
            Route::resource('brands', 'BrandController', ['except' => ['show']]);


            Route::get('customers', function () {
                $customers = \App\Customer::all();
                return view('pages.customers', compact('customers'));
            })->name('customers');

            Route::get('orders', 'OrderController@index')->name('orders');
            Route::get('orders/{orderId}', 'OrderController@details')->name('order-details');
            Route::patch('orders/{orderId}', 'OrderController@order_update')->name('order-update');

        });

        Route::get('/optimize-website', function () {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            return "OPTIMIZED";
        });


    });

});

Route::get('logout_user', 'Auth\LoginController@logout_user')->name('logout_user');
Route::get('logout_customer', 'CustomerController@logout_customer')->name('logout_customer');

// SSLCOMMERZ Start
//Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/checkout', 'SslCommerzPaymentController@exampleHostedCheckout')->name('checkout');

Route::post('/pay', 'SslCommerzPaymentController@index')->name('payment');
Route::post('/pay-again', 'SslCommerzPaymentController@pay_again')->name('again-payment');
//Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END

//PASSWORD RESET
Route::prefix('customers')->group(function () {
    Route::get('/reset/{token}', '\App\Http\Controllers\Auth\ResetPasswordController@showResetForm')
        ->name('customers.showResetForm');
    Route::get('/resetemail/{user_type}', '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')
        ->name('customers.showResetEmailForm');
    Route::post('/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset')
        ->name('customers.password.update');
});

//SOCIAL LOGIN
Route::get('login/{provider}', 'CustomerController@redirectToProvider');
Route::get('login/{provider}/callback', 'CustomerController@handleProviderCallback');


