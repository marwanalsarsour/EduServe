<?php

require_once __DIR__ . '/../../Models/AdminModel.php';

class AdminProfileController {
    private $adminModel;

    public function __construct($db = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        $userId = $_SESSION['user_id'] ?? null;
        $userRole = trim($_SESSION['user_role'] ?? '');
        if (!$userId || !in_array($userRole, ['إدارة كلية', 'مدير',  'admin'])) {
            header('Location: /login');
            exit();
        }

        $this->adminModel = new AdminModel($db);
    }

    public function index() {
        $adminID = $_SESSION['user_id'];
        $adminData = $this->adminModel->getAdminProfile($adminID);

        $success = $_SESSION['success_msg'] ?? null;
        $error = $_SESSION['error_msg'] ?? null;
        unset($_SESSION['success_msg'], $_SESSION['error_msg']);

        require_once VIEW_PATH . '/admin/admin_profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminID = $_SESSION['user_id'];
            $fullName = trim($_POST['fullName']);
            $email = trim($_POST['email']);
            $phoneNumber = trim($_POST['phoneNumber']);
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            if (empty($fullName) || empty($email) || empty($phoneNumber)) {
                $_SESSION['error_msg'] = "جميع الحقول الأساسية مطلوبة!";
                header('Location: /admin/profile');
                exit();
            }

            $result = $this->adminModel->updateAdminProfile($adminID, $fullName, $email, $phoneNumber, $password);

            if ($result === 'email_exists') {
                $_SESSION['error_msg'] = "البريد الإلكتروني مُستخدم بالفعل من قبل حساب آخر!";
            } elseif ($result === true) {
                $_SESSION['full_name'] = $fullName; 
                $_SESSION['success_msg'] = "تم تحديث ملفك الشخصي بنجاح.";
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء تحديث البيانات، يرجى المحاولة مرة أخرى.";
            }

            header('Location: /admin/profile');
            exit();
        }
    }
}