<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');

$routes->resource('v1/messages', ['controller' => 'MessageController', 'only' => ['index', 'show', 'create', 'delete']]);
$routes->put('v1/messages/(:segment)/read', 'MessageController::markAsRead/$1');
$routes->put('v1/messages/(:segment)/answered', 'MessageController::markAsAnswered/$1');

$routes->resource('v1/articles', ['controller' => 'ArticleController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
$routes->resource('v1/categories', ['controller' => 'CategoryController', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
