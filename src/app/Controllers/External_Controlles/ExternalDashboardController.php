<?php
require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalDashboardController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new ExternalEntityModel($db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'جهة خارجية') {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        
        $orgData = $this->model->getOrgDetails($org_id);
        $stats = $this->model->getDashboardStats($org_id);

        if ($orgData) {
            $orgData['name'] = $orgData['entityName'] ?? $orgData['fullName'] ?? 'جهة خارجية معتمدة';
        } else {
            $orgData = ['name' => 'جهة غير معروفة']; 
        }

        require_once VIEW_PATH . '/external-organization/external_dashboard.php';
    }
}