<?php
require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_MyApplicationsController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) {
            header("Location: /login");
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $studentModel = new StudentModel($this->db);
        
        $applications = $studentModel->getStudentApplications($studentId);

        require_once VIEW_PATH . '/student/student_my-application.php';
    }
}