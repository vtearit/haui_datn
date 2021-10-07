<?php

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

Route::get('/delete', function () {
    Session::flush();
});
Route::get('/', 'App\Http\Controllers\User\PageController@homePage');
Route::get('test', 'App\Http\Controllers\User\PageController@test');

//login
Route::get('dang-nhap', 'App\Http\Controllers\Controller@getLogin')->middleware('checkLogin');
Route::post('dang-nhap', 'App\Http\Controllers\Controller@postLogin');
Route::get('/dang-ki', 'App\Http\Controllers\Controller@getSignIn');
Route::post('/dang-ki', 'App\Http\Controllers\Controller@postSignIn')->middleware('checkLogin');
Route::get('dang-xuat', 'App\Http\Controllers\Controller@logout');
Route::get('/verify/{id}', 'App\Http\Controllers\Controller@verify')->name('verify');
Route::get('quen-mat-khau', 'App\Http\Controllers\Controller@forgotPW');
Route::post('quen-mat-khau', 'App\Http\Controllers\Controller@postForgotPW');
Route::post('nhap-email', 'App\Http\Controllers\Controller@inputEmail');
Route::get('xac-nhan-quen-mat-khau/{id}', 'App\Http\Controllers\Controller@verifyPW')->name('verifyPW');

Route::get('cap-nhat-thong-tin', 'App\Http\Controllers\User\AccountController@editProfile');
Route::post('cap-nhat-thong-tin/{id}', 'App\Http\Controllers\User\AccountController@postEditProfile');
Route::get('doi-mat-khau', 'App\Http\Controllers\User\AccountController@changePW');
Route::post('doi-mat-khau', 'App\Http\Controllers\User\AccountController@postChangePW');

Route::get('danh-muc/{slug_category}', 'App\Http\Controllers\User\PageController@productPage');
Route::get('chi-tiet/{slug_product}', 'App\Http\Controllers\User\PageController@productDetails');
Route::post('tat-ca-san-pham', 'App\Http\Controllers\User\PageController@allProduct');
Route::post('thay-doi-san-pham', 'App\Http\Controllers\User\PageController@changeProduct');
Route::post('/san-pham/sort', 'App\Http\Controllers\User\PageController@sort');

Route::get('/ajax/group_product/{id}', 'App\Http\Controllers\AjaxController@groupProduct');
Route::post('tat-ca-binh-luan', 'App\Http\Controllers\User\PageController@allComment');
Route::post('binh-luan', 'App\Http\Controllers\User\PageController@postComment');
Route::post('sua-binh-luan', 'App\Http\Controllers\User\PageController@editComment');
Route::post('hoan-thanh-sua-binh-luan', 'App\Http\Controllers\User\PageController@commitComment');
Route::post('xoa-binh-luan', 'App\Http\Controllers\User\PageController@deleteComment');


//gio gio-hang
Route::get('gio-hang', 'App\Http\Controllers\User\CartController@show_cart');
Route::post('them-gio-hang', 'App\Http\Controllers\User\CartController@add_to_cart');
Route::post('gio-hang/cap-nhat', 'App\Http\Controllers\User\CartController@update_quantity');
Route::post('gio-hang/xoa', 'App\Http\Controllers\User\CartController@delete');
Route::get('gio-hang/qty/up/{rowId}/{id}/{qty}', 'App\Http\Controllers\User\CartController@qty_up');
Route::get('gio-hang/qty/down/{rowId}/{id}/{qty}', 'App\Http\Controllers\User\CartController@qty_down');

//checkout
Route::get('thanh-toan', 'App\Http\Controllers\User\CheckOutController@checkout');
Route::get('thanh-toan/quan-huyen/{id}', 'App\Http\Controllers\User\CheckOutController@quan_huyen');
Route::get('thanh-toan/xa-phuong/{id}', 'App\Http\Controllers\User\CheckOutController@xa_phuong');
Route::post('xac-nhan-dia-chi', 'App\Http\Controllers\User\CheckOutController@confirm_shipping')->middleware('userLogin');
Route::post('dat-mua', 'App\Http\Controllers\User\CheckOutController@buying');
Route::get('/don-hang', 'App\Http\Controllers\User\CheckOutController@view_order');
Route::post('huy-don-hang', 'App\Http\Controllers\User\CheckOutController@cancelOrder');

//tim kiem
Route::post('/tim-kiem', 'App\Http\Controllers\User\PageController@search');

//doi diem thuong
Route::get('doi-diem-thuong', 'App\Http\Controllers\User\CouponController@getPoint');
Route::post('doi-diem-thuong', 'App\Http\Controllers\User\CouponController@postPoint');
Route::get('ma-giam-gia-cua-ban', 'App\Http\Controllers\User\CouponController@yourCoupon');
Route::get('ma-giam-gia', 'App\Http\Controllers\User\CouponController@allCoupon');
Route::post('ma-giam-gia', 'App\Http\Controllers\User\CouponController@check');
Route::get('ma-giam-gia/{id}', 'App\Http\Controllers\User\CouponController@Cancel');

//admin ,'middleware'=>'adminLogin'
Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function () {
    Route::get('/dashboard', 'App\Http\Controllers\Admin\PageController@dashboard');
    Route::get('/', 'App\Http\Controllers\Admin\PageController@dashboard');

    //dashboard
    Route::post('/loc', 'App\Http\Controllers\Admin\DashboardController@filter');
    Route::post('/thang', 'App\Http\Controllers\Admin\DashboardController@filterMonth');
    Route::post('/box', 'App\Http\Controllers\Admin\DashboardController@box');
    Route::post('/sell-product', 'App\Http\Controllers\Admin\DashboardController@sellProduct');

    //category admin
    Route::get('/danh-muc/hien-thi', 'App\Http\Controllers\Admin\CategoryController@index');
    Route::get('/danh-muc/them', 'App\Http\Controllers\Admin\CategoryController@create');
    Route::post('/danh-muc/them', 'App\Http\Controllers\Admin\CategoryController@store');
    Route::get('/danh-muc/sua/{id}', 'App\Http\Controllers\Admin\CategoryController@edit');
    Route::post('/danh-muc/sua/{id}', 'App\Http\Controllers\Admin\CategoryController@update');
    Route::post('/danh-muc/xoa', 'App\Http\Controllers\Admin\CategoryController@destroy');
    Route::post('/danh-muc/cap-nhat-trang-thai', 'App\Http\Controllers\Admin\CategoryController@updateStatus');

    //product admin
    Route::get('/san-pham/hien-thi', 'App\Http\Controllers\Admin\ProductController@index');
    Route::get('/san-pham/them', 'App\Http\Controllers\Admin\ProductController@create');
    Route::post('/san-pham/them', 'App\Http\Controllers\Admin\ProductController@store');
    Route::get('/san-pham/sua/{id}', 'App\Http\Controllers\Admin\ProductController@edit');
    Route::post('san-pham/sua/{id}', 'App\Http\Controllers\Admin\ProductController@update');
    Route::get('/san-pham/xoa/{id}', 'App\Http\Controllers\Admin\ProductController@destroy');
    Route::get('/san-pham/giam-gia', 'App\Http\Controllers\Admin\ProductController@discount');
    Route::post('/san-pham/giam-gia', 'App\Http\Controllers\Admin\ProductController@postDiscount');

    //group product admin
    Route::get('/nhom-san-pham/hien-thi', 'App\Http\Controllers\Admin\GroupProductController@index');
    Route::get('/nhom-san-pham/them', 'App\Http\Controllers\Admin\GroupProductController@create');
    Route::post('/nhom-san-pham/them', 'App\Http\Controllers\Admin\GroupProductController@store');
    Route::get('/nhom-san-pham/sua/{id}', 'App\Http\Controllers\Admin\GroupProductController@edit');
    Route::post('nhom-san-pham/sua/{id}', 'App\Http\Controllers\Admin\GroupProductController@update');
    Route::get('/nhom-san-pham/xoa/{id}', 'App\Http\Controllers\Admin\GroupProductController@destroy');
    Route::get('/nhom-san-pham/giam-gia', 'App\Http\Controllers\Admin\GroupProductController@discount');
    Route::post('/nhom-san-pham/giam-gia', 'App\Http\Controllers\Admin\GroupProductController@postDiscount');

    //slider admin
    Route::get('/slider/hien-thi', 'App\Http\Controllers\Admin\SliderController@index');
    Route::get('/slider/them', 'App\Http\Controllers\Admin\SliderController@create');
    Route::post('/slider/them', 'App\Http\Controllers\Admin\SliderController@store');
    Route::get('/slider/sua/{id}', 'App\Http\Controllers\Admin\SliderController@edit');
    Route::post('/slider/sua/{id}', 'App\Http\Controllers\Admin\SliderController@update');
    Route::get('/slider/xoa/{id}', 'App\Http\Controllers\Admin\SliderController@destroy');


    // //notification
    // Route::get('/thong-bao', 'App\Http\Controllers\NotificationController@notification');

    //order
    Route::get('/don-hang/don-hang-moi', 'App\Http\Controllers\Admin\OrderController@newOrder');
    Route::get('/don-hang/don-hang-dang-giao', 'App\Http\Controllers\Admin\OrderController@shippingOrder');
    Route::get('/don-hang/xac-nhan/{id}', 'App\Http\Controllers\Admin\OrderController@confirmOrder');
    Route::get('/don-hang/hoan-thanh/{id}', 'App\Http\Controllers\Admin\OrderController@successOrder');
    Route::get('/don-hang/don-hang-huy', 'App\Http\Controllers\Admin\OrderController@cancelOrder');
    Route::get('/don-hang/huy-don-hang/{id}/{status}', 'App\Http\Controllers\Admin\OrderController@cancel');
    Route::get('/don-hang/don-hang-da-giao', 'App\Http\Controllers\Admin\OrderController@order');
    Route::post('/don-hang/xac-nhan', 'App\Http\Controllers\Admin\OrderController@confirmOrderPost');
    Route::get('/don-hang/chi-tiet/{id}', 'App\Http\Controllers\Admin\OrderController@detail');
    Route::get('/don-hang/in-hoa-don/{id}', 'App\Http\Controllers\Admin\OrderController@print');
    Route::get('/pdfview/{id}', 'App\Http\Controllers\Admin\OrderController@pdfview');
    Route::get('/don-hang/moi', 'App\Http\Controllers\Admin\OrderController@inMonth');

    //coupon
    Route::get('/ma-giam-gia/hien-thi', 'App\Http\Controllers\Admin\CouponController@index');
    Route::get('/ma-giam-gia/them', 'App\Http\Controllers\Admin\CouponController@create');
    Route::post('/ma-giam-gia/them', 'App\Http\Controllers\Admin\CouponController@store');
    Route::get('/ma-giam-gia/sua/{id}', 'App\Http\Controllers\Admin\CouponController@edit');
    Route::post('/ma-giam-gia/sua/{id}', 'App\Http\Controllers\Admin\CouponController@update');
    Route::get('/ma-giam-gia/xoa/{id}', 'App\Http\Controllers\Admin\CouponController@destroy');

    //user
    Route::get('/khach-hang', 'App\Http\Controllers\Admin\UserController@index');
    Route::get('/khach-hang/them', 'App\Http\Controllers\Admin\UserController@create');
    Route::post('/khach-hang/them', 'App\Http\Controllers\Admin\UserController@store');
    Route::get('/khach-hang/sua/{id}', 'App\Http\Controllers\Admin\UserController@edit');
    Route::post('/khach-hang/sua/{id}', 'App\Http\Controllers\Admin\UserController@update');
    Route::get('khach-hang/xoa/{id}', 'App\Http\Controllers\Admin\UserController@destroy');

     //user
     Route::get('/ship', 'App\Http\Controllers\Admin\ShippingController@index');
     Route::get('/ship/them', 'App\Http\Controllers\Admin\ShippingController@create');
     Route::post('/ship/them', 'App\Http\Controllers\Admin\ShippingController@store');
     Route::get('/ship/sua/{id}', 'App\Http\Controllers\Admin\ShippingController@edit');
     Route::post('/ship/sua/{id}', 'App\Http\Controllers\Admin\ShippingController@update');
     Route::get('ship/xoa/{id}', 'App\Http\Controllers\Admin\ShippingController@destroy');
    // //thumbnail
    // Route::get('/thumbnail/them','App\Http\Controllers\ThumbnailController@create');
    //  Route::post('/thumbnail/them', 'App\Http\Controllers\ThumbnailController@store');

    // //filter
    // Route::post('/loc', 'App\Http\Controllers\AdminController@filter');
    // Route::post('/thang', 'App\Http\Controllers\AdminController@filterMonth');
    // Route::post('/box', 'App\Http\Controllers\AdminController@box');
});
