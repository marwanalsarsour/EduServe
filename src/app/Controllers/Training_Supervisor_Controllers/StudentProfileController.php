<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class StudentProfileController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
    }

    public function show($student_id) {
        $student = $this->model->getFullStudentDetails($student_id);
        
        if (!$student) {
            die("الطالب غير موجود.");
        }

        $raw_reports = $this->model->getStudentReports($student_id);
        $reports = [];
        
        foreach ($raw_reports as $r) {
            $status_map = [
                'approved' => ['text' => 'مقبول', 'color' => 'success'],
                'pending'  => ['text' => 'قيد الانتظار', 'color' => 'warning text-dark'],
                'rejected' => ['text' => 'مرفوض', 'color' => 'danger']
            ];
            
            $reports[] = [
                'title' => $r['title'],
                'status' => $status_map[$r['status']]['text'] ?? $r['status'],
                'status_color' => $status_map[$r['status']]['color'] ?? 'secondary'
            ];
        }

        $data = [
            'student' => $student,
            'student_reports' => $reports
        ];

        require_once VIEW_PATH . '/supervisor/supervisor-student-details.php';
    }
}