<?php

class SupervisorModel {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function getSupervisorProfile($id) {
        $query = "SELECT u.fullName as name, u.email, u.phoneNumber as phone, s.departmentName as department 
                  FROM Users u 
                  JOIN AcademicSupervisor s ON u.userID = s.supervisorID 
                  WHERE u.userID = :id AND (u.role = 'مشرف تدريب' OR u.role = 'مشرف تطوع') LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $data) {
        $query = "UPDATE Users SET fullName = :name, email = :email, phoneNumber = :phone WHERE userID = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':name'  => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':id'    => $id
        ]);
    }

    public function updatePassword($id, $new_password) {
        $hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $query = "UPDATE Users SET password = :password WHERE userID = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':password' => $hashed, ':id' => $id]);
    }

    public function getSupervisorData($id) {
        $query = "SELECT fullName as name, email FROM Users WHERE userID = :id AND (role = 'مشرف تدريب' OR role = 'مشرف تطوع') LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function getDashboardStats($supervisor_id) {
    $stats = [];
    
    $stmt = $this->db->prepare("SELECT COUNT(DISTINCT studentID) FROM OpportunityRequest WHERE supervisorID = :sid");
    $stmt->execute([':sid' => $supervisor_id]);
    $stats['students_count'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM StudentReport r JOIN OpportunityRequest ar ON r.studentID = ar.studentID WHERE ar.supervisorID = :sid");
    $stmt->execute([':sid' => $supervisor_id]);
    $stats['pending_reports'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM OpportunityRequest WHERE supervisorID = :sid AND supervisorStatus = 'بانتظار المشرف'");
    $stmt->execute([':sid' => $supervisor_id]);
    $stats['pending_applications'] = $stmt->fetchColumn();

    $stmt = $this->db->prepare("SELECT COUNT(*) FROM Opportunity WHERE isApproved = 0");
    $stmt->execute();
    $stats['pending_opportunities'] = $stmt->fetchColumn();

    $stats['unread_notifications'] = 0;
    $stats['average_progress'] = 0;

    return $stats;
}

    public function getRecentActivity($supervisor_id) {
        return [];
    }

    public function addOpportunity($data) {
        $query = "INSERT INTO Opportunity 
                  (opportunityID, title, type, seats, conditions, entityID, supervisorID, status, description) 
                  VALUES 
                  (:opportunityID, :title, :type, :seats, :conditions, :entityID, :supervisorID, :status, :description)";
        
        $stmt = $this->db->prepare($query);
        $generatedID = rand(100000, 999999);
        return $stmt->execute([
            ':opportunityID' => $generatedID,
            ':title'         => $data['title'],
            ':type'          => $data['type'],
            ':seats'         => $data['seats'],
            ':conditions'    => $data['requirements'],
            ':entityID'      => $data['organization'],
            ':supervisorID'  => $data['supervisor_id'],
            ':status'        => $data['status'],
            ':description'   => $data['description']
        ]);
    }
    
    public function getPendingApplications($supervisor_id) {
        $query = "SELECT ar.requestID as id, u.fullName as student_name, o.title as opportunity, ar.supervisorStatus as status 
                  FROM OpportunityRequest ar
                  JOIN Users u ON ar.studentID = u.userID
                  JOIN Opportunity o ON ar.opportunityID = o.opportunityID
                  WHERE ar.supervisorID = :sid AND ar.supervisorStatus = 'بانتظار المشرف'";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateApplicationStatus($app_id, $status) {
        $query = "UPDATE OpportunityRequest SET supervisorStatus = :status WHERE requestID = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $app_id
        ]);
    }

    public function getPendingAttendance($supervisor_id) {
        return [];
    }

    public function updateAttendanceStatus($attendance_id, $status) {
        $query = "UPDATE Attendance SET status = :status WHERE attendanceID = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $attendance_id
        ]);
    }

    public function getOpportunityById($id) {
        $query = "SELECT o.*, ee.entityName as organization, u.email as contact_email, u.phoneNumber as contact_phone 
                  FROM Opportunity o 
                  JOIN ExternalEntity ee ON o.entityID = ee.entityID
                  JOIN Users u ON ee.entityID = u.userID
                  WHERE o.opportunityID = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOpportunity($id, $data) {
        $query = "UPDATE Opportunity SET 
                    title = :title, 
                    type = :type, 
                    seats = :seats, 
                    status = :status, 
                    description = :description, 
                    conditions = :conditions 
                  WHERE opportunityID = :id";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':type'        => $data['type'],
            ':seats'       => $data['seats'],
            ':status'      => $data['status'],
            ':description' => $data['description'],
            ':conditions'  => $data['requirements'],
            ':id'          => $id
        ]);
    }

    public function getCompanyReports($supervisor_id) {
        $query = "SELECT 
                    u.fullName as student_name, 
                    ee.entityName as company_name, 
                    er.content as notes, 
                    er.data as report_date,
                    er.reportID as report_id
                  FROM EvaluationReport er
                  JOIN ExternalEntity ee ON er.entityID = ee.entityID
                  JOIN OpportunityRequest ar ON ee.entityID = ar.entityID
                  JOIN Users u ON ar.studentID = u.userID
                  WHERE ar.supervisorID = :sid
                  ORDER BY er.data DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveFinalEvaluation($data) {
        return true;
    }

    public function getStudentById($student_id, $supervisor_id) {
        $query = "SELECT s.* FROM Student s 
                  JOIN OpportunityRequest ar ON s.studentID = ar.studentID 
                  WHERE s.studentID = :student_id AND ar.supervisorID = :sid LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':student_id' => $student_id, ':sid' => $supervisor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOpportunitiesBySupervisor($supervisor_id) {
        $query = "SELECT opportunityID as id, title, status FROM Opportunity 
                  WHERE supervisorID = :sid ORDER BY createdAt DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteOpportunity($id, $supervisor_id) {
        $query = "DELETE FROM Opportunity WHERE opportunityID = :id AND supervisorID = :sid";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id, ':sid' => $supervisor_id]);
    }

    public function getPendingReports($supervisor_id) {
        $query = "SELECT r.reportID as id, u.fullName as student_name, r.reportType as week_number, r.data as created_at, 'قيد الانتظار' as status 
                  FROM StudentReport r
                  JOIN Users u ON r.studentID = u.userID
                  JOIN OpportunityRequest ar ON r.studentID = ar.studentID
                  WHERE ar.supervisorID = :sid
                  ORDER BY r.data DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateReportStatus($report_id, $status, $feedback = null) {
        return true;
    }

    public function getFullStudentDetails($student_id) {
        $query = "SELECT u.fullName as name, u.email, u.phoneNumber as phone, s.majorName as major, s.academicYear as university_id 
                  FROM Student s
                  JOIN Users u ON s.studentID = u.userID
                  WHERE s.studentID = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentReports($student_id) {
        $query = "SELECT reportType as title, 'تم التسليم' as status, data as created_at FROM StudentReport 
                  WHERE studentID = :id 
                  ORDER BY data DESC LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupervisedStudents($supervisor_id, $searchTerm = '') {
        $sql = "SELECT 
                    u.userID as id, 
                    u.fullName as name, 
                    s.majorName as major, 
                    s.academicYear as university_id,
                    (SELECT SUM(hours) FROM Attendance WHERE studentID = u.userID AND status = 'حاضر') as completed_hours,
                    (SELECT ee.entityName FROM ExternalEntity ee JOIN OpportunityRequest ar ON ee.entityID = ar.entityID WHERE ar.studentID = u.userID AND ar.entityStatus = 'مقبول' LIMIT 1) as company,
                    'نشط' as status
                FROM Student s
                JOIN Users u ON s.studentID = u.userID
                JOIN OpportunityRequest ar ON s.studentID = ar.studentID
                WHERE ar.supervisorID = :sid";

        if (!empty($searchTerm)) {
            $sql .= " AND (u.fullName LIKE :search OR s.majorName LIKE :search)";
        }

        $stmt = $this->db->prepare($sql);
        $params = [':sid' => $supervisor_id];
        if (!empty($searchTerm)) {
            $params[':search'] = '%' . $searchTerm . '%';
        }
        
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function approveOpportunity($opportunityId, $supervisorId) {
    $sql = "UPDATE Opportunity 
            SET isApproved = 1, 
                supervisorID = :supId, 
                status = 'نشط' 
            WHERE opportunityID = :oppId";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':supId' => $supervisorId, 
        ':oppId' => $opportunityId
    ]);
}

public function getPendingOpportunities() {
    $sql = "SELECT * FROM Opportunity WHERE isApproved = 0 AND type = 'تدريب'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}