<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerProfileController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        $user = $this->model->getSupervisorProfile($user_id);
        require_once VIEW_PATH . '/volunteer/volunteer_profile.php'; 
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $name  = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if ($this->model->updateProfile($user_id, $name, $email, $phone)) {
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