<?php
class TrainerModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDashboardStats($trainer_id) {
        $stats = [];
        $sql = "SELECT COUNT(*) FROM student_supervisor WHERE supervisor_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['total_students'] = $stmt->fetchColumn();
        $sql = "SELECT COUNT(*) FROM attendance a 
                JOIN student_supervisor ss ON a.student_id = ss.student_id 
                WHERE ss.supervisor_id = ? AND a.status = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['pending_attendance'] = $stmt->fetchColumn();
        $sql = "SELECT COUNT(*) FROM reports r 
                JOIN student_supervisor ss ON r.student_id = ss.student_id 
                WHERE ss.supervisor_id = ? AND r.status = 'completed'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        $stats['completed_reports'] = $stmt->fetchColumn();

        return $stats;
    }

    public function getTrainerStudents($trainer_id) {
        $sql = "SELECT u.id, u.name, u.major, u.total_hours
                FROM users u
                JOIN student_supervisor ss ON u.id = ss.student_id
                WHERE ss.supervisor_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$trainer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getTrainerProfile($trainer_id) {
    $sql = "SELECT u.*, org.name as organization_name 
            FROM users u
            LEFT JOIN organizations org ON u.organization_id = org.id
            WHERE u.id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$trainer_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateProfile($trainer_id, $data) {
    $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
    return $this->db->prepare($sql)->execute([
        $data['name'],
        $data['email'],
        $data['phone'],
        $trainer_id
    ]);
}

public function updatePassword($trainer_id, $new_password) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    return $this->db->prepare($sql)->execute([$hashed_password, $trainer_id]);
}

public function getTodayAttendance($trainer_id) {
    $today = date('Y-m-d');
    $sql = "SELECT u.id as student_id, u.name as student_name, u.major, 
                   a.arrival_time, a.departure_time, a.status, a.total_hours
            FROM users u
            JOIN student_supervisor ss ON u.id = ss.student_id
            LEFT JOIN attendance a ON u.id = a.student_id AND a.date = ?
            WHERE ss.supervisor_id = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$today, $trainer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveAttendance($data) {
    $sql = "INSERT INTO attendance (student_id, date, arrival_time, departure_time, total_hours, status)
            VALUES (:student_id, :date, :arrival_time, :departure_time, :total_hours, :status)
            ON DUPLICATE KEY UPDATE 
            arrival_time = VALUES(arrival_time),
            departure_time = VALUES(departure_time),
            total_hours = VALUES(total_hours),
            status = VALUES(status)";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}

public function getMyStudents($trainer_id) {
    $sql = "SELECT u.id, u.name FROM users u 
            JOIN student_supervisor ss ON u.id = ss.student_id 
            WHERE ss.supervisor_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$trainer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveMonthlyReport($data) {
    $sql = "INSERT INTO monthly_reports (student_id, supervisor_id, period, rating, summary, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    return $this->db->prepare($sql)->execute([
        $data['student_id'], $data['supervisor_id'], $data['period'], $data['rating'], $data['summary']
    ]);
}

public function saveFinalEvaluation($data) {
    $sql = "INSERT INTO final_evaluations (student_id, supervisor_id, total_hours, crit_1, crit_2, crit_3, feedback, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    return $this->db->prepare($sql)->execute([
        $data['student_id'], $data['supervisor_id'], $data['total_hours'], 
        $data['crit_1'], $data['crit_2'], $data['crit_3'], $data['feedback']
    ]);
}

public function getStudentDetails($student_id) {
    $sql = "SELECT u.id, u.name, u.email, u.major, u.student_id_number, u.created_at as start_date,
            (SELECT SUM(total_hours) FROM attendance WHERE student_id = u.id AND status = 'present') as completed_hours
            FROM users u
            WHERE u.id = ? AND u.role = 'student'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function getStudentReports($student_id, $trainer_id) {
    $sql = "SELECT * FROM monthly_reports 
            WHERE student_id = ? AND supervisor_id = ? 
            ORDER BY created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id, $trainer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getRecentStudentEvents($trainer_id) {
    $sql = "
        (SELECT 
            u.name as student_name, 
            'report' as type, 
            CONCAT('قام المتدرب ', u.name, ' بإرسال تقريره الدوري.') as message,
            r.created_at as event_time
        FROM monthly_reports r
        JOIN users u ON r.student_id = u.id
        WHERE r.supervisor_id = ?)

        UNION ALL

        (SELECT 
            u.name as student_name, 
            'attendance' as type, 
            CONCAT('تم تسجيل حضور جديد للمتدرب ', u.name) as message,
            a.created_at as event_time
        FROM attendance a
        JOIN users u ON a.student_id = u.id
        JOIN student_supervisor ss ON u.id = ss.student_id
        WHERE ss.supervisor_id = ? AND DATE(a.created_at) = CURDATE())

        ORDER BY event_time DESC LIMIT 15";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$trainer_id, $trainer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}