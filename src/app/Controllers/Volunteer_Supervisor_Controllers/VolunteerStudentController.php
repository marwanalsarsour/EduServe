<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerStudentController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $volunteers = $this->model->getActiveVolunteers();
        require_once VIEW_PATH . '/volunteer/volunteer_students.php'; 
    }
}