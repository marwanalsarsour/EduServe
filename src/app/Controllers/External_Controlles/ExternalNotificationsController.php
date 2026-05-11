<?php

class ExternalNotificationsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/ExternalEntityModel.php';
        $this->model = new ExternalEntityModel($this->db);
    }

    public function index() {
        $org_id = $_SESSION['user_id'];

        $notifications = $this->model->getRecentEventsAsNotifications($org_id);

        require_once '../src/views/external-organization/external_notifications.php';
    }
}