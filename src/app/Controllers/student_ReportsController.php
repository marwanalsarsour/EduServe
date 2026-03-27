<?php

class student_ReportsController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit(); }

        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');
        $reports = $model->getStudentReports($studentId);

        require_once VIEW_PATH . '/student/student_reports.php';
    }

    public function submit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');

        $reportType = $_POST['reportType'] ?? 'General';
        $content = $_POST['content'] ?? '';
        $opportunityId = $model->getAcceptedOpportunityId($studentId);

        $filePath = null;
        if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/reports/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $extension = pathinfo($_FILES['report_file']['name'], PATHINFO_EXTENSION);
            $fileName = "report_" . $studentId . "_" . time() . "." . $extension;
            
            if (move_uploaded_file($_FILES['report_file']['tmp_name'], $uploadDir . $fileName)) {
                $filePath = '/uploads/reports/' . $fileName;
            }
        }

        if ($model->submitReport($reportType, $content, $filePath, $studentId, $opportunityId)) {
            $_SESSION['msg'] = "تم رفع التقرير بنجاح.";
            header("Location: /student_reports");
            exit();
        } else {
            die("خطأ فني في رفع التقرير.");
        }
    }
}