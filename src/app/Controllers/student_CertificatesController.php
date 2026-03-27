<?php

class student_CertificatesController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        
       
        $studentModel = $this->model('StudentModel');
        $certificates = $studentModel->getStudentCertificates($studentId);

        require_once VIEW_PATH . '/student/student_certificates.php';
    }
}