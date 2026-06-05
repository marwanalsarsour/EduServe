<?php

require_once __DIR__ . '/../../Models/AdminModel.php'; 

class AdminCertificatesController {
    private $adminModel;

    public function __construct($db = null) {
        $this->adminModel = new AdminModel($db);
    }

    public function index() {
        $students = $this->adminModel->getQualifiedStudents();
        require_once VIEW_PATH . '/admin/admin_certificates.php';
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId  = $_POST['student_id'] ?? 0;
            $certTitle  = $_POST['cert_title'] ?? '';

            if (empty($studentId) || empty($certTitle)) {
                header("Location: /admin/certificates?error=missing_fields");
                exit;
            }

            $verificationCode = "EDUSERVE-" . strtoupper(uniqid());
            
            $defaultSecureHash = hash('sha256', 'LYANA_EDUSERVE_SIGNED');

            $success = $this->adminModel->issueCertificate($studentId, $certTitle, $defaultSecureHash, $verificationCode);

            if ($success) {
                header("Location: /admin/certificates?success=issued&code=" . $verificationCode);
            } else {
                header("Location: /admin/certificates?error=already_exists");
            }
            exit;
        }
    }
}