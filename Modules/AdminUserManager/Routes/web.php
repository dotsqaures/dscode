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

// Route::prefix('admin')->group(function() {
// 	Route::get('/', 'AdminUserManagerController@login');
// 	Route::get('/dashboard', 'AdminUserManagerController@dashboard');
// });
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'as'=>'admin.'],function () {

	Route::get('/', function(){
		return redirect()->route('admin.login');
	});

	Auth::routes(['register'=> false]);

	/* Auth route group */
	Route::group(['middleware'=> 'auth:admin'], function(){
		/* Dashboard */
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/profile', 'AdminUsersController@edit')->name('profile');
        Route::post('/update', 'AdminUsersController@edit')->name('update');
        Route::patch('/update', 'AdminUsersController@update')->name('update-profile');
        /* Resource routes */
        Route::get('/change-password', 'AdminUsersController@showChangePasswordForm')->name('changepassword');
        Route::post('/update-password', 'AdminUsersController@changePassword')->name('updatepassword');
	});
});
