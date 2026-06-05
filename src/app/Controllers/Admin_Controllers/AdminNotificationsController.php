<?php


require_once __DIR__ . '/../../Models/AdminModel.php';

class AdminNotificationsController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function index() {

        $notifications = $this->adminModel->getDynamicNotifications();

        require_once VIEW_PATH . '/admin/admin_notifications.php'; 
    }
}