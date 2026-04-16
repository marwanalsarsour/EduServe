<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class AttendanceReviewController {
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

        $attendance = $this->model->getPendingAttendance($_SESSION['user_id']);
        $data = ['attendance' => $attendance];
        
        require_once VIEW_PATH . '/supervisor/supervisor-attendance.php';
    }

    public function handleAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $action = $_POST['action']; 
            
            $status = ($action === 'approve') ? 'approved' : 'rejected';

            if ($this->model->updateAttendanceStatus($id, $status)) {
                $_SESSION['success_msg'] = "تم تحديث حالة سجل الحضور.";
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء التحديث.";
            }
            header('Location: /supervisor-attendance');
            exit;
        }
    }
}