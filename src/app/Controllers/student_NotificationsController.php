<?php

class student_NotificationsController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $studentModel = $this->model('StudentModel');
        
        
        $notifications = $studentModel->getSmartNotifications($studentId);

        require_once VIEW_PATH . '/student/student_notifications.php';
    }
}