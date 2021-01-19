<?php

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

Auth::routes();

Route::prefix('admin')->middleware('auth:admin')->namespace('Admin')->as('admin.')->group(function () {

    Route::GET('product/deleteimage/{id}','ProductController@deleteimage');



    Route::resources([
        'product' => 'ProductController',
    ]);

    Route::GET('product/accept/{id}', 'ProductController@accept')->name('product.accept');
    Route::GET('product/reject/{id}','ProductController@reject')->name('product.reject');

    Route::post('product/sentnotitifytoseller','ProductController@sentnotitifytoseller')->name('product.sentnotitifytoseller');

});


//Route::get('product/{id}', 'ProductManagerController@productDetail')->name('detail');
Route::get('product/{slug}', 'ProductManagerController@productDetail')->name('detail');
Route::get('product-others', 'ProductManagerController@others')->name('others');


Route::prefix('')->middleware('auth')->group(function () {


Route::get('addProduct', 'ProductManagerController@addProduct')->name('add_product');

Route::get('myInterest', 'ProductManagerController@myInterest')->name('my_interest');
Route::post('addPaypalDetails', 'ProductManagerController@addPaypalDetails')->name('addPaypalDetails');
Route::post('addnewProduct', 'ProductManagerController@addnewProduct');
Route::get('step2/{id}','ProductManagerController@step2');
Route::POST('addstep2','ProductManagerController@addstep2');

Route::get('accountupdate','ProductManagerController@accountupdate');
Route::get('editaddress','ProductManagerController@editaddress');
Route::POST('saveaddress','ProductManagerController@saveaddress');
Route::get('returnorder','ProductManagerController@returnorder');
Route::POST('returnrequest','ProductManagerController@returnrequest');

Route::get('editProduct/{id}', 'ProductManagerController@editProduct')->name('add_product');

Route::GET('deleteimage/{id}','ProductManagerController@deleteimage');
Route::GET('selectmodel/{id}','ProductManagerController@selectmodel');
Route::GET('checkimeinumber/{id}','ProductManagerController@checkimeinumber');
Route::GET('checkserialnumber/{id}','ProductManagerController@checkserialnumber');
Route::GET('selectmenufacturer/{id}','ProductManagerController@selectmenufacturer');
Route::GET('selectbrokendevice/{id}','ProductManagerController@selectbrokendevice');

Route::GET('selectcolor/{id}','ProductManagerController@selectcolor');
Route::GET('selectstorage/{id}','ProductManagerController@selectstorage');

Route::GET('getdevices/{id}','ProductManagerController@getdevices');

Route::GET('totalsellingprice/{price}','ProductManagerController@totalsellingprice');

Route::GET('deleteproduct/{id}','ProductManagerController@deleteproduct');

Route::patch('editnewProduct/{id}', 'ProductManagerController@editnewProduct');

Route::get('message/{id}', 'ProductManagerController@message');

Route::get('mymessage/{id}', 'ProductManagerController@mymessage');


Route::get('sellermessage/{id}/{senderid}', 'ProductManagerController@sellermessage');

Route::post('addnewmessage', 'ProductManagerController@addnewmessage')->name('message');

Route::post('addtowishlist', 'ProductManagerController@addtowishlist');

Route::get('recently-views', 'ProductManagerController@recentlyViews')->name('recently-views');

Route::GET('checkout', 'ProductManagerController@checkout');
Route::GET('paymentlink/{id}','ProductManagerController@paymentlink');
Route::POST('saveorder','ProductManagerController@saveorder');
Route::GET('thankyou/{id}', 'ProductManagerController@thankyou');

Route::get('myOrder', 'ProductManagerController@myOrder')->name('my_order');
Route::get('mySellingOrder','ProductManagerController@mySellingOrder')->name('my_selling_order');
Route::get('orderDetail/{id}','ProductManagerController@orderDetail')->name('order_detail');
Route::get('SellerOrderDetail/{id}','ProductManagerController@SellerOrderDetail')->name('selling_order_detail');
Route::POST('updateorderstatus','ProductManagerController@updateorderstatus');
Route::post('ratting','ProductManagerController@ratting');

Route::any('my-revenue','ProductManagerController@myRevenue');

});


Route::GET('addtocartproduct/{id}','ProductManagerController@addtocartproduct');

Route::GET('DirectCartPage/{id}','ProductManagerController@DirectCartPage');

Route::GET('cart', 'ProductManagerController@cart');

Route::GET('RemoveItemFromCart/{id}','ProductManagerController@RemoveItemFromCart');

Route::POST('shareurl','ProductManagerController@shareurl');

//sRoute::get('product/{product}/edit', 'ProductsController@edit')->name('admin.product.edit');


