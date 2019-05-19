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
Route::get('/', 'PagesController@index')->name('root');

Auth::routes();

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/user/addresses', 'UserAddressesController@index')->name('user.addresses.index');
    Route::post('/user/addresses', 'UserAddressesController@store')->name('user.addresses.store');
    Route::get('/user/addresses/create', 'UserAddressesController@create')->name('user.addresses.create');
    Route::get('/user/addresses/{id}/edit', 'UserAddressesController@edit')->name('user.addresses.edit');
    Route::put('/user/addresses/{id}', 'UserAddressesController@update')->name('user.addresses.update');
    Route::delete('/user/addresses/{id}', 'UserAddressesController@delete')->name('user.addresses.destroy');

    Route::get('/goods/favorites', 'GoodsController@favorites')->name('goods.favor.index');
    Route::post('goods/{goods}/favorite', 'GoodsController@favor')->name('user.goods.favor');
    Route::delete('/goods/{goods}/favorite', 'GoodsController@disfavor')->name('user.goods.disfavor');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
});


Route::get('/goods', 'GoodsController@index')->name('goods.index');
Route::get('/goods/{id}', 'GoodsController@show')->name('goods.show');