<?php
require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_AttendanceController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $model = new StudentModel($this->db);

        $opportunity = $model->getApprovedOpportunity($studentId);
        $attendanceRecords = $model->getFullAttendance($studentId);

        require_once VIEW_PATH . '/student/student_attendance.php';
    }

    public function save() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'غير مصرح']);
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $model = new StudentModel($this->db);
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            if (!isset($data['records']) || !is_array($data['records'])) {
                throw new Exception('بيانات غير صحيحة');
            }

            foreach ($data['records'] as $record) {
                $checkIn = $record['check_in'] ?? null;
                $checkOut = $record['check_out'] ?? null;
                $hours = 0.00;
                if (!empty($checkIn) && !empty($checkOut)) {
                    $start = new DateTime($checkIn);
                    $end = new DateTime($checkOut);
                    if ($end < $start) {
                        $end->modify('+1 day');
                    }
                    
                    $interval = $start->diff($end);
                    $hours = $interval->h + ($interval->i / 60);
                }

                $model->updateAttendanceRecord(
                    $record['id'], 
                    $studentId, 
                    $checkIn, 
                    $checkOut, 
                    number_format($hours, 2, '.', '') 
                );
            }
            
            echo json_encode(['status' => 'success', 'message' => 'تم حفظ التغييرات بنجاح']);
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }
}