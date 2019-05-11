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
Auth::routes(['verify' => true]);
Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/user/addresses', 'UserAddressesController@index')->name('user.addresses.index');
    Route::post('/user/addresses', 'UserAddressesController@store')->name('user.addresses.store');
    Route::get('/user/addresses/create', 'UserAddressesController@create')->name('user.addresses.create');
    Route::get('/user/addresses/{id}/edit', 'UserAddressesController@edit')->name('user.addresses.edit');
    Route::put('/user/addresses/{id}', 'UserAddressesController@update')->name('user.addresses.update');
    Route::delete('/user/addresses/{id}', 'UserAddressesController@delete')->name('user.addresses.destroy');
});