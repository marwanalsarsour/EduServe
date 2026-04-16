<?php

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/SupervisorModel.php';

class SupervisorDashboardController {
    
    public function index() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['is_logged_in']) || $_SESSION['user_role'] !== 'supervisor') {
            header('Location: /login');
            exit();
        }

        $supervisor_id = $_SESSION['user_id'];

     
        $database = new Database();
        $db = $database->getConnection();
        $model = new SupervisorModel($db);

       
        $data = [
            'supervisor' => $model->getSupervisorData($supervisor_id),
            'stats' => $model->getDashboardStats($supervisor_id),
            'recent_activity' => $model->getRecentActivity($supervisor_id),
            'title' => 'لوحة تحكم المشرف الأكاديمي'
        ];

        
        require_once __DIR__ . '/../../Views/supervisor/dashboard.view.php';
    }
}