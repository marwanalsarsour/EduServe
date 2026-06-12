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
        $raw_students = $this->model->getSupervisedStudents($_SESSION['user_id'], $search);
        
        $students = [];
      // داخل دالة index في الـ Controller
foreach ($raw_students as $s) {
    $completed = $s['completed_hours'] ?? 0;
    $required = $s['required_hours'] ?: 120; // افترضنا 120 ساعة إذا كانت فارغة
    $percent = min(100, ($completed / $required) * 100);

    $color = 'primary';
    if ($percent >= 100) $color = 'success';
    elseif ($percent < 20) $color = 'danger';
    elseif ($percent < 50) $color = 'warning';

    $students[] = [
        'id' => $s['id'],
        'name' => $s['name'],
        'major' => $s['major'],
        'company' => $s['company'] ?? 'غير محدد',
        'completed_hours' => (int)$completed,
        'required_hours' => (int)$required,
        'percent' => round($percent),
        'color' => $color, // أضفنا هذا المفتاح المهم للواجهة
        'status' => ($percent >= 100 ? 'منتهي' : 'قيد التدريب'),
        'has_alert' => ($s['pending_reports_count'] > 0) 
    ];
}

        $data = ['students' => $students];
        require_once VIEW_PATH . '/supervisor/supervisor-students.php';
    }
}