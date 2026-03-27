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

$router->add('POST', '/login_process', function() {
    require_once APP_PATH . '/Controllers/AuthController.php';
    (new AuthController())->login();
});


$router->add('GET', '/student_dashboard', function() {
    require_once APP_PATH . '/Controllers/StudentDashboardController.php';
    (new StudentDashboardController())->index();
});


$router->add('GET', '/student_attendance', function() {
    require_once APP_PATH . '/Controllers/student_AttendanceController.php';
    (new student_AttendanceController())->index();
});

$router->add('POST', '/save_attendance', function() {
    require_once APP_PATH . '/Controllers/student_AttendanceController.php';
    (new student_AttendanceController())->save();
});


$router->add('GET', '/student_opportunities', function() {
    require_once APP_PATH . '/Controllers/student_OpportunitiesController.php';
    (new student_OpportunitiesController())->index();
});

$router->add('GET', '/student_opportunity-details', function(){
    require_once APP_PATH . '/Controllers/student_OpportunityDetailsController.php';
    (new student_OpportunityDetailsController())->index();
});

$router->add('GET', '/student_my-application', function(){
    require_once APP_PATH . '/Controllers/student_MyApplicationsController.php';
    (new student_MyApplicationsController())->index();
});

$router->add('GET', '/student_apply', function() {
    require_once APP_PATH . '/Controllers/student_ApplyController.php';
    (new student_ApplyController())->index();
});

$router->add('POST', '/submit_application', function() {
    require_once APP_PATH . '/Controllers/student_ApplyController.php';
    (new student_ApplyController())->submit();
});


$router->add('GET', '/student_reports', function() {
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController())->index();
});

$router->add('GET', '/student_report-submit', function(){
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController())->showSubmitForm(); 
});

$router->add('POST', '/submit_report_process', function() {
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController())->submit();
});


$router->add('GET', '/student_calendar', function() {
    require_once APP_PATH . '/Controllers/StudentCalendarController.php';
    (new StudentCalendarController())->index();
});


$router->add('GET', '/student_profile', function() {
    require_once APP_PATH . '/Controllers/student_ProfileController.php';
    (new student_ProfileController())->index();
});

$router->add('POST', '/update_profile_process', function() {
    require_once APP_PATH . '/Controllers/student_ProfileController.php';
    (new student_ProfileController())->update();
});


$router->add('GET', '/student_notifications', function() {
    require_once APP_PATH . '/Controllers/student_NotificationsController.php';
    (new student_NotificationsController())->index();
});

$router->add('GET', '/student_certificates', function() {
    require_once APP_PATH . '/Controllers/student_CertificatesController.php';
    (new student_CertificatesController())->index();
});


$router->run();