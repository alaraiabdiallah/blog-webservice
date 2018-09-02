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

$router->get('/test', 'TestController@index');
$router->get('/test/auth', 'TestController@authtest');

$router->post('login', 'AuthController@authenticate');

$router->group(['prefix' => 'users'], function () use ($router) {
    $controller = "UserController";
    $router->get('/', "$controller@index");
    $router->post('/', "$controller@store");
    $router->get('/{id}', "$controller@show");
    $router->patch('/{id}', "$controller@update");
    $router->delete('/{id}', "$controller@destroy");
});

require_once("blog.php");