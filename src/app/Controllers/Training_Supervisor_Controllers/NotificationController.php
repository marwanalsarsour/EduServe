<?php

class NotificationController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }


        if (!isset($_SESSION['supervisor_notifications'])) {
            $_SESSION['supervisor_notifications'] = [];
        }
    }

    public function index() {

        $notifications = $_SESSION['supervisor_notifications'];


        $data = ['notifications' => $notifications];
        require_once VIEW_PATH . '/supervisor/supervisor-notifications.php';
    }

    public function markAllAsRead() {
        if (isset($_SESSION['supervisor_notifications'])) {
            foreach ($_SESSION['supervisor_notifications'] as &$notif) {
                $notif['is_read'] = true;
            }
        }
       
        header('Location: /supervisor/notifications');
        exit;
    }
}