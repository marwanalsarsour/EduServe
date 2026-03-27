<?php

class student_ProfileController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit(); }

        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');

        $student = $model->getStudentProfile($studentId);
        $certsCount = $model->getCertificatesCount($studentId);
        $trainingCount = $model->getAcceptedTrainingCount($studentId);
        $volunteerCount = 0; 

        require_once VIEW_PATH . '/student/student_profile.php';
    }

    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');

        $name  = $_POST['fullName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pass  = $_POST['password'];
        $confirmPass = $_POST['confirm_password'];

        if (!empty($pass) && $pass !== $confirmPass) {
            $_SESSION['error'] = "كلمات المرور غير متطابقة!";
            header("Location: /student_profile");
            exit();
        }

        if ($model->updateStudentProfile($studentId, $name, $email, $phone, (!empty($pass) ? $pass : null))) {
            $_SESSION['msg'] = "تم تحديث البيانات بنجاح";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء التحديث";
        }

        header("Location: /student_profile");
        exit();
    }
}