<?php

require_once __DIR__ . '/../../Models/AdminModel.php'; 

class AdminDashboardController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function index() {
        $stats = $this->adminModel->getDashboardStats();
        
        require_once VIEW_PATH . '/admin/admin_dashboard.php'; 
    }
}