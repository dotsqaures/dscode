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




Route::prefix('admin')->middleware('auth:admin')->namespace('Admin')->as('admin.')->group(function () {

    //dd("saas");

    Route::resources([
        'categories' => 'CategoriesManagerController',
    ]);


});
