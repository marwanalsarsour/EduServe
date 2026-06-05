<?php

require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_ProfileController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) { 
            header("Location: /login"); 
            exit(); 
        }

        $studentId = $_SESSION['user_id'];
        
        $model = new StudentModel($this->db);

        $student = $model->getStudentProfile($studentId);
        $certsCount = $model->getCertificatesCount($studentId);
        $trainingCount = $model->getAcceptedTrainingCount($studentId);
        $volunteerCount = 0; 

        require_once VIEW_PATH . '/student/student_profile.php';
    }

    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) { 
            header("Location: /login"); 
            exit(); 
        }

        $studentId = $_SESSION['user_id'];
        
        $model = new StudentModel($this->db);

        $name  = $_POST['fullName'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $pass  = $_POST['password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (!empty($pass) && $pass !== $confirmPass) {
            $_SESSION['error'] = "كلمات المرور غير متطابقة!";
            header("Location: /student_profile");
            exit();
        }

        if ($model->updateStudentProfile($studentId, $name, $email, $phone, (!empty($pass) ? $pass : null))) {
            $_SESSION['msg'] = "تم تحديث البيانات بنجاح";
            $_SESSION['user_name'] = $name; 
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء التحديث";
        }

        header("Location: /student_profile");
        exit();
    }
}