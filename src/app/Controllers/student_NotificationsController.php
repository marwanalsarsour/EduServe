<?php
require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_NotificationsController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        
        global $db;
        $studentModel = new StudentModel($db);
        
        $notifications = $studentModel->getSmartNotifications($studentId);
        require_once VIEW_PATH . '/student/student_notifications.php';
    }
}