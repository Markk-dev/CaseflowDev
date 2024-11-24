<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication routes
$routes->get('/', 'Auth::register');
$routes->post('register', 'Auth::registerUser');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginUser');

// Dashboard and case management
$routes->get('dashboard', 'Dashboard::index');
$routes->get('cases/create', 'Dashboard::createCasePage'); // Form display
$routes->post('cases/create', 'Dashboard::createCase');    // Form submission
$routes->post('cases/edit/(:num)', 'Dashboard::editCase/$1');
$routes->post('cases/delete/(:num)', 'Dashboard::deleteCase/$1');

$routes->get('/user/data', 'UserController::getUserData');
