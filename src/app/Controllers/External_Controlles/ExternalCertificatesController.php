<?php

class ExternalCertificatesController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new ExternalEntityModel($db);
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        $students = $this->model->getAcceptedStudents($org_id);
        require_once '../src/views/external-organization/external_certificates.php';
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['organization_id'] = $_SESSION['user_id'];

            $data['signature_path'] = $this->uploadFile($_FILES['signature'], 'signatures');
            $data['stamp_path'] = $this->uploadFile($_FILES['stamp'], 'stamps');

            if ($this->model->saveCertificate($data)) {
                $_SESSION['success'] = "تم إصدار المستند بنجاح";
            } else {
                $_SESSION['error'] = "فشل في إصدار المستند";
            }
            header('Location: /external/certificates');
            exit;
        }
    }

    private function uploadFile($file, $folder) {
        if (isset($file) && $file['error'] === 0) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $ext;
            $uploadPath = "public/uploads/$folder/" . $fileName;
            
            if (!is_dir("public/uploads/$folder/")) {
                mkdir("public/uploads/$folder/", 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return "/uploads/$folder/" . $fileName;
            }
        }
        return null;
    }
}