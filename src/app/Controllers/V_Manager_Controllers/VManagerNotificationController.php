<?php
class NotificationController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/VolunteerManagerModel.php';
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        
        $notifications = $this->model->getDynamicNotifications($manager_id);
        
        require_once '../src/views/v_manager/v_manager_notifications.php';
    }
}