<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/process', 'Login::process');
//$routes->get('/dashboard', 'Home::index');
$routes->get('/add', 'AddUserController::index');
$routes->post('/adduser', 'AddUserController::register');

service('auth')->routes($routes);

//$routes->get('/', 'Dashboard::index');

$routes->group('dashboard', function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

$routes->group('expense', function ($routes) {
    $routes->get('/', 'Expense::index');
});

$routes->group('student', function ($routes) {
    $routes->get('/', 'Student::index');
    $routes->post('add', 'Student::add');
    $routes->get('list', 'Student::list');
    $routes->post('getStudents', 'Student::getStudents');
});

$routes->group('inquery', function ($routes) {
    $routes->get('/', 'Inquery::index');
});

$routes->group('settings', function ($routes) {
    $routes->get('/', 'Settings::index');
    $routes->post('add-center', 'Settings::addCenter');
    $routes->post('getCenters', 'Settings::getCenters');
    $routes->post('add-course', 'Settings::addCourse');
    $routes->post('getCourses', 'Settings::getCourses');
    $routes->post('update-course', 'Settings::updateCouse');
    $routes->post('add-district', 'Settings::addDidtrict');
    $routes->post('get-districts', 'Settings::getDistricts');
});
