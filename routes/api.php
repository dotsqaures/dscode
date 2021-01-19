<?php



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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::namespace('API')->group(function(){
    Route::post('login', 'UserController@login');
    Route::post('sendotp', 'UserController@sendotp');
    Route::post('verifyotp', 'UserController@verifyotp');
    Route::post('logout', 'UserController@logout');
    Route::post('stamp_list','UserController@stamp_list');
    Route::post('stamp_detail','UserController@stamp_detail');
    Route::post('mobile_pay','UserController@mobile_pay');

    Route::post('mystamp_list','UserController@mystamp_list');
    Route::post('redeem_stamp','UserController@redeem_stamp');
    Route::post('get_card','UserController@get_card');

    Route::post('pay_stripe','UserController@pay_stripe');
    Route::post('apple_pay','UserController@apple_pay');
    Route::post('ephemeralkeys','UserController@ephemeralkeys');

    Route::post('logindemo', 'UserController@logindemo');
    Route::post('apple_paydemo','UserController@apple_paydemo');
    Route::post('ephemeralkeysdemo','UserController@ephemeralkeysdemo');
    Route::get('restaurantlist','UserController@restaurantlist');



    Route::post('register', 'UserController@register');
    Route::post('verifyotptoken','UserController@verifyotptoken');
    Route::post('forgetPassword', 'UserController@forgetPassword');
    Route::post('ResetPassword', 'UserController@ResetPassword');
    Route::post('loginwithmobile','UserController@loginwithmobile');
    Route::post('resendotp','UserController@resendotp');
    Route::post('resendotpwithemail','UserController@resendotpwithemail');
    Route::post('sociallogin','UserController@sociallogin');

    Route::get('Productlist', 'ProductController@Productlist');
    Route::post('searchproduct', 'ProductController@searchproduct');
    Route::get('searchfilterbyitem', 'ProductController@searchfilterbyitem');
    Route::post('ProductDetail', 'ProductController@ProductDetail');
    Route::get('Categorylist', 'ProductController@Categorylist');
    Route::get('Devicelist', 'ProductController@Devicelist');

    Route::Post('SubDevicelist', 'ProductController@SubDevicelist');
    Route::get('alldevice','ProductController@alldevice');

    Route::post('brandlist','ProductController@brandlist');
    Route::post('modellist','ProductController@modellist');
    Route::post('colorlist','ProductController@colorlist');
    Route::post('storagelist','ProductController@storagelist');
    Route::get('carrierlist','ProductController@carrierlist');



});


    Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'API\UserController@details');
    Route::post('updaterole', 'API\UserController@updaterole');

    Route::post('updateprofile', 'API\UserController@updateprofile');
    Route::get('getprofile', 'API\UserController@getprofile');
    Route::post('changepassword', 'API\UserController@changepassword');

    Route::get('dashboard', 'API\UserController@dashboard');
    Route::post('addpaymentdetail', 'API\UserController@addpaymentdetail');
    Route::get('myproductlist', 'API\ProductController@myproductlist');
    Route::get('myInterestforbuyer', 'API\ProductController@myInterestforbuyer');
    Route::post('sellermessageforproduct', 'API\ProductController@sellermessageforproduct');
    Route::post('sentmessage', 'API\ProductController@sentmessage');
    Route::post('allmessage', 'API\ProductController@allmessage');
    Route::post('addtowatchlist', 'API\ProductController@addtowatchlist');
    Route::post('deleteproduct', 'API\ProductController@deleteproduct');

    Route::post('addaddress','API\UserController@addaddress');
    Route::get('getaddress','API\UserController@getaddress');


    /*-------------- Order --------------------*/

    Route::post('addtocart', 'API\ProductController@addtocart');
    Route::post('cart', 'API\ProductController@cart');
    Route::post('removeItemFormcart', 'API\ProductController@removeItemFormcart');
    Route::post('checkout' , 'API\ProductController@checkout');

    Route::post('addProductInRecentView' , 'API\ProductController@addProductInRecentView');
    Route::get('recentlist' , 'API\ProductController@recentlist');



    /*------------Add listing Api ----------------*/



    Route::post('AddStep1','API\ProductController@AddStep1');
    Route::post('AddStep2','API\ProductController@AddStep2');
    Route::post('AddStep3','API\ProductController@AddStep3');
    Route::post('AddStep4','API\ProductController@AddStep4');

    Route::get('featureData','API\ProductController@featureData');
    Route::post('makeitfeature','API\ProductController@makeitfeature');


    Route::get('myPurchaseOrder', 'API\ProductController@myPurchaseOrder');
    Route::get('mySellingOrder','API\ProductController@mySellingOrder');
    Route::post('orderDetail','API\ProductController@orderDetail');
    Route::post('ratting','API\ProductController@ratting');

    Route::post('orderUpdate','API\ProductController@orderUpdate');
    Route::post('returnOrder','API\ProductController@returnOrder');


    /*-------------- offer api --------------------*/
    Route::get('myPlacedOffer', 'API\OfferController@myPlacedOffer');
    Route::post('placedOfferDetail', 'API\OfferController@placedOfferDetail');


    Route::get('myReceivedOffer', 'API\OfferController@myReceivedOffer');
    Route::post('myReceivedOfferlist', 'API\OfferController@myReceivedOfferlist');
    Route::post('receivedOfferDetail', 'API\OfferController@receivedOfferDetail');

    Route::post('buyerOfferAction', 'API\OfferController@buyerOfferAction');
    Route::post('sellerOfferAction', 'API\OfferController@sellerOfferAction');

    Route::post('buyerOfferondetailpage','API\OfferController@buyerOfferondetailpage');

    Route::post('buyerOfferCounter','API\OfferController@buyerOfferCounter');
    Route::post('sellerOfferCounter','API\OfferController@sellerOfferCounter');


    Route::post('myrevenue','API\OfferController@myrevenue');






});
