<?php 
// Blog route list
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

    $router->group(['prefix' => '/{post_id}/categories'], function () use ($router) {
        $controller = "PostCategoryController";
        $router->get('/', "$controller@index");
        $router->post('/', "$controller@store");
        $router->get('/{id}', "$controller@show");
        $router->delete('/{id}', "$controller@destroy");
        $router->delete('/', "$controller@destroy_all");
    });

    $router->group(['prefix' => '/{post_id}/tags'], function () use ($router) {
        $controller = "PostTagController";
        $router->get('/', "$controller@index");
        $router->post('/', "$controller@store");
        $router->get('/{id}', "$controller@show");
        $router->delete('/{id}', "$controller@destroy");
        $router->delete('/', "$controller@destroy_all");
    });

    $router->group(['prefix' => '/{post_id}/comments'], function () use ($router) {
        $controller = "CommentController";
        $router->get('/', "$controller@index");
        $router->post('/', "$controller@store");
        $router->get('/{id}', "$controller@show");
        $router->put('/{id}', "$controller@update");
        $router->delete('/{id}', "$controller@destroy");
        $router->delete('/', "$controller@destroy_all");
    });
});

