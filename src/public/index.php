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


$router->add('GET', '/student_dashboard', function() {
    require_once APP_PATH . '/Controllers/StudentDashboardController.php';
    $controller = new StudentDashboardController();
    $controller->index();
});


$router->add('GET', '/student_attendance', function() {
    require_once APP_PATH . '/Controllers/AttendanceController.php';
    $controller = new AttendanceController();
    $controller->index();
});


$router->add('GET', '/student_opportunities', function() {
    require_once APP_PATH . '/Controllers/OpportunitiesController.php';
    $controller = new OpportunitiesController();
    $controller->index();
});

$router->add('GET', '/student_reports', function() {
    require_once VIEW_PATH . '/student/student_reports.php';
});


$router->add('GET', '/student_apply', function() {
    require_once VIEW_PATH . '/student/student_apply.php';
});


$router->add('GET','/student_my-application', function(){
    require_once VIEW_PATH . '/student/student_my-application.php';
});


$router->add('GET','/student_opportunity-details', function(){
    require_once VIEW_PATH . '/student/student_opportunity-details.php';
});


$router->add('GET','/student_report-submit', function(){
    require_once VIEW_PATH . '/student/student_report-submit.php';
});



$router->add('POST', '/login_process', function() {
    require_once APP_PATH . '/Controllers/AuthController.php';
    $auth = new AuthController();
    $auth->login();
});


$router->add('POST', '/save_attendance', function() {
    require_once APP_PATH . '/Controllers/AttendanceController.php';
    $controller = new AttendanceController();
    $controller->save();
});

$router->run();