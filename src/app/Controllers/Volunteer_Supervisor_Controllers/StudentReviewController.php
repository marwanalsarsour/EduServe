<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class StudentReviewController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function show() {
        $app_id = $_GET['id'] ?? null;

        if (!$app_id) {
            header('Location: /volunteer_requests');
            exit;
        }

        $application = $this->model->getApplicationDetails($app_id);
        $prev_stats = $this->model->getStudentPreviousHours($application['studentID']);

        require_once VIEW_PATH . '/volunteer/volunteer_view_student.php';
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $app_id = $_POST['app_id'] ?? null;

            if (!$app_id) {
                header('Location: /volunteer_requests?status=error');
                exit;
            }

            if (isset($_POST['accept_request'])) {

                $this->model->updateApplicationStatus($app_id, 'معتمد');
                header('Location: /volunteer_requests?status=accepted');

            } elseif (isset($_POST['confirm_reject'])) {

                $this->model->updateApplicationStatus($app_id, 'مرفوض');
                header('Location: /volunteer_requests?status=rejected');
            }

            exit;
        }
    }
}