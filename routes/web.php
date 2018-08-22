<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'tags'], function () use ($router) {
    $controller = "TagsController";
    $router->get('/', "$controller@index");
    $router->post('/', "$controller@store");
    $router->get('/{id}', "$controller@show");
    $router->put('/{id}', "$controller@update");
    $router->delete('/{id}', "$controller@destroy");
});

$router->group(['prefix' => 'categories'], function () use ($router) {
    $controller = "CategoryController";
    $router->get('/', "$controller@index");
    $router->post('/', "$controller@store");
    $router->get('/{id}', "$controller@show");
    $router->put('/{id}', "$controller@update");
    $router->delete('/{id}', "$controller@destroy");
});

$router->group(['prefix' => 'posts'], function () use ($router) {
    $controller = "PostController";
    $router->get('/', "$controller@index");
    $router->post('/', "$controller@store");
    $router->get('/{id}', "$controller@show");
    $router->put('/{id}', "$controller@update");
    $router->delete('/{id}', "$controller@destroy");
});

