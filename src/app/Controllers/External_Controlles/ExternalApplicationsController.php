<?php
require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalApplicationsController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new ExternalEntityModel($db);
        
        // التحقق من الجلسة والصلاحيات
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'external_entity') { 
            header('Location: /login'); 
            exit; 
        }
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        $search = $_GET['search'] ?? '';
        

        $applications = $this->model->getApplications($org_id, $search);
        
  
        require_once VIEW_PATH . '/external-organization/external_application-management.php';
    }

    public function approve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
            $this->model->updateApplicationStatus($_POST['application_id'], 'accepted', $_POST['message']);
            header('Location: /external/applications?success=accepted');
            exit;
        }
    }

    public function reject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
            $this->model->updateApplicationStatus($_POST['application_id'], 'rejected', $_POST['message']);
            header('Location: /external/applications?success=rejected');
            exit;
        }
    }
}