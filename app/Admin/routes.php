<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/users', 'UsersController');
    $router->post('/goods', 'GoodsController@create');
    $router->resource('/goods', 'GoodsController');
    $router->get('/orders', 'OrdersController@index')->name('admin.orders.index');
    $router->get('/orders/{order}', 'OrdersController@show')->name('admin.orders.show');

    $router->post('/orders/{order}/ship', 'OrdersController@ship')->name('admin.orders.ship');


    $router->resource('/goods_attribute', 'GoodsAttributesController');
    $router->resource('/goods_category', 'GoodsCategoryController');

    $router->get('/api/goods_category', 'GoodsCategoryController@apiShow');
    $router->get('/api/goods_attribute', 'GoodsAttributesController@apiShow');
});
