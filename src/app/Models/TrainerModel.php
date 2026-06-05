<?php

class TrainerModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDashboardStats($trainer_id) {
        $stats = [];
        $sql = "SELECT COUNT(*) FROM OpportunityRequest WHERE entityID = ? AND entityStatus = 'مقبول'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['total_students'] = $stmt->fetchColumn();

        $sql = "SELECT COUNT(*) FROM Attendance WHERE entityID = ? AND status = 'متأخر'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['pending_attendance'] = $stmt->fetchColumn();

        $sql = "SELECT COUNT(*) FROM StudentReport r 
                JOIN OpportunityRequest ar ON r.studentID = ar.studentID 
                WHERE ar.entityID = ? AND r.reportType = 'نهائي'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['completed_reports'] = $stmt->fetchColumn();

        return $stats;
    }

    public function getTrainerStudents($trainer_id) {
        $sql = "SELECT u.userID as id, u.fullName as name, s.majorName as major, s.academicYear as total_hours
                FROM Users u
                JOIN Student s ON u.userID = s.studentID
                JOIN OpportunityRequest ar ON s.studentID = ar.studentID
                WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrainerProfile($trainer_id) {
        $sql = "SELECT u.*, ee.entityName as organization_name 
                FROM Users u
                LEFT JOIN ExternalEntity ee ON u.userID = ee.entityID
                WHERE u.userID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($trainer_id, $data) {
        $sql = "UPDATE Users SET fullName = ?, email = ?, phoneNumber = ? WHERE userID = ?";
        return $this->db->prepare($sql)->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $trainer_id
        ]);
    }

    public function updatePassword($trainer_id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE Users SET password = ? WHERE userID = ?";
        return $this->db->prepare($sql)->execute([$hashed_password, $trainer_id]);
    }

    public function getTodayAttendance($trainer_id) {
        $today = date('Y-m-d');
        $sql = "SELECT u.userID as student_id, u.fullName as student_name, s.majorName as major, 
                       a.checkIn as arrival_time, a.checkOut as departure_time, a.status, a.hours as total_hours
                FROM Users u
                JOIN Student s ON u.userID = s.studentID
                JOIN OpportunityRequest ar ON s.studentID = ar.studentID
                LEFT JOIN Attendance a ON s.studentID = a.studentID AND a.date = ?
                WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today, $trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveAttendance($data) {
        $sql = "INSERT INTO Attendance (attendanceID, date, hours, studentID, opportunityID, entityID, status, checkIn, checkOut)
                VALUES (:attendanceID, :date, :hours, :studentID, :opportunityID, :entityID, :status, :checkIn, :checkOut)
                ON DUPLICATE KEY UPDATE 
                checkIn = VALUES(checkIn),
                checkOut = VALUES(checkOut),
                hours = VALUES(hours),
                status = VALUES(status)";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getMyStudents($trainer_id) {
        $sql = "SELECT u.userID as id, u.fullName as name FROM Users u 
                JOIN OpportunityRequest ar ON u.userID = ar.studentID 
                WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveMonthlyReport($data) {
        $sql = "INSERT INTO EvaluationReport (reportID, content, data, entityID, studentID, period, rating) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->db->prepare($sql)->execute([
            $data['reportID'], $data['summary'], $data['date'], $data['supervisor_id'], $data['student_id'], $data['period'], $data['rating']
        ]);
    }

    public function saveFinalEvaluation($data) {
        $sql = "INSERT INTO FinalEvaluations (evaluationID, studentID, entityID, totalHours, crit1, crit2, crit3, feedback, createdAt) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        return $this->db->prepare($sql)->execute([
            $data['evaluationID'], $data['student_id'], $data['supervisor_id'], $data['total_hours'], 
            $data['crit_1'], $data['crit_2'], $data['crit_3'], $data['feedback']
        ]);
    }

    public function getStudentDetails($student_id) {
        $sql = "SELECT u.userID as id, u.fullName as name, u.email, s.majorName as major, s.academicYear as student_id_number,
                (SELECT SUM(hours) FROM Attendance WHERE studentID = u.userID AND status = 'حاضر') as completed_hours
                FROM Users u
                JOIN Student s ON u.userID = s.studentID
                WHERE u.userID = ? AND u.role = 'طالب'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentReports($student_id, $trainer_id) {
        $sql = "SELECT er.*, er.content as summary, er.data as created_at FROM EvaluationReport er 
                WHERE er.studentID = ? AND er.entityID = ? 
                ORDER BY er.data DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$student_id, $trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentStudentEvents($trainer_id) {
        $sql = "
            (SELECT 
                u.fullName as student_name, 
                'report' as type, 
                CONCAT('قامت الجهة الخارجية بإرسال تقرير دوري للمتدرب ', u.fullName) as message,
                er.data as event_time
            FROM EvaluationReport er
            JOIN Users u ON er.studentID = u.userID
            WHERE er.entityID = ?)

            UNION ALL

            (SELECT 
                u.fullName as student_name, 
                'attendance' as type, 
                CONCAT('تم تسجيل حضور جديد للمتدرب ', u.fullName) as message,
                a.date as event_time
            FROM Attendance a
            JOIN Users u ON a.studentID = u.userID
            WHERE a.entityID = ? AND a.date = CURDATE())

            ORDER BY event_time DESC LIMIT 15";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id, $trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}