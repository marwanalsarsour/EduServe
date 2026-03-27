<?php

class student_MyApplicationsController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $studentId = $_SESSION['user_id'] ?? null;

        if (!$studentId) {
            header("Location: /login");
            exit();
        }

       
        $studentModel = $this->model('StudentModel');
        $applications = $studentModel->getStudentApplications($studentId);

        require_once VIEW_PATH . '/student/student_my-application.php';
    }
}