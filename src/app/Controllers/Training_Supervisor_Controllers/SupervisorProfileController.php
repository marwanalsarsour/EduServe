<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once APP_PATH . '/Models/SupervisorModel.php';

class SupervisorProfileController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || !isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $role = trim($_SESSION['user_role'] ?? '');
        if ($role !== 'مشرف تدريب' && $role !== 'supervisor' && $role !== 'academic_supervisor') {
            header('Location: /login');
            exit();
        }

        global $db;
        $this->model = new SupervisorModel($db);
    }

    public function index() {
        $supervisor_id = $_SESSION['user_id'];
        $profile = $this->model->getSupervisorProfile($supervisor_id);
        
        $data = [
            'title' => 'الملف الشخصي - المشرف الأكاديمي',
            'profile' => $profile
        ];

        require_once VIEW_PATH . '/supervisor/supervisor-profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
            $updateData = [
                'name'  => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ];

            if ($this->model->updateProfile($id, $updateData)) {
                $_SESSION['success_msg'] = "تم تحديث بيانات الملف الشخصي بنجاح";
            }
            header('Location: /supervisor_profile');
            exit;
        }
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
            $pass = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            if ($pass === $confirm) {
                $this->model->updatePassword($id, $pass);
                $_SESSION['success_msg'] = "تم تغيير كلمة المرور بنجاح";
            } else {
                $_SESSION['error_msg'] = "كلمات المرور غير متطابقة";
            }
            header('Location: /supervisor_profile');
            exit;
        }
    }
}