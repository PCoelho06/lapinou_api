<?php

use App\Controllers\CorsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->options(
    '(:any)',
    'CorsController::handleOptions'
);

$routes->group("auth", function (RouteCollection $routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
});

$routes->group('v1', function (RouteCollection $routes) {
    $routes->resource('messages', ['controller' => 'MessageController', 'only' => ['index', 'show', 'create', 'delete']]);
    $routes->put('messages/(:segment)/read', 'MessageController::markAsRead/$1');
    $routes->put('messages/(:segment)/unread', 'MessageController::markAsUnread/$1');
    $routes->put('messages/(:segment)/answered', 'MessageController::markAsAnswered/$1');

    $routes->resource('articles', ['controller' => 'ArticleController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
    $routes->resource('categories', ['controller' => 'CategoryController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
});
