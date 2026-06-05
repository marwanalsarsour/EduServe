<?php

require_once APP_PATH . '/Models/TrainerModel.php';

class TrainerDashboardController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        global $db;
        $this->db = $db;
        
        $this->model = new TrainerModel($this->db);

        $currentRole = $_SESSION['user_role'] ?? $_SESSION['role'] ?? '';

        if (!isset($_SESSION['user_id']) || ($currentRole !== 'مدرب' && $currentRole !== 'جهة خارجية')) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $trainer_id = $_SESSION['user_id'];
        
        $stats = $this->model->getDashboardStats($trainer_id);
        $students = $this->model->getTrainerStudents($trainer_id);

        require_once VIEW_PATH . '/trainer/trainer_dashboard.php';
    }
}