<?php

class StudentModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database(); 
    }

    

    public function getDashboardSummary($studentId) {
        $sql = "SELECT * FROM Student WHERE UserID = ?";
        return $this->db->query($sql, [$studentId])->fetch();
    }

    public function getLatestApplication($studentId) {
        $sql = "SELECT ar.*, o.Title as OpportunityTitle, o.OrganizationName 
                FROM OpportunityRequest ar
                JOIN Opportunity o ON ar.OpportunityID = o.OpportunityID
                WHERE ar.StudentID = ? 
                ORDER BY ar.RequestDate DESC LIMIT 1";
        return $this->db->query($sql, [$studentId])->fetch();
    }

    public function getCertificateQuickSummary($studentId) {
        
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM Certificates WHERE StudentID = ?) as total_certs,
                    (SELECT OrganizationName FROM Certificates WHERE StudentID = ? ORDER BY IssueDate DESC LIMIT 1) as latest_org,
                    (SELECT IssueDate FROM Certificates WHERE StudentID = ? ORDER BY IssueDate DESC LIMIT 1) as latest_date";
        return $this->db->query($sql, [$studentId, $studentId, $studentId])->fetch();
    }

    public function getAcceptedTrainingCount($studentId) {
        $sql = "SELECT COUNT(*) as total FROM OpportunityRequest WHERE StudentID = ? AND EntityStatus = 'Accepted'";
        $res = $this->db->query($sql, [$studentId])->fetch();
        return $res['total'] ?? 0;
    }

   

    public function getFullAttendance($studentId) {
        $sql = "SELECT * FROM Attendance WHERE StudentID = ? ORDER BY AttendanceDate DESC";
        return $this->db->query($sql, [$studentId])->fetchAll();
    }

    public function getApprovedOpportunity($studentId) {
      
        $sql = "SELECT o.Title, o.OrganizationName, o.Type 
                FROM Opportunity o
                JOIN OpportunityRequest ar ON o.OpportunityID = ar.OpportunityID
                WHERE ar.StudentID = ? AND ar.EntityStatus = 'Accepted'
                LIMIT 1";
        return $this->db->query($sql, [$studentId])->fetch();
    }

    public function updateAttendanceRecord($attendanceId, $studentId, $checkIn, $checkOut, $hours) {
        $sql = "UPDATE Attendance 
                SET CheckIn = ?, CheckOut = ?, HoursWorked = ? 
                WHERE AttendanceID = ? AND StudentID = ?";
        return $this->db->query($sql, [$checkIn, $checkOut, $hours, $attendanceId, $studentId]);
    }



    public function getCalendarEvents($studentId) {
        $sql = "
            SELECT 'attendance' as type, Status as title, AttendanceDate as event_date, Notes as description, Status 
            FROM Attendance 
            WHERE StudentID = ?
            UNION ALL
            SELECT 'report' as type, Title, SubmissionDate as event_date, Status as description, Status
            FROM Reports 
            WHERE StudentID = ?
            ORDER BY event_date DESC
        ";
        return $this->db->query($sql, [$studentId, $studentId])->fetchAll();
    }

    

    public function getOpenOpportunities() {
        $sql = "SELECT * FROM Opportunity WHERE Status = 'Open' ORDER BY CreatedAt DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getOpportunityById($id) {
        $sql = "SELECT o.*, org.Name as OrganizationName, org.Email as OrgEmail, org.Phone as OrgPhone, o.OrganizationID 
                FROM Opportunity o
                JOIN Organization org ON o.OrganizationID = org.OrganizationID
                WHERE o.OpportunityID = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    

    public function submitOpportunityRequest($sid, $oid, $eid, $cv) {
        $sql = "INSERT INTO OpportunityRequest 
                (RequestDate, StudentID, OpportunityID, EntityID, EntityStatus, SupervisorStatus, CV_Path) 
                VALUES (NOW(), ?, ?, ?, 'Pending', 'Pending', ?)";
        return $this->db->query($sql, [$sid, $oid, $eid, $cv]);
    }

    public function getStudentApplications($studentId) {
        $sql = "SELECT ar.*, o.Title, o.Type, org.Name as OrganizationName
                FROM OpportunityRequest ar
                JOIN Opportunity o ON ar.OpportunityID = o.OpportunityID
                JOIN Organization org ON o.OrganizationID = org.OrganizationID
                WHERE ar.StudentID = ?
                ORDER BY ar.RequestDate DESC";
        return $this->db->query($sql, [$studentId])->fetchAll();
    }

    public function getAcceptedOpportunityId($studentId) {
        $sql = "SELECT OpportunityID FROM OpportunityRequest WHERE StudentID = ? AND EntityStatus = 'Accepted' LIMIT 1";
        $res = $this->db->query($sql, [$studentId])->fetch();
        return $res['OpportunityID'] ?? null;
    }

   

    public function getStudentCertificates($studentId) {
        $sql = "SELECT * FROM Certificates WHERE StudentID = ? ORDER BY IssueDate DESC";
        return $this->db->query($sql, [$studentId])->fetchAll();
    }

    public function getCertificatesCount($studentId) {
        $sql = "SELECT COUNT(*) as total FROM Certificates WHERE StudentID = ?";
        $res = $this->db->query($sql, [$studentId])->fetch();
        return $res['total'] ?? 0;
    }

   

    public function getStudentReports($studentId) {
        $sql = "SELECT * FROM Reports WHERE StudentID = ? ORDER BY ReportID DESC";
        return $this->db->query($sql, [$studentId])->fetchAll();
    }

    public function submitReport($type, $content, $filePath, $studentId, $opportunityId) {
        $sql = "INSERT INTO Reports (Title, Content, FilePath, StudentID, OpportunityID, SubmissionDate, Status) 
                VALUES (?, ?, ?, ?, ?, NOW(), 'Pending')";
        return $this->db->query($sql, [$type, $content, $filePath, $studentId, $opportunityId]);
    }

   

    public function getStudentProfile($studentId) {
        $sql = "SELECT u.Name, u.Email, s.* FROM Users u 
                JOIN Student s ON u.UserID = s.UserID 
                WHERE u.UserID = ?";
        return $this->db->query($sql, [$studentId])->fetch();
    }

    public function updateStudentProfile($id, $name, $email, $phone, $password = null) {
        $sql = "UPDATE Student SET FullName = ?, Email = ?, Phone = ?";
        $params = [$name, $email, $phone];

        if ($password) {
            $sql .= ", Password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE UserID = ?";
        $params[] = $id;

        return $this->db->query($sql, $params);
    }

    

    public function getSmartNotifications($studentId) {
        $notifications = [];
        
        $sqlApps = "SELECT o.Title as CompanyName, ar.SupervisorStatus as academic_status, 
                           ar.EntityStatus as external_status 
                    FROM OpportunityRequest ar
                    JOIN Opportunity o ON ar.OpportunityID = o.OpportunityID
                    WHERE ar.StudentID = ? 
                    ORDER BY ar.RequestDate DESC LIMIT 3";
        $apps = $this->db->query($sqlApps, [$studentId])->fetchAll();

        foreach ($apps as $app) {
            if ($app['academic_status'] == 'Accepted' && $app['external_status'] == 'Pending') {
                $notifications[] = [
                    'title' => 'موافقة أكاديمية',
                    'message' => "تمت الموافقة على طلبك لفرصة " . $app['CompanyName'] . " من قبل المشرف، وبانتظار رد المؤسسة.",
                    'icon' => 'bi-person-check', 'color' => 'blue'
                ];
            } elseif ($app['academic_status'] == 'Accepted' && $app['external_status'] == 'Accepted') {
                $notifications[] = [
                    'title' => 'قبول نهائي!',
                    'message' => "تهانينا! تمت الموافقة النهائية على تدريبك في " . $app['CompanyName'] . ".",
                    'icon' => 'bi-check-circle-fill', 'color' => 'green'
                ];
            }
        }
        return $notifications;
    }
}