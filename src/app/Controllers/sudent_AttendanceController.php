<?php

class student_AttendanceController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');

        $opportunity = $model->getApprovedOpportunity($studentId);
        $attendanceRecords = $model->getFullAttendance($studentId);

        require_once VIEW_PATH . '/student/student_attendance.php';
    }

    public function save() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $studentId = $_SESSION['user_id'];
        $model = $this->model('StudentModel');
        
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            foreach ($data['records'] as $record) {
               
                $start = new DateTime($record['check_in']);
                $end = new DateTime($record['check_out']);
                $hours = ($start->diff($end))->h + (($start->diff($end))->i / 60);

                
                $model->updateAttendanceRecord($record['id'], $studentId, $record['check_in'], $record['check_out'], $hours);
            }
            echo json_encode(['status' => 'success', 'message' => 'تم حفظ التغييرات بنجاح']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ']);
        }
    }
}