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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'FrontendController@index')->name('index');


Route::get('search-product', 'FrontendController@searchproduct')->name('search-product');
Route::get('searchresult','FrontendController@searchresult')->name('searchresult');


Route::get('search-productnew', 'FrontendController@searchproductnew')->name('search-productnew');


Route::get('search/{devicetype}', 'FrontendController@search');

Route::get('models/{slug}', 'FrontendController@models');

Route::get('brand/{slug}', 'FrontendController@brand');

Route::get('selectmodelforfilter/{slug}','FrontendController@selectmodelforfilter');


Route::get('paymenttransfer', 'FrontendController@paymenttransfer');

Route::get('checkfeature', 'FrontendController@checkfeature');

Route::group(['prefix'=>'devtesting'], function(){
		Route::get('/run-commands', function(){
			//\Artisan::call('cache:clear');
			//\Artisan::call('view:clear');
			//\Artisan::call('route:clear');
			\Artisan::call('storage:link');
		});
	});


