<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group("auth", function (RouteCollection $routes) {
    $routes->post('auth/register', 'AuthController::register');
    $routes->post('auth/login', 'AuthController::login');
});

$routes->group('v1', function (RouteCollection $routes) {
    $routes->resource('messages', ['controller' => 'MessageController', 'only' => ['index', 'show', 'create', 'delete']]);
    $routes->put('messages/(:segment)/read', 'MessageController::markAsRead/$1');
    $routes->put('messages/(:segment)/answered', 'MessageController::markAsAnswered/$1');

    $routes->resource('articles', ['controller' => 'ArticleController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
    $routes->resource('categories', ['controller' => 'CategoryController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
});
