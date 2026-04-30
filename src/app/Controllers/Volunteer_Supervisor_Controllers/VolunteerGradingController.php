<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerGradingController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $students = $this->model->getStudentsForFinalGrading();
        require_once VIEW_PATH . '/volunteer/volunteer_evaluation.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $app_id = $_POST['application_id'];
            $grade = $_POST['grade'];
            $recommendations = $_POST['recommendations'];

            if ($this->model->submitFinalEvaluation($app_id, $grade, $recommendations)) {
                header('Location: /volunteer_dashboard?status=success');
            } else {
                header('Location: /volunteer_evaluation?status=error');
            }
            exit;
        }
    }
}