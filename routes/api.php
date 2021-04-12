<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/pay', 'SslCommerzPaymentController@apiindex')->name('api.payment');

Route::prefix('v1')->group(function () {
    

    Route::get('sliders', 'ApiController@sliders');

    Route::get('shops', 'ApiController@shops');

    Route::get('new-arrivals', 'ApiController@new_arrivals');

    Route::get('shops/{id}', 'ApiController@shop_products');

    Route::get('featured-products', 'ApiController@featured_products');

    Route::get('similar-products/{shopId}', 'ApiController@similar_products');

    Route::get('search/{query}', 'ApiController@search_products');

    Route::get('tag/{tagName}', 'ApiController@tag_search');

    Route::get('wishlist', 'ApiController@wishlist');

    Route::post('wishlist', 'ApiController@add_wishlist');

    Route::post('wishlist/delete', 'ApiController@remove_wishlist');

    Route::get('amarcare', 'ApiController@amarcare');

    Route::post('filter-product', 'ApiController@filter_product');

    Route::get('random-product', 'ApiController@random_products');

    Route::get('sale', 'ApiController@sale_products');

    Route::get('deal', 'ApiController@deal_products');

    Route::post('my-account', 'ApiController@my_account');

    Route::post('my-account/update-account', 'ApiController@update_account');

    Route::post('my-account/update-address', 'ApiController@update_address');

    Route::get('filter-attributes', 'ApiController@filter_attributes');

    Route::post('login', 'ApiController@login');

    Route::post('social-login', 'ApiController@social_login');

    Route::post('logout', 'ApiController@logout');

    Route::post('register', 'ApiController@register');

    Route::post('cash-on-delivery', 'ApiController@cash_on_delivery');

    Route::post('online-payment', 'ApiController@online_payment');
    
    Route::post('pay-again', 'ApiController@pay_again');

    Route::post('product/rate', 'ApiController@rate_product');

    Route::post('coupon', 'ApiController@coupon');


});


