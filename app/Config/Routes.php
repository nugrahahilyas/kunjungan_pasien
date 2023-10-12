<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::pencarian');
$routes->get('/cari', 'PencarianController::index');
$routes->post('/cari', 'PencarianController::index');