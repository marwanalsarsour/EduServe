<?php
class ExternalOfficialsController {
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        global $db;
        
        require_once APP_PATH . '/models/ExternalEntityModel.php';
        
        $this->model = new ExternalEntityModel($db);
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        $supervisor = $this->model->getSupervisorByOrg($org_id);
        
        $assignedStudents = [];
        $unassignedStudents = [];
        
        if ($supervisor) {
            $assignedStudents = $this->model->getAssignedStudents($supervisor['id']);
            $unassignedStudents = $this->model->getUnassignedStudents($org_id);
        }

        require_once VIEW_PATH . '/external-organization/external_officials-management.php';
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'field' => $_POST['field']
        ];
        $this->model->updateSupervisor($id, $data);
        header('Location: /external/officials');
    }

    public function assign() {
        $this->model->assignStudent($_POST['supervisor_id'], $_POST['student_id']);
        header('Location: /external/officials');
    }

    public function unassign($student_id) {
        $org_id = $_SESSION['user_id'];
        $supervisor = $this->model->getSupervisorByOrg($org_id);
        if ($supervisor) {
            $this->model->unassignStudent($supervisor['id'], $student_id);
        }
        header('Location: /external/officials');
    }
}