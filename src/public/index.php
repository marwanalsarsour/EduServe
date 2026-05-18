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


$router->add('GET', '/supervisor_dashboard', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorDashboardController.php';
    (new SupervisorDashboardController())->index();
});

$router->add('GET', '/supervisor_profile', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController())->index();
});

$router->add('POST', '/update_supervisor_profile_process', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController())->update();
});

$router->add('POST', '/update_supervisor_password_process', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController())->changePassword();
});

$router->add('GET', '/supervisor-add-opportunity', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->create();
});


$router->add('POST', '/submit_opportunity_process', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->store();
});

$router->add('GET', '/supervisor-applications', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ApplicationController.php';
    (new ApplicationController())->index();
});


$router->add('POST', '/submit_application_action', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ApplicationController.php';
    (new ApplicationController())->handleAction();
});

$router->add('GET', '/supervisor-attendance', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/AttendanceReviewController.php';
    (new AttendanceReviewController())->index();
});

$router->add('POST', '/submit_attendance_review_action', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/AttendanceReviewController.php';
    (new AttendanceReviewController())->handleAction();
});

$router->add('GET', '/supervisor-edit-opportunity', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->edit();
});

$router->add('POST', '/submit_update_opportunity_process', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->update();
});

$router->add('GET', '/supervisor-employer-reports', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/CompanyReportController.php';
    (new CompanyReportController())->index();
});

$router->add('GET', '/supervisor/supervisor-evaluation', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/EvaluationController.php';
    (new EvaluationController())->create();
});

$router->add('POST', '/submit_save_evaluation_process', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/EvaluationController.php';
    (new EvaluationController())->store();
});

$router->add('GET', '/supervisor/notifications', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/NotificationController.php';
    (new NotificationController())->index();
});

$router->add('GET', '/supervisor/notifications/mark-read', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/NotificationController.php';
    (new NotificationController())->markAllAsRead();
});


$router->add('GET', '/supervisor/opportunities', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->index();
});


$router->add('GET', '/supervisor/delete-opportunity/:id', function($id) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->delete($id);
});

$router->add('GET', '/supervisor/supervisor-reports', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ReportReviewController.php';
    (new ReportReviewController())->index();
});

$router->add('POST', '/supervisor/reports/process/:id', function($id) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ReportReviewController.php';
    (new ReportReviewController())->process($id);
});

$router->add('GET', '/supervisor/student-profile/:id', function($id) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/StudentProfileController.php';
    (new StudentProfileController())->show($id);
});

$router->add('GET', '/supervisor/students', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/StudentManagementController.php';
    (new StudentManagementController())->index();
});

$router->add('GET', '/volunteer_dashboard', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerDashboardController.php';
    (new VolunteerDashboardController())->index();
});

$router->add('GET', '/volunteer_approval', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApprovalController.php';
    (new VolunteerApprovalController())->index();
});

$router->add('POST', '/volunteer_save_approval', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApprovalController.php';
    (new VolunteerApprovalController())->save();
});

$router->add('GET', '/volunteer_attendance', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerAttendanceController.php';
    (new VolunteerAttendanceController())->index();
});

$router->add('POST', '/volunteer_attendance_approve', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerAttendanceController.php';
    (new VolunteerAttendanceController())->approve();
});

$router->add('GET', '/volunteer_employer_reports', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerReportsController.php';
    (new VolunteerReportsController())->index();
});


$router->add('GET', '/volunteer_evaluation', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerGradingController.php';
    (new VolunteerGradingController())->index();
});


$router->add('POST', '/volunteer_submit_grading', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerGradingController.php';
    (new VolunteerGradingController())->submit();
});

$router->add('GET', '/volunteer_notifications', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerNotificationController.php';
    (new VolunteerNotificationController())->index();
});

$router->add('GET', '/volunteer_opportunities', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController())->index();
});

$router->add('POST', '/store_opportunity', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController())->store();
});

$router->add('GET', '/volunteer_edit_opportunity', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    $id = $_GET['id'] ?? null; 
    (new VolunteerOpportunityController())->edit($id);
});

$router->add('POST', '/volunteer_update_opportunity', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController())->update();
});

$router->add('GET', '/delete_opportunity', function() {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    $id = $_GET['id'] ?? null;
    (new VolunteerOpportunityController())->delete($id);
});

$router->add('GET', '/volunteer_profile', function() {
    require_once APP_PATH . '/Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController())->index();
});

$router->add('POST', '/volunteer_profile_update', function() {
    require_once APP_PATH . '/Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController())->update();
});

$router->add('POST', '/volunteer_password_update', function() {
    require_once APP_PATH . '/Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController())->changePassword();
});

$router->add('GET', '/volunteer_requests', function() {
    require_once APP_PATH . '/Controllers/VolunteerApplicationController.php';
    (new VolunteerApplicationController())->index();
});

$router->add('GET', '/handle_application', function() {
    require_once APP_PATH . '/Controllers/VolunteerApplicationController.php';
    (new VolunteerApplicationController())->handleStatus();
});

$router->add('GET', '/volunteer_students', function() {
    require_once APP_PATH . '/Controllers/VolunteerStudentController.php';
    (new VolunteerStudentController())->index();
});

$router->add('GET', '/volunteer_view_student', function() {
    require_once APP_PATH . '/Controllers/StudentReviewController.php';
    (new StudentReviewController())->show();
});

$router->add('POST', '/student_review/process', function() {
    require_once APP_PATH . '/Controllers/StudentReviewController.php';
    (new StudentReviewController())->process();
});

$router->add('GET', '/external_dashboard', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalDashboardController.php';
    (new ExternalDashboardController())->index();
});

$router->add('GET', '/external/applications', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController())->index();
});

$router->add('POST', '/applications/approve', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController())->approve();
});

$router->add('POST', '/applications/reject', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController())->reject();
});

$router->add('GET', '/external/opportunities', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController())->index();
});

$router->add('POST', '/external/opportunities/update', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController())->update();
});

$router->add('POST', '/external/opportunities/delete', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController())->delete();
});

$router->add('GET', '/external/opportunities/add', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController())->create();
});

$router->add('POST', '/external/opportunities/store', function() {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController())->store();
});

$router->add('GET', '/external/certificates', function() {
    (new ExternalCertificatesController())->index();
});

$router->add('POST', '/external/certificates/store', function() {
    (new ExternalCertificatesController())->store();
});

$router->add('GET', '/external/officials', function() {
    (new ExternalOfficialsController())->index();
});

$router->add('POST', '/external/officials/update', function() {
    (new ExternalOfficialsController())->update();
});

$router->add('POST', '/external/officials/assign', function() {
    (new ExternalOfficialsController())->assign();
});

$router->add('GET', '/external/officials/unassign/(\d+)', function($student_id) {
    (new ExternalOfficialsController())->unassign($student_id);
});

$router->add('GET', '/external/trainees', function() {
    require_once '../src/controllers/ExternalTraineesController.php';
    (new ExternalTraineesController())->index();
});

$router->add('GET', '/external/trainers', function() {
    require_once '../src/controllers/ExternalTrainersController.php';
    (new ExternalTrainersController())->index();
});

$router->add('POST', '/assign-student', function() {
    require_once '../src/controllers/ExternalTrainersController.php';
    (new ExternalTrainersController())->assign();
});

$router->add('POST', '/update-trainer', function() {
    require_once '../src/controllers/ExternalTrainersController.php';
    (new ExternalTrainersController())->update(); 
});

$router->add('GET', '/external/notifications', function() {
    require_once '../src/controllers/ExternalNotificationsController.php';
    (new ExternalNotificationsController())->index();
});
$router->add('GET', '/trainer/dashboard', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerDashboardController.php';
    (new TrainerDashboardController())->index();
});

$router->add('GET', '/trainer/profile', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerProfileController.php';
    (new TrainerProfileController())->index();
});

$router->add('POST', '/trainer/profile/update', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerProfileController.php';
    (new TrainerProfileController())->update();
});

$router->add('GET', '/trainer/attendance', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerAttendanceController.php';
    (new TrainerAttendanceController())->index();
});

$router->add('POST', '/trainer/attendance/save', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerAttendanceController.php';
    (new TrainerAttendanceController())->save();
});

$router->add('GET', '/trainer/reports', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController())->index();
});

$router->add('POST', '/trainer/reports/process-monthly', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController())->processMonthly();
});

$router->add('POST', '/trainer/reports/process-final', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController())->processFinal();
});

$router->add('GET', '/trainer/student-details/(\d+)', function($student_id) {
    require_once '../src/controllers/Trainer_Controllers/TrainerStudentDetailsController.php';
    (new TrainerStudentDetailsController())->show($student_id);
});

$router->add('GET', '/trainer/notifications', function() {
    require_once '../src/controllers/Trainer_Controllers/TrainerNotificationsController.php';
    (new TrainerNotificationsController())->index();
});

$router->add('GET', '/v_manager/dashboard', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerDashboardController.php';
    (new VManagerDashboardController())->index();
});

$router->add('GET', '/v_manager/profile', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerProfileController.php';
    (new VManagerProfileController())->index();
});

$router->add('POST', '/v_manager/profile/update', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerProfileController.php';
    (new VManagerProfileController())->update();
});

$router->add('GET', '/v_manager/volunteers', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerVolunteersController.php';
    (new VManagerVolunteersController())->index();
});

$router->add('GET', '/v_manager/student-details', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerStudentDetailsController.php';
    (new VManagerStudentDetailsController())->index();
});

$router->add('GET', '/v_manager/reports', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerReportsController.php';
    (new VManagerReportsController())->index();
});

$router->add('GET', '/v_manager/attendance', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerAttendanceController.php';
    (new AttendanceController())->index();
});

$router->add('POST', '/v_manager/attendance/save', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerAttendanceController.php';
    (new AttendanceController())->save();
});

$router->add('GET', '/v_manager/notifications', function() {
    require_once '../src/controllers/V_Manager_Controllers/VManagerNotificationController.php';
    (new NotificationController())->index();
});
$router->run();