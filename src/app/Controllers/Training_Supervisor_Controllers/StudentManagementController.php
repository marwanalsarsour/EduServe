<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class StudentManagementController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        // جلب البيانات من الموديل
        $raw_students = $this->model->getSupervisedStudents($_SESSION['user_id'], $search);
        
        $students = [];
        foreach ($raw_students as $s) {
            // استخدام المعامل ?? 0 لحماية الكود من الـ Undefined index
            // ملاحظة: تأكد أن أسماء الأعمدة هنا تطابق ما يعيده استعلام الـ SQL في الموديل
            $completed = $s['completed_hours'] ?? 0;
            $required  = $s['required_hours'] ?? 0; 
            $pending_reports = $s['pending_reports_count'] ?? 0;
            
            // تجنب القسمة على صفر
            $effective_required = ($required > 0) ? $required : 1; 
            $percent = ($completed / $effective_required) * 100;

            $status_class = 'primary';
            if ($percent >= 100) $status_class = 'success';
            elseif ($percent < 20) $status_class = 'danger';
            elseif ($percent < 50) $status_class = 'warning';

$students[] = [
    'id'              => $s['id'] ?? 0,
    'name'            => $s['name'] ?? 'غير معروف',
    'major'           => $s['major'] ?? 'غير محدد',
    'company'         => $s['company'] ?? 'غير محدد',
    'completed_hours' => (int)$completed,
    'required_hours'  => (int)$required,
    'percent'         => round($percent), // أضفنا هذا المفتاح
    'color'           => $status_class,   // أضفنا هذا المفتاح ليعمل كـ color
    'status'          => ($percent >= 100 ? 'منتهي' : 'قيد التدريب'),
    'status_class'    => $status_class,
    'has_alert'       => ($pending_reports > 0) 
];
        }

        $data = ['students' => $students];
        require_once VIEW_PATH . '/supervisor/supervisor-students.php';
    }
}