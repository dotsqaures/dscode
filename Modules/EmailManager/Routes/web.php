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

Route::prefix('admin')->middleware('auth:admin')->namespace('Admin')->as('admin.')->group(function() {
    Route::get('hooks', 'EmailHooksController@index')->name('hooks');
    Route::get('hooks/add', 'EmailHooksController@create')->name('add-hooks');
    Route::post('hooks/add', 'EmailHooksController@store')->name('save-hooks');
    Route::get('hooks/{email_hook}', 'EmailHooksController@show')->name('view-hooks');
    Route::get('hooks/edit/{id}', 'EmailHooksController@edit')->name('edit-hooks');
    Route::patch('hooks/edit/{id}', 'EmailHooksController@update')->name('edit-hooks');

    Route::resources([
        'email-preferences' => 'EmailPreferencesController',
        'email-templates' => 'EmailTemplatesController',
    ]);

});
