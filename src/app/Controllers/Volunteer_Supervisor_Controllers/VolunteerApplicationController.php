<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerApplicationController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $applications = $this->model->getAllApplications();
        require_once VIEW_PATH . '/volunteer/volunteer_requests.php';
    }

    public function handleStatus() {
        $id = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? null; // 
        
        if ($id && $action) {
            $status = ($action === 'approve') ? 'approved' : 'rejected';
            $this->model->updateApplicationStatus($id, $status);
            header('Location: /volunteer_requests?status=success');
        } else {
            header('Location: /volunteer_requests?status=error');
        }
        exit;
    }
}