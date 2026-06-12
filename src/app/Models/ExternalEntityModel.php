<?php
class ExternalEntityModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrgDetails($org_id) {
        $stmt = $this->db->prepare("
            SELECT u.*, ee.entityName, ee.location, ee.employeeName, ee.employeeEmail 
            FROM Users u 
            JOIN ExternalEntity ee ON u.userID = ee.entityID 
            WHERE u.userID = :id AND u.role = 'جهة خارجية'
        ");
        $stmt->execute([':id' => $org_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  public function getDashboardStats($org_id) {
    $stats = [];
    
    $stmtName = $this->db->prepare("
        SELECT ee.entityName, ee.employeeName, u.role 
        FROM ExternalEntity ee
        JOIN Users u ON ee.entityID = u.userID
        WHERE ee.entityID = :id LIMIT 1
    ");
    $stmtName->execute([':id' => $org_id]);
    $entityData = $stmtName->fetch(PDO::FETCH_ASSOC);
    
    $stats['trainer_name'] = $entityData['employeeName'] ?? 'لم يحدد بعد';
    $stats['manager_name'] = $entityData['employeeName'] ?? 'لم يحدد بعد';

    $entityNameLower = $entityData['entityName'] ?? '';
    if (mb_strpos($entityNameLower, 'مؤسسة') !== false || mb_strpos($entityNameLower, 'جمعية') !== false || mb_strpos($entityNameLower, 'مركز') !== false) {
        $stats['entity_type'] = 'مؤسسة';
    } else {
        $stats['entity_type'] = 'شركة';
    }

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM Opportunity WHERE entityID = :id");
    $stmt->execute([':id' => $org_id]);
    $stats['opps_count'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM OpportunityRequest WHERE entityID = :id AND entityStatus = 'قيد الانتظار'");
    $stmt->execute([':id' => $org_id]);
    $stats['pending_apps'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM OpportunityRequest WHERE entityID = :id");
    $stmt->execute([':id' => $org_id]);
    $stats['total_apps'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM OpportunityRequest WHERE entityID = :id AND entityStatus = 'مقبول'");
    $stmt->execute([':id' => $org_id]);
    $stats['active_trainees'] = $stmt->fetchColumn();

    return $stats;
}

    public function getApplications($org_id, $search = '') {
        $sql = "SELECT opr.*, u.fullName as student_name, s.majorName, u.email, u.phoneNumber, o.title as opportunity_title 
                FROM OpportunityRequest opr
                JOIN Student s ON opr.studentID = s.studentID
                JOIN Users u ON s.studentID = u.userID
                JOIN Opportunity o ON opr.opportunityID = o.opportunityID
                WHERE opr.entityID = :org_id AND u.fullName LIKE :search
                ORDER BY opr.requestDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':org_id' => $org_id,
            ':search' => "%$search%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function updateApplicationStatus($app_id, $status) {
    
    $sql = "UPDATE OpportunityRequest 
            SET entityStatus = :status 
            WHERE requestID = :app_id";

    $this->db->prepare($sql)->execute([
        ':status' => $status,
        ':app_id' => $app_id
    ]);
    if ($status == 'مقبول') {

        $sql2 = "UPDATE Attendance att
                 JOIN OpportunityRequest orq 
                    ON att.studentID = orq.studentID 
                   AND att.opportunityID = orq.opportunityID
                 SET att.academicSupervisorID = orq.supervisorID
                 WHERE orq.requestID = :id";

        $this->db->prepare($sql2)->execute([
            ':id' => $app_id
        ]);
    }

    return true;
}

public function getOpportunities($org_id, $search = '') {
    $sql = "SELECT * FROM Opportunity WHERE entityID = :org_id AND title LIKE :search ORDER BY opportunityID DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':org_id' => $org_id,
        ':search' => "%$search%"
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateOpportunity($id, $data) {
    $sql = "UPDATE Opportunity SET 
                title       = :title, 
                seats       = :seats, 
                conditions  = :conditions, 
                type        = :type,
                status      = :status,
                description = :description
            WHERE opportunityID = :id";
            
    $stmt = $this->db->prepare($sql);

    $requirements = $data['requirements'] ?? $data['conditions'] ?? '';
    $conditions = !empty(trim($requirements)) ? $requirements : null;

    $description = !empty(trim($data['description'] ?? '')) ? $data['description'] : null;

    $status = $data['status'] ?? 'نشط';

    return $stmt->execute([
        ':title'       => $data['title'], 
        ':seats'       => $data['seats'], 
        ':conditions'  => $conditions,
        ':type'        => $data['type'], 
        ':status'      => $status,
        ':description' => $description,
        ':id'          => $id
    ]);
}

    public function deleteOpportunity($id) {
        $sql = "DELETE FROM Opportunity WHERE opportunityID = :id";
        return $this->db->prepare($sql)->execute([':id' => $id]);
    }

public function createOpportunity($org_id, $data) {
    $sql = "INSERT INTO Opportunity (
                opportunityID, title, type, seats, conditions, description, entityID, supervisorID
            ) VALUES (
                :opportunityID, :title, :type, :seats, :conditions, :description, :entityID, :supervisorID
            )";
            
    $stmt = $this->db->prepare($sql);
    $generatedID = rand(100000, 999999);

    $requirements = $data['conditions'] ?? '';
    $conditions = !empty(trim($requirements)) ? $requirements : null;
    
    $description = $data['description'] ?? null;

    return $stmt->execute([
        ':opportunityID' => $generatedID,
        ':title'         => $data['title'],
        ':type'          => $data['type'], 
        ':seats'         => $data['seats'],
        ':conditions'    => $conditions, 
        ':description'   => $description, // إرسال الوصف
        ':entityID'      => $org_id,
        ':supervisorID'  => !empty($data['supervisorID']) ? $data['supervisorID'] : null 
    ]);
}
public function getAcceptedStudents($org_id) {
        $stmt = $this->db->prepare("
            SELECT DISTINCT u.userID, u.fullName 
            FROM OpportunityRequest opr
            JOIN Users u ON opr.studentID = u.userID
            WHERE opr.entityID = :org_id AND opr.entityStatus = 'مقبول'
        ");
        $stmt->execute([':org_id' => $org_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function saveCertificate($data) {

    $stmt = $this->db->prepare("
        INSERT INTO Certificate (issueDate, isApproved, studentID, entityID, opportunityID) 
        VALUES (:issue_date, :is_approved, :student_id, :entity_id, :opportunity_id)
    ");

    $result = $stmt->execute([
        ':issue_date'     => $data['issue_date'],
        ':is_approved'    => 0, 
        ':student_id'     => $data['student_id'],
        ':entity_id'      => $data['organization_id'],
        ':opportunity_id' => $data['opportunity_id'] ?? null
    ]);

    return $result;
}
public function getOrganizationDetails($org_id) {
    $stmt = $this->db->prepare("
        SELECT userID, fullName 
        FROM Users 
        WHERE userID = :org_id
        LIMIT 1
    ");
    $stmt->execute([':org_id' => $org_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function getTrainerDetails($org_id) {
        $sql = "SELECT employeeName, employeeEmail FROM ExternalEntity WHERE entityID = :org_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':org_id' => $org_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTrainerDetails($org_id, $data) {
        $sql = "UPDATE ExternalEntity SET employeeName = :name, employeeEmail = :email WHERE entityID = :org_id";
        return $this->db->prepare($sql)->execute([
            ':name'   => $data['employeeName'], 
            ':email'  => $data['employeeEmail'], 
            ':org_id' => $org_id
        ]);
    }
 public function getOrganizationById($org_id) {
        $sql = "SELECT entityID, entityName, location, employeeName, employeeEmail 
                FROM ExternalEntity 
                WHERE entityID = :org_id 
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':org_id' => $org_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getSupervisorByOrg($org_id) {
    $sql = "SELECT employeeName FROM ExternalEntity WHERE entityID = :org_id LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':org_id' => $org_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['employeeName'] ?? 'لم يحدد';
}
   public function getTraineesByOrg($org_id) {
    $supervisor = $this->getSupervisorByOrg($org_id); 

    $sql = "SELECT 
                u.userID as student_id, 
                u.fullName as student_name, 
                s.majorName, 
                (SELECT SUM(hours) FROM Attendance WHERE studentID = u.userID AND entityID = :org_id) as total_hours,
                opr.entityStatus as application_status
            FROM Users u
            JOIN Student s ON u.userID = s.studentID
            JOIN OpportunityRequest opr ON u.userID = opr.studentID
            WHERE opr.entityID = :org_id AND opr.entityStatus = 'مقبول'";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':org_id' => $org_id]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($students as &$student) {
        $student['supervisor_name'] = $supervisor;
    }

    return $students;
}

    public function getRecentEventsAsNotifications($org_id) {
        $sql = "
            (SELECT 
                u.fullName as student_name, 
                'application' as type, 
                CONCAT('قام الطالب ', u.fullName, ' بالتقديم على فرصة: ', o.title) as message,
                opr.requestDate as event_time
            FROM OpportunityRequest opr
            JOIN Users u ON opr.studentID = u.userID
            JOIN Opportunity o ON opr.opportunityID = o.opportunityID
            WHERE opr.entityID = :org_id1)

            UNION ALL

            (SELECT 
                u.fullName as student_name, 
                'report' as type, 
                CONCAT('رفع الطالب ', u.fullName, ' تقريراً جديداً متاحاً للمراجعة.') as message,
                sr.data as event_time
            FROM StudentReport sr
            JOIN Users u ON sr.studentID = u.userID
            WHERE sr.opportunityID IN (SELECT opportunityID FROM Opportunity WHERE entityID = :org_id2))

            ORDER BY event_time DESC LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':org_id1' => $org_id, 
            ':org_id2' => $org_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}