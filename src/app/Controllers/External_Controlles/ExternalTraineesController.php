<?php

require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalTraineesController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $db; 
        $this->db = $db;
        
        $this->model = new ExternalEntityModel($this->db);

        $currentRole = $_SESSION['user_role'] ?? $_SESSION['role'] ?? '';

        if (!isset($_SESSION['user_id']) || $currentRole !== 'جهة خارجية') {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        $org_type = $_SESSION['org_type'] ?? 'training'; 

        $trainees = $this->model->getTraineesByOrg($org_id);

        $labels = [
            'title' => ($org_type == 'volunteer') ? 'المتطوعين' : 'المتدربين',
            'desc' => ($org_type == 'volunteer') ? 'عرض جميع المتطوعين داخل المؤسسة' : 'عرض جميع الطلاب المتدربين داخل الشركة',
            'supervisor_label' => ($org_type == 'volunteer') ? 'المشرف' : 'المدرب'
        ];

        require_once VIEW_PATH . '/external-organization/external_trainees-students.php';
    }
}