<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . '/views');
define('APP_PATH', BASE_PATH . '/app');

require_once APP_PATH . '/Core/Router.php';
require_once APP_PATH . '/Core/Database.php';

$database = new Database();
$db = $database->getConnection();
$router = new Router();


$router->add('GET', '/', function() {
    require_once VIEW_PATH . '/auth/login.view.php';
});

$router->add('GET', '/login', function() {
    require_once VIEW_PATH . '/auth/login.view.php';
});

$router->add('POST', '/login_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/AuthController.php';
    (new AuthController($db))->login();
});

$router->add('GET', '/student_dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/StudentDashboardController.php';
    (new StudentDashboardController($db))->index();
});

$router->add('GET', '/student_attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/sudent_AttendanceController.php';
    (new student_AttendanceController($db))->index();
});

$router->add('POST', '/save_attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/sudent_AttendanceController.php';
    (new student_AttendanceController($db))->save();
});

$router->add('GET', '/student_opportunities', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_OpportunitiesController.php';
    (new student_OpportunitiesController($db))->index();
});

$router->add('GET', '/student_opportunity-details', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_OpportunityDetailsController.php';
    (new student_OpportunityDetailsController($db))->index();
});

$router->add('GET', '/student_my-application', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_MyApplicationsController.php';
    (new student_MyApplicationsController($db))->index();
});

$router->add('GET', '/student_apply', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ApplyController.php';
    (new student_ApplyController($db))->index();
});

$router->add('POST', '/submit_application', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ApplyController.php';
    (new student_ApplyController($db))->submit();
});

$router->add('GET', '/student_reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController($db))->index();
});

$router->add('GET', '/student_report-submit', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController($db))->showSubmitForm(); 
});

$router->add('POST', '/submit_report_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ReportsController.php';
    (new student_ReportsController($db))->submit();
});

$router->add('GET', '/student_calendar', function() use ($db) {
    require_once APP_PATH . '/Controllers/StudentCalendarController.php';
    (new StudentCalendarController($db))->index();
});

$router->add('GET', '/student_profile', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ProfileController.php';
    (new student_ProfileController($db))->index();
});

$router->add('POST', '/update_profile_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_ProfileController.php';
    (new student_ProfileController($db))->update();
});

$router->add('GET', '/student_notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_NotificationsController.php';
    (new student_NotificationsController($db))->index();
});
$router->add('GET', '/student_Portfolio', function() use ($db) {
    require_once APP_PATH . '/Controllers/student_PortfolioController.php';
    (new student_PortfolioController($db))->index();
});
$router->add('GET', '/external/student-portfolio/{id}', function($id) use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalStudentPortfolioController.php';
    (new ExternalStudentPortfolioController($db))->show($id);
});

$router->add('GET', '/supervisor_dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorDashboardController.php';
    (new SupervisorDashboardController($db))->index();
});

$router->add('GET', '/supervisor_profile', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController($db))->index();
});

$router->add('POST', '/update_supervisor_profile_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController($db))->update();
});

$router->add('POST', '/update_supervisor_password_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/SupervisorProfileController.php';
    (new SupervisorProfileController($db))->changePassword();
});

$router->add('GET', '/supervisor-add-opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController($db))->create();
});

$router->add('POST', '/submit_opportunity_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController($db))->store();
});

$router->add('GET', '/supervisor-applications', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ApplicationController.php';
    (new ApplicationController($db))->index();
});

$router->add('POST', '/submit_application_action', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ApplicationController.php';
    (new ApplicationController($db))->handleAction();
});

$router->add('GET', '/supervisor-attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/AttendanceReviewController.php';
    (new AttendanceReviewController($db))->index();
});

$router->add('POST', '/submit_attendance_review_action', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/AttendanceReviewController.php';
    (new AttendanceReviewController($db))->handleAction();
});

$router->add('GET', '/supervisor-edit-opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController($db))->edit();
});

$router->add('POST', '/submit_update_opportunity_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController($db))->update();
});

$router->add('GET', '/supervisor-employer-reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/CompanyReportController.php';
    (new CompanyReportController($db))->index();
});

$router->add('GET', '/supervisor/supervisor-evaluation', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/EvaluationController.php';
    (new EvaluationController($db))->create();
});

$router->add('POST', '/submit_save_evaluation_process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/EvaluationController.php';
    (new EvaluationController($db))->store();
});

$router->add('GET', '/supervisor/notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/NotificationController.php';
    (new NotificationController($db))->index();
});

$router->add('GET', '/supervisor/notifications/mark-read', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/NotificationController.php';
    (new NotificationController($db))->markAllAsRead();
});

$router->add('GET', '/supervisor/opportunities', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController($db))->index();
});

$router->add('GET', '/supervisor/delete-opportunity', function() {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/OpportunityController.php';
    (new OpportunityController())->delete($_GET['id']);
});

$router->add('GET', '/supervisor/supervisor-reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ReportReviewController.php';
    (new ReportReviewController($db))->index();
});

$router->add('POST', '/supervisor/reports/process/:id', function($id) use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/ReportReviewController.php';
    (new ReportReviewController($db))->process($id);
});

$router->add('GET', '/supervisor/student-profile/:id', function($id) use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/StudentProfileController.php';
    (new StudentProfileController($db))->show($id);
});

$router->add('GET', '/supervisor/students', function() use ($db) {
    require_once APP_PATH . '/Controllers/Training_Supervisor_Controllers/StudentManagementController.php';
    (new StudentManagementController($db))->index();
});
$router->add('GET', '/supervisor_evaluation_criteria', function() use ($db) {

    require_once APP_PATH .
    '/Controllers/Training_Supervisor_Controllers/SupervisorEvaluationCriteriaController.php';

    (new SupervisorEvaluationCriteriaController($db))->index();
});
$router->add('POST', '/supervisor_evaluation_criteria/add', function() use ($db) {

    require_once APP_PATH .
    '/Controllers/Training_Supervisor_Controllers/SupervisorEvaluationCriteriaController.php';

    (new SupervisorEvaluationCriteriaController($db))->add();
});
$router->add('POST', '/supervisor_evaluation_criteria/update', function() use ($db) {

    require_once APP_PATH .
    '/Controllers/Training_Supervisor_Controllers/SupervisorEvaluationCriteriaController.php';

    (new SupervisorEvaluationCriteriaController($db))->update();
});
$router->add('GET', '/supervisor_evaluation_criteria/delete', function() use ($db) {

    require_once APP_PATH .
    '/Controllers/Training_Supervisor_Controllers/SupervisorEvaluationCriteriaController.php';

    $id = $_GET['id'] ?? 0;

    (new SupervisorEvaluationCriteriaController($db))->delete($id);
});

$router->add('GET', '/volunteer_dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerDashboardController.php';
    (new VolunteerDashboardController($db))->index();
});

$router->add('GET', '/volunteer_approval', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApprovalController.php';
    (new VolunteerApprovalController($db))->index();
});

$router->add('POST', '/volunteer_save_approval', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApprovalController.php';
    (new VolunteerApprovalController($db))->save();
});

$router->add('GET', '/volunteer_attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerAttendanceController.php';
    (new VolunteerAttendanceController($db))->index();
});

$router->add('POST', '/volunteer_attendance_approve', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerAttendanceController.php';
    (new VolunteerAttendanceController())->approve();
});

$router->add('GET', '/volunteer_employer_reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerReportsController.php';
    (new VolunteerReportsController($db))->index();
});

$router->add('GET', '/volunteer_evaluation', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerGradingController.php';
    (new VolunteerGradingController($db))->index();
});

$router->add('POST', '/volunteer_submit_grading', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerGradingController.php';
    (new VolunteerGradingController($db))->submit();
});

$router->add('GET', '/volunteer_notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerNotificationController.php';
    (new VolunteerNotificationController($db))->index();
});

$router->add('GET', '/volunteer_opportunities', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController($db))->index();
});

$router->add('POST', '/store_opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController($db))->store();
});

$router->add('GET', '/volunteer_edit_opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    $id = $_GET['id'] ?? null; 
    (new VolunteerOpportunityController($db))->edit($id);
});

$router->add('POST', '/volunteer_update_opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    (new VolunteerOpportunityController($db))->update();
});

$router->add('GET', '/delete_opportunity', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerOpportunityController.php';
    $id = $_GET['id'] ?? null;
    (new VolunteerOpportunityController($db))->delete($id);
});

$router->add('GET', '/volunteer_profile', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController($db))->index();
});

$router->add('POST', '/volunteer_profile_update', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController($db))->update();
});

$router->add('POST', '/volunteer_password_update', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerProfileController.php';
    (new VolunteerProfileController($db))->changePassword();
});

$router->add('GET', '/volunteer_requests', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApplicationController.php';
    (new VolunteerApplicationController($db))->index();
});

$router->add('GET', '/handle_application', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerApplicationController.php';
    (new VolunteerApplicationController($db))->handleStatus();
});

$router->add('GET', '/volunteer_students', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/VolunteerStudentController.php';
    (new VolunteerStudentController($db))->index();
});

$router->add('GET', '/volunteer_view_student', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/StudentReviewController.php';
    (new StudentReviewController($db))->show();
});

$router->add('POST', '/student_review/process', function() use ($db) {
    require_once APP_PATH . '/Controllers/Volunteer_Supervisor_Controllers/StudentReviewController.php';
    (new StudentReviewController($db))->process();
});

$router->add('GET', '/external_dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalDashboardController.php';
    (new ExternalDashboardController($db))->index();
});

$router->add('GET', '/external/applications', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController($db))->index();
});

$router->add('POST', '/applications/approve', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController($db))->approve();
});

$router->add('POST', '/applications/reject', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalApplicationsController.php';
    (new ExternalApplicationsController($db))->reject();
});

$router->add('GET', '/external/opportunities', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController($db))->index();
});

$router->add('POST', '/external/opportunities/update', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController($db))->update();
});

$router->add('POST', '/external/opportunities/delete', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController($db))->delete();
});

$router->add('GET', '/external/opportunities/add', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController($db))->create();
});

$router->add('POST', '/external/opportunities/store', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOpportunitiesController.php';
    (new ExternalOpportunitiesController($db))->store();
});

$router->add('GET', '/external/certificates', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalCertificatesController.php';
    (new ExternalCertificatesController($db))->index();
});

$router->add('POST', '/external/certificates/store', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalCertificatesController.php';
    (new ExternalCertificatesController($db))->store();
});

$router->add('GET', '/external/officials', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOfficialsController.php';
    (new ExternalOfficialsController($db))->index();
});

$router->add('POST', '/external/officials/update', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOfficialsController.php';
    (new ExternalOfficialsController($db))->update();
});

$router->add('POST', '/external/officials/assign', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOfficialsController.php';
    (new ExternalOfficialsController($db))->assign();
});

$router->add('GET', '/external/officials/unassign/(\d+)', function($student_id) use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalOfficialsController.php';
    (new ExternalOfficialsController($db))->unassign($student_id);
});

$router->add('GET', '/external/trainees', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalTraineesController.php';
    (new ExternalTraineesController($db))->index();
});

$router->add('GET', '/external/trainers', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalTrainersController.php';
    (new ExternalTrainersController($db))->index();
});

$router->add('POST', '/assign-student', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalTrainersController.php';
    (new ExternalTrainersController($db))->assign();
});

$router->add('POST', '/update-trainer', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalTrainersController.php';
    (new ExternalTrainersController($db))->update(); 
});

$router->add('GET', '/external/notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalNotificationsController.php';
    (new ExternalNotificationsController($db))->index();
});
$router->add('GET', '/external/student-portfolio', function() use ($db) {
    require_once APP_PATH . '/Controllers/External_Controlles/ExternalStudentPortfolioController.php';
    $id = $_GET['id'] ?? null;
    if ($id) {
        (new ExternalStudentPortfolioController($db))->show($id);
    } else {
        echo "الطالب غير محدد";
    }
});
$router->add('GET', '/trainer/dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerDashboardController.php';
    (new TrainerDashboardController($db))->index();
});

$router->add('GET', '/trainer/profile', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerProfileController.php';
    (new TrainerProfileController($db))->index();
});

$router->add('POST', '/trainer/profile/update', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerProfileController.php';
    (new TrainerProfileController($db))->update();
});

$router->add('GET', '/trainer/attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerAttendanceController.php';
    (new TrainerAttendanceController($db))->index();
});

$router->add('POST', '/trainer/attendance/save', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerAttendanceController.php';
    (new TrainerAttendanceController($db))->save();
});

$router->add('GET', '/trainer/reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController($db))->index();
});

$router->add('POST', '/trainer/reports/process-monthly', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController($db))->processMonthly();
});

$router->add('POST', '/trainer/reports/process-final', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerReportsController.php';
    (new TrainerReportsController($db))->processFinal();
});

$router->add('GET', '/trainer/student-details/(\d+)', function($student_id) use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerStudentDetailsController.php';
    (new TrainerStudentDetailsController($db))->show($student_id);
});

$router->add('GET', '/trainer/notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/Trainer_Controllers/TrainerNotificationsController.php';
    (new TrainerNotificationsController($db))->index();
});

$router->add('GET', '/v_manager/dashboard', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerDashboardController.php';
    (new VManagerDashboardController($db))->index();
});

$router->add('GET', '/v_manager/profile', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerProfileController.php';
    (new VManagerProfileController($db))->index();
});

$router->add('POST', '/v_manager/profile/update', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerProfileController.php';
    (new VManagerProfileController($db))->update();
});

$router->add('GET', '/v_manager/volunteers', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerVolunteersController.php';
    (new VManagerVolunteersController($db))->index();
});

$router->add('GET', '/v_manager/student-details', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerStudentDetailsController.php';
    (new VManagerStudentDetailsController($db))->index();
});
$router->add('POST', '/v_manager/complete-volunteer', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerStudentDetailsController.php';
    $controller = new VManagerStudentDetailsController();
    if (isset($_POST['studentID'])) {
        $controller->handleCompleteVolunteer($_POST['studentID']);
    }
});

$router->add('GET', '/v_manager/reports', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerReportsController.php';
    (new VManagerReportsController($db))->index();
});

$router->add('GET', '/v_manager/attendance', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerAttendanceController.php';
    (new AttendanceController($db))->index();
});

$router->add('POST', '/v_manager/attendance/save', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerAttendanceController.php';
    (new AttendanceController($db))->save();
});

$router->add('GET', '/v_manager/notifications', function() use ($db) {
    require_once APP_PATH . '/Controllers/V_Manager_Controllers/VManagerNotificationController.php';
    (new NotificationController($db))->index();
});

$router->add('GET', '/admin/admin_dashboard', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminDashboardController.php';
    (new AdminDashboardController($db))->index();
});


$router->add('GET', '/admin/accounts', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminAccountsController.php';
    (new AdminAccountsController($db))->index();
});


$router->add('POST', '/admin/update-user', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminAccountsController.php';
    (new AdminAccountsController($db))->update();
});

$router->add('POST', '/admin/delete-user', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminAccountsController.php';
    (new AdminAccountsController($db))->destroy();
});

$router->add('GET', '/admin/certificates', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminCertificatesController.php';
    (new AdminCertificatesController($db))->index();
});

$router->add('POST', '/admin/process-signature', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminCertificatesController.php';
    (new AdminCertificatesController($db))->process();
});

$router->add('GET', '/admin/statistics', function() use($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminStatisticsController.php';
    (new AdminStatisticsController($db))->index();
});

$router->add('GET', '/admin/notifications', function() use ($db) {
    require_once '../app/Controllers/Admin_Controllers/AdminNotificationsController.php';
    (new AdminNotificationsController($db))->index();
});

$router->add('GET', '/admin/profile', function() use ($db) {
    require_once __DIR__ . '/../app/Controllers/Admin_Controllers/AdminProfileController.php';
    (new AdminProfileController($db))->index();
});

$router->add('POST', '/admin/profile/update', function() use ($db) {
    require_once __DIR__ . '/../app/Controllers/Admin_Controllers/AdminProfileController.php';
    (new AdminProfileController($db))->update();
});

$router->add('GET', '/register', function() use ($db) {
    require_once __DIR__ . '/../app/controllers/RegisterController.php';
    (new RegisterController($db))->showRegisterForm();
});

$router->add('POST', '/register_process', function() use ($db) {
    require_once __DIR__ . '/../app/controllers/RegisterController.php';
    (new RegisterController($db))->processRegistration();
});

$router->add('GET', '/logout', function() {
    require_once APP_PATH . '/Controllers/AuthController.php';
    (new AuthController())->logout();
});
$router->add('GET', '/supervisor_pending-opportunities', function() use ($db) {
    require_once __DIR__ . '/../app/Controllers/PendingOpportunitiesController.php';
    (new PendingOpportunitiesController($db))->index(); 
});

$router->add('POST', '/pending/approve', function() use ($db) {
    require_once __DIR__ . '/../app/Controllers/PendingOpportunitiesController.php';
    (new PendingOpportunitiesController($db))->approve();
});
$router->run();