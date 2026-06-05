<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerProfileController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            header('Location: /login');
            exit;
        }

        $role = trim($_SESSION['user_role'] ?? '');
        if ($role !== 'مشرف تطوع' && $role !== 'volunteer_supervisor') {
            header('Location: /login');
            exit;
        }

        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        $user = $this->model->getSupervisorProfile($user_id);
        
        if ($user) {
            $_SESSION['user_name'] = $user['fullName'];
        }

        require_once VIEW_PATH . '/volunteer/volunteer_profile.php'; 
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $name  = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);

            if ($this->model->updateProfile($user_id, $name, $email, $phone)) {
                $_SESSION['user_name'] = $name;
                header('Location: /volunteer_profile?status=updated');
            } else {
                header('Location: /volunteer_profile?status=error');
            }
            exit;
        }
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $new_pass = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];

            if (empty($new_pass)) {
                header('Location: /volunteer_profile?status=empty_pass');
                exit;
            }

            if ($new_pass === $confirm_pass) {
                $this->model->updatePassword($user_id, $new_pass);
                header('Location: /volunteer_profile?status=pass_updated');
            } else {
                header('Location: /volunteer_profile?status=pass_mismatch');
            }
            exit;
        }
    }
}