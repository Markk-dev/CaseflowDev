<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentication Routes
$routes->get('/', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerUser');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginUser');

// Dashboard and case management
$routes->get('dashboard', 'Dashboard::index');
$routes->get('cases/create', 'Dashboard::createCasePage'); // Form display
$routes->post('cases/create', 'Dashboard::createCase');    // Form submission
$routes->post('cases/edit/(:num)', 'Dashboard::editCase/$1');
$routes->post('cases/delete/(:num)', 'Dashboard::deleteCase/$1');

$routes->get('user/getUserData', 'UserController::getUserData');

//Edit Case Routes
$routes->get('cases/edit/(:num)', 'ConfigController::edit/$1');
$routes->post('cases/edit/(:num)', 'ConfigController::update/$1'); 

// Statistics Routes
$routes->get('statistics', 'StatisticsController::index');
$routes->get('api/case-data', 'StatisticsController::getCaseData');


$routes->get('complete', 'Dashboard::completedCases');
$routes->get('complete', 'ConfigController::completedCases');



