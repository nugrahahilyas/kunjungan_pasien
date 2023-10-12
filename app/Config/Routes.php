<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::pencarian');
$routes->get('/', 'PencarianController::index');
$routes->post('/', 'PencarianController::index');