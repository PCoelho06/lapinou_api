<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->resource('v1/messages', ['controller' => 'MessageController', 'only' => ['index', 'show', 'create', 'delete']]);
$routes->put('v1/messages/(:segment)/read', 'MessageController::markAsRead/$1');
$routes->put('v1/messages/(:segment)/answered', 'MessageController::markAsAnswered/$1');