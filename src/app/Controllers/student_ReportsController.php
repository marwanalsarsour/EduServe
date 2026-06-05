<?php


require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_ReportsController {
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
        $reports = $model->getStudentReports($studentId);

        require_once VIEW_PATH . '/student/student_reports.php';
    }

    public function showSubmitForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) { 
            header("Location: /login"); 
            exit(); 
        }

        require_once VIEW_PATH . '/student/student_report-submit.php';
    }

    public function submit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) { 
            header("Location: /login"); 
            exit(); 
        }

        $studentId = $_SESSION['user_id'];
        
        $model = new StudentModel($this->db);

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