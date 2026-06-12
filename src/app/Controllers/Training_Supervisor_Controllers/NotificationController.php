<?php

require_once APP_PATH . '/Models/SupervisorModel.php';

class NotificationController {

    private $model;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        global $db;
        $this->model = new SupervisorModel($db);
    }
    public function index() {

        $supervisorId = $_SESSION['user_id'];
        $notifications = $this->model->getLiveNotifications($supervisorId);

        $data = [
            'notifications' => $notifications
        ];

        require_once VIEW_PATH . '/supervisor/supervisor-notifications.php';
    }
    public function markAllAsRead() {

        if (!empty($_SESSION['supervisor_notifications'])) {

            foreach ($_SESSION['supervisor_notifications'] as &$notif) {
                $notif['is_read'] = true;
            }
        }

        header('Location: /supervisor/notifications');
        exit;
    }
}