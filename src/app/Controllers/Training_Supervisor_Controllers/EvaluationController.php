<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class EvaluationController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }


    public function create() {
        if (!isset($_GET['student_id'])) {
            header('Location: /supervisor/supervisor-students');
            exit;
        }

        $student = $this->model->getStudentById($_GET['student_id'], $_SESSION['user_id']);
        
        if (!$student) {
            die("الطالب غير موجود أو غير تابع لك.");
        }

        $data = ['student' => $student];
        require_once VIEW_PATH . '/supervisor/supervisor-evaluation.php';
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id'    => $_POST['student_id'],
                'supervisor_id' => $_SESSION['user_id'],
                'final_grade'   => $_POST['final_grade'],
                'notes'         => $_POST['notes']
            ];

            if ($this->model->saveFinalEvaluation($data)) {
                $_SESSION['success_msg'] = "تم حفظ التقييم النهائي بنجاح.";
                header('Location: /supervisor/supervisor-students');
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء حفظ التقييم.";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            exit;
        }
    }
}