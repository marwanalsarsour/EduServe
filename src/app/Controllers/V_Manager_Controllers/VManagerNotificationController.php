<?php
class NotificationController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/VolunteerManagerModel.php';
        
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        
        $notifications = $this->model->getDynamicNotifications($manager_id);
        
        require_once VIEW_PATH . '/v_manager/v_manager_notifications.php';
    }
}