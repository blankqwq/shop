<?php

function route_class()
{
    return str_replace('.', '-', \Dingo\Api\Facade\Route::currentRouteName());
}