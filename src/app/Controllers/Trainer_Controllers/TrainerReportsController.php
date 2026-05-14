<?php
class TrainerReportsController {
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
        $students = $this->model->getMyStudents($trainer_id);
        require_once '../src/views/trainer/trainer_reports.php';
    }

    public function processMonthly() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id' => $_POST['student_id'],
                'supervisor_id' => $_SESSION['user_id'],
                'period' => $_POST['period'],
                'rating' => $_POST['rating'],
                'summary' => $_POST['summary']
            ];
            $this->model->saveMonthlyReport($data);
            header('Location: /trainer/reports?success=monthly');
        }
    }

    public function processFinal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id' => $_POST['student_id'],
                'supervisor_id' => $_SESSION['user_id'],
                'total_hours' => $_POST['total_hours'],
                'crit_1' => $_POST['crit_1'],
                'crit_2' => $_POST['crit_2'],
                'crit_3' => $_POST['crit_3'],
                'feedback' => $_POST['feedback']
            ];
            $this->model->saveFinalEvaluation($data);
            header('Location: /trainer/reports?success=final');
        }
    }
}