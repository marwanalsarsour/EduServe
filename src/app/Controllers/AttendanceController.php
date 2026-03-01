<?php
require_once __DIR__ . '/../Core/Database.php';

class AttendanceController {
    
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $db = (new Database())->getConnection();
        $studentId = $_SESSION['user_id'];

        
        $stmt = $db->prepare("
            SELECT o.Title, o.OrganizationName, o.Type 
            FROM Opportunity o
            JOIN OpportunityRequest orq ON o.OpportunityID = orq.OpportunityID
            WHERE orq.StudentID = :sid AND orq.Status = 'Approved'
            LIMIT 1
        ");
        $stmt->execute(['sid' => $studentId]);
        $opportunity = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $stmt = $db->prepare("SELECT * FROM Attendance WHERE StudentID = :sid ORDER BY Date DESC");
        $stmt->execute(['sid' => $studentId]);
        $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once VIEW_PATH . '/student/student_attendance.php';
    }

   
    public function save() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = (new Database())->getConnection();
        
        $data = json_decode(file_get_contents("php://input"), true);
        $studentId = $_SESSION['user_id'];

        try {
            foreach ($data['records'] as $record) {
                
                $start = new DateTime($record['check_in']);
                $end = new DateTime($record['check_out']);
                $interval = $start->diff($end);
                $hours = $interval->h + ($interval->i / 60);

                $stmt = $db->prepare("
                    UPDATE Attendance 
                    SET CheckIn = :cin, CheckOut = :cout, HoursWorked = :hw 
                    WHERE AttendanceID = :aid AND StudentID = :sid
                ");
                $stmt->execute([
                    'cin' => $record['check_in'],
                    'cout' => $record['check_out'],
                    'hw' => $hours,
                    'aid' => $record['id'],
                    'sid' => $studentId
                ]);
            }
            echo json_encode(['status' => 'success', 'message' => 'تم حفظ التغييرات بنجاح']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ']);
        }
    }
}