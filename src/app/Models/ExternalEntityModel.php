<?php
class ExternalEntityModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrgDetails($org_id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id AND role = 'external_entity'");
        $stmt->execute([':id' => $org_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDashboardStats($org_id) {
        $stats = [];
        
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM opportunities WHERE organization_id = :id");
        $stmt->execute([':id' => $org_id]);
        $stats['opps_count'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM applications a 
                                    JOIN opportunities o ON a.opportunity_id = o.id 
                                    WHERE o.organization_id = :id AND a.status = 'pending'");
        $stmt->execute([':id' => $org_id]);
        $stats['pending_apps'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM applications a 
                                    JOIN opportunities o ON a.opportunity_id = o.id 
                                    WHERE o.organization_id = :id");
        $stmt->execute([':id' => $org_id]);
        $stats['total_apps'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM applications a 
                                    JOIN opportunities o ON a.opportunity_id = o.id 
                                    WHERE o.organization_id = :id AND a.status = 'approved'");
        $stmt->execute([':id' => $org_id]);
        $stats['active_trainees'] = $stmt->fetchColumn();

        return $stats;
    }

public function getApplications($org_id, $search = '') {
    $sql = "SELECT a.*, s.name as student_name, s.major, s.email, s.phone, o.title as opportunity_title 
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN opportunities o ON a.opportunity_id = o.id
            WHERE o.org_id = ? AND s.name LIKE ?
            ORDER BY a.created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id, "%$search%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateApplicationStatus($app_id, $status, $message) {
    $sql = "UPDATE applications SET status = ?, response_message = ? WHERE id = ?";
    return $this->db->prepare($sql)->execute([$status, $message, $app_id]);
}

public function getOpportunities($org_id, $search = '') {
    $sql = "SELECT * FROM opportunities WHERE org_id = ? AND title LIKE ? ORDER BY created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id, "%$search%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateOpportunity($id, $data) {
    $sql = "UPDATE opportunities SET 
            title = ?, seats = ?, deadline = ?, status = ?, 
            type = ?, location = ?, description = ?, requirements = ? 
            WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $data['title'], $data['seats'], $data['deadline'], $data['status'],
        $data['type'], $data['location'], $data['description'], $data['requirements'], $id
    ]);
}

public function deleteOpportunity($id) {
    $sql = "DELETE FROM opportunities WHERE id = ?";
    return $this->db->prepare($sql)->execute([$id]);
}

public function createOpportunity($org_id, $data) {
    $sql = "INSERT INTO opportunities (
                organization_id, title, location, type, status, 
                duration, start_date, deadline, seats, 
                description, requirements, contact_email, contact_phone
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $org_id,
        $data['title'],
        $data['location'],
        $data['type'],
        $data['status'],
        $data['duration'],
        $data['start_date'],
        $data['deadline'],
        $data['seats'],
        $data['description'],
        $data['requirements'],
        $data['contact_email'],
        $data['contact_phone']
    ]);
}

public function getAcceptedStudents($org_id) {
    $sql = "SELECT DISTINCT users.id, users.name 
            FROM users 
            JOIN applications ON users.id = applications.student_id
            JOIN opportunities ON applications.opportunity_id = opportunities.id
            WHERE opportunities.organization_id = ? AND applications.status = 'accepted'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveCertificate($data) {
    $sql = "INSERT INTO certificates (
                student_id, organization_id, type, organization_name, 
                hours, issue_date, trainer_name, content, 
                signature_path, stamp_path
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        $data['student_id'],
        $data['organization_id'],
        $data['type'],
        $data['organization'],
        $data['hours'] ?: 0,
        $data['issue_date'],
        $data['trainer_name'],
        $data['content'],
        $data['signature_path'],
        $data['stamp_path']
    ]);
}

public function getSupervisorByOrg($org_id) {
    $sql = "SELECT * FROM supervisors WHERE organization_id = ? LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function updateSupervisor($id, $data) {
    $sql = "UPDATE supervisors SET name = ?, email = ?, phone = ?, field = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['field'], $id]);
}


public function getUnassignedStudents($org_id) {
    $sql = "SELECT users.id, users.name 
            FROM users 
            JOIN applications ON users.id = applications.student_id
            JOIN opportunities ON applications.opportunity_id = opportunities.id
            WHERE opportunities.organization_id = ? 
            AND applications.status = 'accepted'
            AND users.id NOT IN (SELECT student_id FROM student_supervisor)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getAssignedStudents($supervisor_id) {
    $sql = "SELECT users.id, users.name, student_supervisor.assigned_at 
            FROM users 
            JOIN student_supervisor ON users.id = student_supervisor.student_id
            WHERE student_supervisor.supervisor_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$supervisor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function assignStudent($supervisor_id, $student_id) {
    $sql = "INSERT INTO student_supervisor (supervisor_id, student_id, assigned_at) VALUES (?, ?, NOW())";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$supervisor_id, $student_id]);
}


public function unassignStudent($supervisor_id, $student_id) {
    $sql = "DELETE FROM student_supervisor WHERE supervisor_id = ? AND student_id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$supervisor_id, $student_id]);
}

public function getTraineesByOrg($org_id) {
    $sql = "SELECT 
                u.id as student_id, 
                u.name as student_name, 
                u.major, 
                sup.name as supervisor_name,
                (SELECT SUM(hours) FROM attendance WHERE student_id = u.id AND status = 'approved') as total_hours,
                app.status as application_status,
                app.internship_status 
            FROM users u
            JOIN applications app ON u.id = app.student_id
            JOIN opportunities o ON app.opportunity_id = o.id
            LEFT JOIN student_supervisor ss ON u.id = ss.student_id
            LEFT JOIN supervisors sup ON ss.supervisor_id = sup.id
            WHERE o.organization_id = ? AND app.status = 'accepted'";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTrainerByOrg($org_id) {
    $sql = "SELECT * FROM supervisors WHERE organization_id = ? LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getUnassignedStudents($org_id) {
    $sql = "SELECT u.id, u.name 
            FROM users u
            JOIN applications app ON u.id = app.student_id
            JOIN opportunities o ON app.opportunity_id = o.id
            LEFT JOIN student_supervisor ss ON u.id = ss.student_id
            WHERE o.organization_id = ? 
            AND app.status = 'accepted' 
            AND ss.supervisor_id IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function assignStudentToTrainer($student_id, $trainer_id) {
    $sql = "INSERT INTO student_supervisor (student_id, supervisor_id) VALUES (?, ?)";
    return $this->db->prepare($sql)->execute([$student_id, $trainer_id]);
}

public function updateTrainer($data) {
    $sql = "UPDATE supervisors SET name = ?, email = ?, specialization = ? WHERE id = ?";
    return $this->db->prepare($sql)->execute([
        $data['name'], 
        $data['email'], 
        $data['specialization'], 
        $data['id']
    ]);
}

public function getRecentEventsAsNotifications($org_id) {
    $sql = "
        (SELECT 
            u.name as student_name, 
            'application' as type, 
            CONCAT('قام الطالب ', u.name, ' بالتقديم على فرصة: ', o.title) as message,
            app.created_at as event_time
        FROM applications app
        JOIN users u ON app.student_id = u.id
        JOIN opportunities o ON app.opportunity_id = o.id
        WHERE o.organization_id = ?)

        UNION ALL

        (SELECT 
            u.name as student_name, 
            'report' as type, 
            CONCAT('رفع الطالب ', u.name, ' تقريراً جديداً متاحاً للمراجعة.') as message,
            r.created_at as event_time
        FROM reports r
        JOIN users u ON r.student_id = u.id
        JOIN opportunities o ON r.opportunity_id = o.id
        WHERE o.organization_id = ?)

        ORDER BY event_time DESC LIMIT 15";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$org_id, $org_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}