<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->options(
    '(:any)',
    function () {
        return service('response')
            ->setStatusCode(200)
            ->setHeader('Access-Control-Allow-Origin', '*') // Ajuster les origines si nécessaire
            ->send();
    }
);

$routes->group("auth", function (RouteCollection $routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
});

$routes->group('v1', function (RouteCollection $routes) {
    $routes->resource('messages', ['controller' => 'MessageController', 'only' => ['index', 'show', 'create', 'delete']]);
    $routes->put('messages/(:segment)/read', 'MessageController::markAsRead/$1');
    $routes->put('messages/(:segment)/answered', 'MessageController::markAsAnswered/$1');

    $routes->resource('articles', ['controller' => 'ArticleController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
    $routes->resource('categories', ['controller' => 'CategoryController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
});
