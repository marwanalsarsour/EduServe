<?php

require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalNotificationsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $db;
        $this->db = $db;

        $this->model = new ExternalEntityModel($this->db);

        $currentRole = $_SESSION['user_role'] ?? $_SESSION['role'] ?? '';

        if (!isset($_SESSION['user_id']) || $currentRole !== 'جهة خارجية') {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $org_id = $_SESSION['user_id'];

        $notifications = $this->model->getRecentEventsAsNotifications($org_id);

        require_once VIEW_PATH . '/external-organization/external_notifications.php';
    }
}