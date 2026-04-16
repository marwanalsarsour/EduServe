<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class ApplicationController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
    }


    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $supervisor_id = $_SESSION['user_id'];
        $applications = $this->model->getPendingApplications($supervisor_id);

        $data = ['applications' => $applications];
        require_once VIEW_PATH . '/supervisor/supervisor-applications.php';
    }

    public function handleAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $action = $_POST['action']; 
            
            $status = ($action === 'accept') ? 'accepted' : 'rejected';

            if ($this->model->updateApplicationStatus($id, $status)) {
                $_SESSION['success_msg'] = "تم تحديث حالة الطلب بنجاح.";
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء التحديث.";
            }
            header('Location: /supervisor-applications');
            exit;
        }
    }
}