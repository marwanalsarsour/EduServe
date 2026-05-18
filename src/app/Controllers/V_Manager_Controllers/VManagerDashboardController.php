<?php
class VManagerDashboardController {
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
        
        $data = [
            'active_volunteers' => $this->model->getActiveVolunteersCount($manager_id),
            'total_hours'       => $this->model->getTotalCompletedHours($manager_id),
            'notifications_count' => 8 
        ];

        require_once '../src/views/v_manager/v_manager_dashboard.php';
    }
}