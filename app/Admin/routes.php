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
    $router->resource('/goods', 'GoodsController');
    $router->resource('/goods_attribute', 'GoodsAttributesController');
    $router->resource('/goods_category', 'GoodsCategoryController');

    $router->get('/api/goods_category', 'GoodsCategoryController@apiShow');
});
