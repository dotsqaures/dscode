<?php

Auth::routes();

Route::prefix('admin')->middleware('auth:admin')->namespace('Admin')->as('admin.')->group(function() {
    Route::get('users/employee','UserManagerController@employee')->name('users.employee');

    Route::resources([
        'users' => 'UserManagerController',
    ]);


});

Route::get('users/password/reset/{token}', 'UserManagerController@showResetForm')->name('password-reset');
Route::get('verify/{token}', 'UserManagerController@verify')->name('verify-email');
Route::get('get-users', 'UserManagerController@getUsers')->name('get-users');
Route::get('otpverify', 'UserManagerController@otpverify')->name('otpverify');
Route::post('verifyotptoken','UserManagerController@verifyotptoken')->name('verifyotptoken');

Route::post('loginwithotp','UserManagerController@loginwithotp')->name('loginwithotp');
Route::get('resendotp', 'UserManagerController@resendotp');

Route::prefix('')->middleware('auth')->group(function () {

    Route::get('dashboard', 'DashboardController@dashboard')->name('dashboard');
    Route::get('profile', 'UserManagerController@profile')->name('profile');
    Route::patch('update-profile/{id}', 'UserManagerController@updateProfile')->name('update-profile');
    Route::get('change-password', 'UserManagerController@changePassword')->name('change-password');

    Route::get('add-payment-detail', 'UserManagerController@addPaymentDetail')->name('add-payment-detail');

    Route::post('update-account-stripe','UserManagerController@UpdateAccountStripe');

    Route::post('update-password', 'UserManagerController@profileChangePassword')->name('update-password');
    Route::get('logout', 'Auth\LoginController@logout');


    Route::GET('addrole/{roleid}','UserManagerController@addrole');

    Route::POST('featurepayment','UserManagerController@featurepayment');

    Route::get('user-dashboard', 'UserManagerController@userDashboard')->name('user-dashboard');

});

Route::get('auth/{provider}','Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback','Auth\LoginController@handleProviderCallback');
