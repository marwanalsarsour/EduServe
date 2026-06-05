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
        
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'طالب' && $_SESSION['user_role'] !== 'student')) {
            echo json_encode(['status' => 'error', 'message' => 'غير مصرح لك بالقيام بهذا الإجراء']);
            exit();
        }

        $studentId = $_SESSION['user_id'];
        
        $model = new StudentModel($this->db);
        
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            if (isset($data['records']) && is_array($data['records'])) {
                foreach ($data['records'] as $record) {
                   
                    $start = new DateTime($record['check_in']);
                    $end = new DateTime($record['check_out']);
                    $hours = ($start->diff($end))->h + (($start->diff($end))->i / 60);

                    $model->updateAttendanceRecord($record['id'], $studentId, $record['check_in'], $record['check_out'], $hours);
                }
                echo json_encode(['status' => 'success', 'message' => 'تم حفظ التغييرات بنجاح']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'البيانات المرسلة غير صالحة']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ']);
        }
    }
}