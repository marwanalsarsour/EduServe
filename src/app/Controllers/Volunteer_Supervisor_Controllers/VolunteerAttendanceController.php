<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerAttendanceController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $attendance_records = $this->model->getPendingAttendance();
        require_once VIEW_PATH . '/volunteer/volunteer_attendance.php';
    }

    public function approve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hour_id = $_POST['hour_id'];
            if ($this->model->approveDailyAttendance($hour_id)) {
                header('Location: /volunteer_attendance?status=success');
            } else {
                header('Location: /volunteer_attendance?status=error');
            }
        }
    }
}