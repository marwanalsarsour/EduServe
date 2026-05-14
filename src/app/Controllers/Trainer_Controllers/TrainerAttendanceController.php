<?php
class TrainerAttendanceController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/TrainerModel.php';
        $this->model = new TrainerModel($this->db);
    }

    public function index() {
        $trainer_id = $_SESSION['user_id'];
        $attendance_list = $this->model->getTodayAttendance($trainer_id);
        require_once '../src/views/trainer/trainer_attendance.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && date('H') < 17) {
            foreach ($_POST['attendance'] as $student_id => $data) {
                $start = new DateTime($data['arrival']);
                $end = new DateTime($data['departure']);
                $diff = $start->diff($end);
                $hours = $diff->h + ($diff->i / 60);

                $saveData = [
                    'student_id' => $student_id,
                    'date' => date('Y-m-d'),
                    'arrival_time' => $data['arrival'],
                    'departure_time' => $data['departure'],
                    'total_hours' => round($hours, 2),
                    'status' => $data['status']
                ];
                $this->model->saveAttendance($saveData);
            }
            header('Location: /trainer/attendance?success=1');
        }
    }
}