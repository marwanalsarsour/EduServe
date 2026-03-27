<?php

class StudentDashboardController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');

       
        $studentData = $model->getStudentProfile($studentId);
        $latestRequest = $model->getLatestApplication($studentId);
        $certInfo = $model->getCertificateQuickSummary($studentId);

        require_once VIEW_PATH . '/student/dashboard.view.php';
    }
}