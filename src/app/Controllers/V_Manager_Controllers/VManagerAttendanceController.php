<?php
class AttendanceController {
    private $model;
    private $db;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->db = $db;

        require_once APP_PATH . '/models/VolunteerManagerModel.php';
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        $volunteers = $this->model->getVolunteersForAttendance($manager_id);
        require_once VIEW_PATH . '/v_manager/v_manager_attendance.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'studentID' => $_POST['student_id'],
                'date'      => date('Y-m-d'),
                'status'    => $_POST['status'],
                'checkIn'   => $_POST['check_in'],  
                'checkOut'  => $_POST['check_out'], 
                'hours'     => $_POST['hours'],
                'notes'     => $_POST['notes']
            ];

            try {
                $success = $this->model->saveAttendance($data);
                echo json_encode(['success' => $success]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'error'   => $e->getMessage()
                ]);
            }

            exit;
        }
    }
}