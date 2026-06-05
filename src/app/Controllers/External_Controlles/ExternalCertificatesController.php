<?php

require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalCertificatesController {
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
        
        $orgData = $this->model->getDashboardStats($org_id);
        if (!is_array($orgData)) {
            $orgData = [];
        }

        $orgDetails = $this->model->getOrganizationDetails($org_id);
        if ($orgDetails) {
            $orgData['name'] = $orgDetails['fullName'];
        } else {
            $orgData['name'] = 'الجهة التدريبية الخارجية';
        }

        $students = $this->model->getAcceptedStudents($org_id);
        
        require_once VIEW_PATH . '/external-organization/external_certificates.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['organization_id'] = $_SESSION['user_id'];

            $data['signature_path'] = $this->uploadFile($_FILES['signature'] ?? null, 'signatures');
            $data['stamp_path'] = $this->uploadFile($_FILES['stamp'] ?? null, 'stamps');

            $verifyCode = $this->model->saveCertificate($data);

            if ($verifyCode) {
                header("Location: /external/certificates?success=issued&code=" . urlencode($verifyCode));
            } else {
                header("Location: /external/certificates?error=failed");
            }
            exit;
        }
    }

    private function uploadFile($file, $folder) {
        if (isset($file) && $file['error'] === 0) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $ext;
            
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/$folder/" . $fileName;
            
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/uploads/$folder/")) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . "/uploads/$folder/", 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return "/uploads/$folder/" . $fileName;
            }
        }
        return null;
    }
}