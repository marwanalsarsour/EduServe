<?php
class VManagerProfileController {
    private $model;
    private $db;

    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;

        require_once APP_PATH . '/Models/VolunteerManagerModel.php';
        $this->model = new VolunteerManagerModel($this->db);
    }


    public function index() {
        $manager_id = $_SESSION['user_id'];
        $profile = $this->model->getManagerProfile($manager_id);

        if (!$profile) {
            $profile = [
                'employeeName'  => '',
                'employeeEmail' => '',
                'location'      => '',
                'entityName'    => ''
            ];
        }

        require_once VIEW_PATH . '/v_manager/v_manager_profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $manager_id    = $_SESSION['user_id'];
            $employeeName  = $_POST['employeeName'] ?? '';
            $employeeEmail = $_POST['employeeEmail'] ?? '';
            $location      = $_POST['location'] ?? '';

            if ($this->model->updateProfile($manager_id, $employeeName, $employeeEmail, $location)) {
                $_SESSION['success_profile'] = "تم تحديث معلوماتك بنجاح.";
            } else {
                $_SESSION['error_profile'] = "حدث خطأ أثناء التحديث، يرجى المحاولة لاحقاً.";
            }

            header('Location: /v_manager/profile');
            exit();
        }
    }
}