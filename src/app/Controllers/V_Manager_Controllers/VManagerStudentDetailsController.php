<?php
class VManagerStudentDetailsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

        $required = $student['requiredVolunteerHours']
            ?? $student['required_hours']
            ?? 50;

        $required = (float)$required;
        if ($required <= 0) $required = 50;

        $completed = $student['completed_hours'] ?? 0;

        $progress = ($required > 0)
            ? min(100, round(($completed / $required) * 100))
            : 0;
        $successMessage = $_SESSION['success'] ?? '';
        $errorMessage   = $_SESSION['error'] ?? '';

        unset($_SESSION['success'], $_SESSION['error']);

        require_once VIEW_PATH . '/v_manager/v_manager_student_details.php';
    }

    public function handleCompleteVolunteer($studentID) {

        $student = $this->model->getStudentFullDetails($studentID);

        if (!$student) {
            $_SESSION['error'] = "الطالب غير موجود.";
            header("Location: /v_manager/student-details?id={$studentID}");
            exit();
        }

        // 🔥 نفس التوحيد هنا
        $required = $student['requiredVolunteerHours']
            ?? $student['required_hours']
            ?? 50;

        $required = (float)$required;
        if ($required <= 0) $required = 50;

        $completed = $student['completed_hours'] ?? 0;

        if ($completed < $required) {
            $_SESSION['error'] = "لا يمكن إنهاء التطوع قبل استكمال الساعات المطلوبة.";
            header("Location: /v_manager/student-details?id={$studentID}");
            exit();
        }

        $this->model->markVolunteerComplete($studentID);

        $_SESSION['success'] = "تم تأكيد إنهاء التطوع بنجاح.";

        header("Location: /v_manager/student-details?id={$studentID}");
        exit();
    }
}