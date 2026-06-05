<?php
class VManagerDashboardController {
    private $model;
    private $db;

    public function __construct($db = null) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/VolunteerManagerModel.php';
        
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        
        $notifications = $this->model->getDynamicNotifications($manager_id);
        
        $notifications_count = is_array($notifications) ? count($notifications) : 0;

        $data = [
            'active_volunteers'   => $this->model->getActiveVolunteersCount($manager_id),
            'total_hours'         => $this->model->getTotalCompletedHours($manager_id),
            'notifications_count' => $notifications_count 
        ];

        require_once VIEW_PATH . '/v_manager/v_manager_dashboard.php';
    }
}