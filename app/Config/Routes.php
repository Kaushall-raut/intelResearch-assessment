<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', 'Home::index');

// Authentication
$routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');


// Candidate
$routes->get('dashboard', 'Dashboard::index');
$routes->match(['get', 'post'], 'profile', 'Candidate::profile');
$routes->post('profile/resume', 'Candidate::uploadResume');
$routes->get('resume/(:num)', 'Candidate::resume/$1');

// HR
$routes->get('hr', 'HR::index');
$routes->get('hr/candidate/(:num)', 'HR::view/$1');
$routes->match(['get', 'post'], 'hr/candidate/(:num)/verify', 'HR::verify/$1');
$routes->match(['get', 'post'], 'hr/candidate/(:num)/interview', 'HR::interview/$1');