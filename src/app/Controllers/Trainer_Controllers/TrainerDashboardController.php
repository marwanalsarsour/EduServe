<?php
class TrainerDashboardController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/TrainerModel.php';
        $this->model = new TrainerModel($this->db);
    }

    public function index() {
        $trainer_id = $_SESSION['user_id'];
        
        $stats = $this->model->getDashboardStats($trainer_id);
        $students = $this->model->getTrainerStudents($trainer_id);

        require_once '../src/views/trainer/trainer_dashboard.php';
    }
}