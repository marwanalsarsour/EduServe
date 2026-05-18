<?php
class AttendanceController {
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
        $volunteers = $this->model->getVolunteersForAttendance($manager_id);
        require_once '../src/views/v_manager/v_manager_attendance.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id'  => $_POST['student_id'],
                'date'        => date('Y-m-d'),
                'status'      => $_POST['status'],
                'total_hours' => $_POST['hours'],
                'notes'       => $_POST['notes']
            ];
            
            if ($this->model->saveAttendance($data)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }
}