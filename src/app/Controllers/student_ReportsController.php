<?php
require_once __DIR__ . '/../Models/StudentModel.php';
class student_ReportsController {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['user_id']) ||
            ($_SESSION['user_role'] !== 'طالب' &&
             $_SESSION['user_role'] !== 'student')
        ) {
            header("Location: /login");
            exit();
        }

        $studentId = $_SESSION['user_id'];

        $model = new StudentModel($this->db);

        $reports = $model->getStudentReports($studentId);

        require_once VIEW_PATH . '/student/student_reports.php';
    }

    public function showSubmitForm() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['user_id']) ||
            ($_SESSION['user_role'] !== 'طالب' &&
             $_SESSION['user_role'] !== 'student')
        ) {
            header("Location: /login");
            exit();
        }

        require_once VIEW_PATH . '/student/student_report-submit.php';
    }

    public function submit() {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION['user_id']) ||
        ($_SESSION['user_role'] !== 'طالب' &&
         $_SESSION['user_role'] !== 'student')
    ) {
        header("Location: /login");
        exit();
    }

    $studentId = $_SESSION['user_id'];

    $model = new StudentModel($this->db);

    $reportType = trim($_POST['reportType'] ?? '');
    $content = trim($_POST['content'] ?? '');

   $opportunityId = $model->getAcceptedTrainingOpportunityId($studentId);
   if (!$opportunityId) {
    $_SESSION['error'] = "لا يوجد فرصة تدريب مقبولة لرفع التقرير.";
    header("Location: /student_report-submit");
    exit();
}

    $filePath = null;

    if (
        isset($_FILES['report_file']) &&
        $_FILES['report_file']['error'] === UPLOAD_ERR_OK
    ) {

        $allowedExtensions = [
            'pdf',
            'doc',
            'docx',
            'jpg',
            'jpeg',
            'png'
        ];

        $extension = strtolower(
            pathinfo(
                $_FILES['report_file']['name'],
                PATHINFO_EXTENSION
            )
        );

        if (!in_array($extension, $allowedExtensions)) {

            $_SESSION['error'] =
                "نوع الملف غير مسموح.";

            header("Location: /student_report-submit");
            exit();
        }

        $uploadDir = BASE_PATH . '/public/uploads/reports/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName =
            "report_" .
            $studentId .
            "_" .
            time() .
            "." .
            $extension;

        if (
            move_uploaded_file(
                $_FILES['report_file']['tmp_name'],
                $uploadDir . $fileName
            )
        ) {

            $filePath =
                '/uploads/reports/' .
                $fileName;
        }
    }

    $success = $model->submitReport(
        $reportType,
        $content,
        $filePath,
        $studentId,
        $opportunityId
    );

    if ($success) {

        $_SESSION['msg'] =
            "تم رفع التقرير بنجاح.";

        header("Location: /student_reports");
        exit();
    }

    $_SESSION['error'] =
        "حدث خطأ أثناء رفع التقرير.";

    header("Location: /student_report-submit");
    exit();
}
}
