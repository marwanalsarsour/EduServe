<?php
class VolunteerManagerModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getActiveVolunteersCount($manager_id) {
        $sql = "SELECT COUNT(DISTINCT student_id) as count 
                FROM student_supervisor 
                WHERE supervisor_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getTotalCompletedHours($manager_id) {
        $sql = "SELECT SUM(a.total_hours) as total 
                FROM attendance a
                JOIN student_supervisor ss ON a.student_id = ss.student_id
                WHERE ss.supervisor_id = ? AND a.status = 'present'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getManagerProfile($manager_id) {
    $sql = "SELECT u.*, org.name as organization_name 
            FROM users u
            LEFT JOIN organizations org ON u.organization_id = org.id
            WHERE u.id = ? AND u.role = 'v_manager'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manager_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateProfile($manager_id, $name, $email, $phone) {
    $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$name, $email, $phone, $manager_id]);
}

public function getMyVolunteers($manager_id, $search = '') {
    $params = [$manager_id];
    $searchQuery = "";
    
    if (!empty($search)) {
        $searchQuery = " AND (u.name LIKE ? OR u.student_id_number LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $sql = "
        SELECT 
            u.id, 
            u.name, 
            u.student_id_number, 
            u.major, 
            COALESCE(SUM(a.total_hours), 0) as completed_hours,
            u.required_hours
        FROM users u
        JOIN student_supervisor ss ON u.id = ss.student_id
        LEFT JOIN attendance a ON u.id = a.student_id AND a.status = 'present'
        WHERE ss.supervisor_id = ? $searchQuery
        GROUP BY u.id";
        
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getStudentFullDetails($student_id) {
    $sql = "SELECT id, name, student_id_number, major, required_hours, 
            (SELECT COALESCE(SUM(total_hours), 0) FROM attendance WHERE student_id = ? AND status = 'present') as completed_hours
            FROM users 
            WHERE id = ? AND role = 'student'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id, $student_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getStudentAttendanceLogs($student_id) {
    $sql = "SELECT date, total_hours, notes, status 
            FROM attendance 
            WHERE student_id = ? 
            ORDER BY date DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getReportsSummary($manager_id) {
    $sql = "
        SELECT 
            COUNT(DISTINCT ss.student_id) as total_volunteers,
            COALESCE(SUM(CASE WHEN a.status = 'pending' THEN a.total_hours ELSE 0 END), 0) as pending_hours,
            COALESCE(SUM(CASE WHEN a.status = 'present' THEN a.total_hours ELSE 0 END), 0) as approved_hours,
            (SELECT COUNT(*) FROM users u 
             JOIN student_supervisor ss2 ON u.id = ss2.student_id 
             WHERE ss2.supervisor_id = ? AND 
             (SELECT SUM(total_hours) FROM attendance WHERE student_id = u.id AND status = 'present') >= u.required_hours
            ) as completed_volunteers
        FROM student_supervisor ss
        LEFT JOIN attendance a ON ss.student_id = a.student_id
        WHERE ss.supervisor_id = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manager_id, $manager_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getVolunteersPerformance($manager_id) {
    $sql = "
        SELECT 
            u.id, u.name, u.student_id_number, u.required_hours,
            COALESCE(SUM(CASE WHEN a.status = 'present' THEN a.total_hours ELSE 0 END), 0) as approved_hours,
            (SELECT notes FROM attendance WHERE student_id = u.id AND notes IS NOT NULL ORDER BY date DESC LIMIT 1) as last_note
        FROM users u
        JOIN student_supervisor ss ON u.id = ss.student_id
        LEFT JOIN attendance a ON u.id = a.student_id
        WHERE ss.supervisor_id = ?
        GROUP BY u.id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manager_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getVolunteersForAttendance($manager_id) {
    $date = date('Y-m-d');
    $sql = "
        SELECT 
            u.id, u.name, u.student_id_number,
            a.status, a.total_hours, a.notes
        FROM users u
        JOIN student_supervisor ss ON u.id = ss.student_id
        LEFT JOIN attendance a ON u.id = a.student_id AND a.date = ?
        WHERE ss.supervisor_id = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$date, $manager_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveAttendance($data) {
    $sql = "INSERT INTO attendance (student_id, date, status, total_hours, notes) 
            VALUES (:student_id, :date, :status, :total_hours, :notes)
            ON DUPLICATE KEY UPDATE 
            status = VALUES(status), 
            total_hours = VALUES(total_hours), 
            notes = VALUES(notes)";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}

public function getDynamicNotifications($manager_id) {
    $sql = "
        (SELECT 
            u.id,
            'اعتماد ساعات' as title,
            CONCAT('قام المشرف الأكاديمي باعتماد ', a.total_hours, ' ساعة للطالب ', u.name) as message,
            a.updated_at as event_time,
            'present' as status
        FROM attendance a
        JOIN users u ON a.student_id = u.id
        JOIN student_supervisor ss ON u.id = ss.student_id
        WHERE ss.supervisor_id = ? AND a.status = 'present' 
        AND a.updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY))

        UNION ALL

        (SELECT 
            u.id,
            'متطوع جديد' as title,
            CONCAT('تم إضافة المتطوع ', u.name, ' إلى قائمة إشرافك.') as message,
            ss.created_at as event_time,
            'new' as status
        FROM student_supervisor ss
        JOIN users u ON ss.student_id = u.id
        WHERE ss.supervisor_id = ?
        AND ss.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY))

        UNION ALL

        (SELECT 
            u.id,
            'إكمال الساعات' as title,
            CONCAT('أتم الطالب ', u.name, ' جميع الساعات المطلوبة بنجاح.') as message,
            NOW() as event_time,
            'completed' as status
        FROM users u
        JOIN student_supervisor ss ON u.id = ss.student_id
        WHERE ss.supervisor_id = ? 
        AND (SELECT SUM(total_hours) FROM attendance WHERE student_id = u.id AND status = 'present') >= u.required_hours)

        ORDER BY event_time DESC LIMIT 20";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manager_id, $manager_id, $manager_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}