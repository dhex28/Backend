<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->put('api/rooms/update/(:num)', 'RoomController::update/$1');
$routes->match(['post', 'get'],'/api/login', 'MainController::login');
$routes->match(['post', 'get'],'/api/register', 'MainController::register');
$routes->match(['post', 'get'], '/getData', 'MainController::getData');
$routes->post('/save', 'MainController::save');
$routes->match(['post', 'get'], '/amenitiesgetData', 'MainController::amenitiesgetData');
$routes->post('/amenitiesSave', 'MainController::amenitiesSave');
