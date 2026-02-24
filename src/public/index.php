<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . '/views');
define('APP_PATH', BASE_PATH . '/app');

require_once APP_PATH . '/Core/Router.php';

$router = new Router();


$router->add('GET', '/', function() {
    require_once VIEW_PATH . '/auth/login.view.php';
});


$router->add('GET', '/login', function() {
    require_once VIEW_PATH . '/auth/login.view.php';
});


$router->add('GET', '/dashboard', function() {
    require_once VIEW_PATH . '/student/dashboard.php';
});


$router->add('GET', '/opportunities', function() {
    require_once VIEW_PATH . '/student/opportunities.php';
});

$router->add('GET', '/attendance', function() {
    require_once VIEW_PATH . '/student/attendance.php';
});

$router->add('GET', '/reports', function() {
    require_once VIEW_PATH . '/student/reports.php';
});

$router->add('GET', '/apply', function() {
    require_once VIEW_PATH . '/student/apply.php';
});

$router->run();