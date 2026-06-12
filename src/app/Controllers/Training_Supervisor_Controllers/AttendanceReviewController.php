<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once APP_PATH . '/Models/SupervisorModel.php';

class AttendanceReviewController {

    private $model;

    public function __construct() {
        global $db;

        $this->model = new SupervisorModel($db);

        if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
            header('Location: /login');
            exit();
        }

        $role = trim($_SESSION['user_role'] ?? '');

        if (
            $role !== 'مشرف تدريب' &&
            $role !== 'supervisor' &&
            $role !== 'academic_supervisor'
        ) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {

        $supervisor_id = $_SESSION['user_id'];

        $attendance = $this->model->getPendingAttendance($supervisor_id);

        $data = [
            'attendance' => $attendance
        ];

        require_once VIEW_PATH . '/supervisor/supervisor-attendance.php';
    }

    public function handleAction() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /supervisor-attendance');
            exit;
        }

        $attendance_id = $_POST['id'] ?? null;
        $action = $_POST['action'] ?? '';

        if (!$attendance_id) {
            $_SESSION['error_msg'] = 'رقم السجل غير موجود.';
            header('Location: /supervisor-attendance');
            exit;
        }

        $status = ($action === 'approve')
            ? 'معتمد'
            : 'مرفوض';

        if ($this->model->updateAttendanceStatus($attendance_id, $status)) {
            $_SESSION['success_msg'] = 'تم تحديث حالة سجل الحضور بنجاح.';
        } else {
            $_SESSION['error_msg'] = 'حدث خطأ أثناء التحديث.';
        }

        header('Location: /supervisor-attendance');
        exit;
    }
}