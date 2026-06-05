<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerDashboardController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            header('Location: /login');
            exit();
        }

        $role = trim($_SESSION['user_role'] ?? '');
        if ($role !== 'مشرف تطوع' && $role !== 'volunteer_supervisor') {
            header('Location: /login');
            exit();
        }
       
        global $db; 
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $data = [
            'stats' => $this->model->getDashboardStats(),
            'applications' => $this->model->getRecentApplications()
        ];
     
        require_once VIEW_PATH . '/volunteer/volunteer_dashboard.php';
    }
}