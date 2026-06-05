<?php
class TrainerStudentDetailsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/TrainerModel.php';
        
        $this->model = new TrainerModel($this->db);
    }

    public function show($student_id) {
        $trainer_id = $_SESSION['user_id'];
        
        $student = $this->model->getStudentDetails($student_id);
        $reports = $this->model->getStudentReports($student_id, $trainer_id);
        
        $required_hours = 120; 
        $completed_hours = $student['completed_hours'] ?? 0;
        $progress_percent = min(100, round(($completed_hours / $required_hours) * 100));

        require_once VIEW_PATH . '/trainer/trainer_student_details.php';
    }
}