<?php
class VManagerProfileController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/VolunteerManagerModel.php';
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        $profile = $this->model->getManagerProfile($manager_id);
        require_once '../src/views/v_manager/v_manager_profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager_id = $_SESSION['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if ($this->model->updateProfile($manager_id, $name, $email, $phone)) {
                $_SESSION['success_profile'] = "تم تحديث معلوماتك بنجاح.";
            } else {
                $_SESSION['error_profile'] = "حدث خطأ أثناء التحديث، يرجى المحاولة لاحقاً.";
            }
            header('Location: /v_manager/profile');
            exit();
        }
    }
}