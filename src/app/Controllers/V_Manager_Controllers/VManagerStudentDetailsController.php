<?php
class VManagerStudentDetailsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/VolunteerManagerModel.php';
        
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $student_id = $_GET['id'] ?? null;
        if (!$student_id) {
            header('Location: /v_manager/volunteers');
            exit();
        }

        $student = $this->model->getStudentFullDetails($student_id);
        $attendance = $this->model->getStudentAttendanceLogs($student_id);

        if (!$student) {
            die("الطالب غير موجود");
        }

        $required = $student['required_hours'] > 0 ? $student['required_hours'] : 50;
        $progress = min(100, round(($student['completed_hours'] / $required) * 100));

        require_once VIEW_PATH . '/v_manager/v_manager_student_details.php';
    }
}