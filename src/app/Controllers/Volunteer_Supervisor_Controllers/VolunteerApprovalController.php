<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerApprovalController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $students = $this->model->getStudentsForApproval();
        require_once VIEW_PATH . '/volunteer/volunteer_approval.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['application_id'];
            $hours = $_POST['final_hours'];
            $result = $_POST['evaluation'];

            if ($this->model->updateFinalApproval($id, $hours, $result)) {
                header('Location: /volunteer_approval?status=success');
            } else {
                header('Location: /volunteer_approval?status=error');
            }
        }
    }
}