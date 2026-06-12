<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class ReportReviewController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['user_id'])) { 
            header('Location: /login'); 
            exit; 
        }
    }

    public function index() {

    $reports = $this->model->getPendingReports($_SESSION['user_id']);

    $data = [
        'reports' => $reports
    ];

    require_once VIEW_PATH . '/supervisor/supervisor-reports.php';
}

    public function process($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending'; 
            $feedback = $_POST['feedback'] ?? '';

            
            $_SESSION['notifications'][] = [
                'title' => ($status == 'approved' ? 'تم قبول تقريرك' : 'تم رفض تقريرك'),
                'message' => 'قام المشرف بمراجعة التقرير. ملاحظات: ' . ($feedback ?: 'لا توجد ملاحظات.'),
                'time_ago' => 'الآن',
                'is_read' => false
            ];
            
            $_SESSION['success_msg'] = "تمت معالجة التقرير بنجاح (سيتم حفظ النتيجة عند إضافة جداول المراجعة).";
            
            header('Location: /supervisor/supervisor-reports');
            exit;
        }
    }
}