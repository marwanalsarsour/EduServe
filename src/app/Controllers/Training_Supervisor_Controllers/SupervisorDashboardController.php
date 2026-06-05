<?php

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/SupervisorModel.php';

class SupervisorDashboardController {
    private $db;
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['is_logged_in']) || $_SESSION['user_role'] !== 'مشرف تدريب') {
            header('Location: /login');
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new SupervisorModel($this->db);
    }
    
    public function index() {
        $supervisor_id = $_SESSION['user_id'];
       
        $data = [
            'supervisor'      => $this->model->getSupervisorData($supervisor_id),
            'stats'           => $this->model->getDashboardStats($supervisor_id),
            'recent_activity' => $this->model->getRecentActivity($supervisor_id),
            'title'           => 'لوحة تحكم المشرف الأكاديمي'
        ];
        
        require_once VIEW_PATH . '/supervisor/supervisor-dashboard.php';
    }
}