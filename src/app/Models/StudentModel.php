<?php

class StudentModel {
    private $db;

    public function __construct($db_connection = null) {
        if ($db_connection !== null) {
            $this->db = $db_connection;
        } else {
            global $db_connection; 
            $this->db = $db_connection;
        }
    }

    public function getDashboardSummary($studentId) {
        $sql = "SELECT * FROM Student WHERE studentID = :studentId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatestApplication($studentId) {
        $sql = "SELECT ar.*, o.title as OpportunityTitle, ee.entityName as OrganizationName 
                FROM OpportunityRequest ar
                JOIN Opportunity o ON ar.opportunityID = o.opportunityID
                JOIN ExternalEntity ee ON ar.entityID = ee.entityID
                WHERE ar.studentID = :studentId 
                ORDER BY ar.requestDate DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCertificateQuickSummary($studentId) {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM Certificate WHERE studentID = :id1) as total_certs,
                    (SELECT ee.entityName FROM Certificate c 
                     JOIN ExternalEntity ee ON c.entityID = ee.entityID 
                     WHERE c.studentID = :id2 ORDER BY c.issueDate DESC LIMIT 1) as latest_org,
                    (SELECT issueDate FROM Certificate WHERE studentID = :id3 ORDER BY issueDate DESC LIMIT 1) as latest_date";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id1' => $studentId, ':id2' => $studentId, ':id3' => $studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function getAcceptedTrainingCount($studentId) {
    $sql = "SELECT COUNT(*) as total
            FROM OpportunityRequest r
            JOIN Opportunity o ON r.opportunityID = o.opportunityID
            WHERE r.studentID = :studentId
              AND r.entityStatus = 'مقبول'
              AND o.type = 'Training'";
              
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':studentId' => $studentId]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['total'] ?? 0;
}
public function getStudentTrainings($studentId) {
    $sql = "SELECT 
                o.title, 
                e.entityName AS OrganizationName, 
                o.createdAt AS completionDate
            FROM OpportunityRequest r
            JOIN Opportunity o ON r.opportunityID = o.opportunityID
            JOIN ExternalEntity e ON o.entityID = e.entityID
            WHERE r.studentID = :studentId
              AND r.entityStatus = 'مقبول'
              AND o.type = 'Training'
            ORDER BY o.createdAt DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':studentId' => $studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getFullAttendance($studentId) {
        $sql = "SELECT * FROM Attendance WHERE studentID = :studentId ORDER BY date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApprovedOpportunity($studentId) {
        $sql = "SELECT o.title, ee.entityName as OrganizationName, o.type 
                FROM Opportunity o
                JOIN OpportunityRequest ar ON o.opportunityID = ar.opportunityID
                JOIN ExternalEntity ee ON o.entityID = ee.entityID
                WHERE ar.studentID = :studentId AND ar.entityStatus = 'مقبول'
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAttendanceRecord($attendanceId, $studentId, $checkIn, $checkOut, $hours) {
        $sql = "UPDATE Attendance 
                SET checkIn = :checkIn, checkOut = :checkOut, hours = :hours 
                WHERE attendanceID = :attendanceId AND studentID = :studentId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':checkIn' => $checkIn,
            ':checkOut' => $checkOut,
            ':hours' => $hours,
            ':attendanceId' => $attendanceId,
            ':studentId' => $studentId
        ]);
    }

    public function getCalendarEvents($studentId) {
        $sql = "
            SELECT 'attendance' as type, status as title, date as event_date, notes as description, status 
            FROM Attendance 
            WHERE studentID = :id1
            UNION ALL
            SELECT 'report' as type, reportType as title, data as event_date, content as description, 'تم التسليم' as status
            FROM StudentReport 
            WHERE studentID = :id2
            ORDER BY event_date DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id1' => $studentId, ':id2' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getOpenOpportunities() {
    $sql = "SELECT o.*, ee.entityName AS OrganizationName 
            FROM Opportunity o 
            JOIN ExternalEntity ee ON o.entityID = ee.entityID 
            WHERE o.status = 'نشط' AND o.isApproved = 1
            ORDER BY o.opportunityID DESC";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

   public function getOpportunityById($id) {
    $sql = "SELECT o.*, ee.entityName as OrganizationName, u.email as OrgEmail, u.phoneNumber as OrgPhone, o.entityID as OrganizationID 
            FROM Opportunity o
            JOIN ExternalEntity ee ON o.entityID = ee.entityID
            JOIN Users u ON ee.entityID = u.userID
            WHERE o.opportunityID = :id AND o.isApproved = 1"; 
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function submitOpportunityRequest($sid, $oid, $eid, $supervisorId, $cv) {
        $sql = "INSERT INTO OpportunityRequest 
                (requestID, requestDate, studentID, opportunityID, entityID, supervisorID, entityStatus, supervisorStatus, CV_Path) 
                VALUES (:requestID, NOW(), :sid, :oid, :eid, :supervisorID, 'قيد الانتظار', 'بانتظار المشرف', :cv)";
        $stmt = $this->db->prepare($sql);
        $generatedID = rand(100000, 999999);
        return $stmt->execute([
            ':requestID' => $generatedID,
            ':sid' => $sid,
            ':oid' => $oid,
            ':eid' => $eid,
            ':supervisorID' => $supervisorId,
            ':cv' => $cv
        ]);
    }
public function getAvailableOpportunities() {
    $sql = "SELECT o.*, ee.entityName AS OrganizationName 
            FROM Opportunity o
            JOIN ExternalEntity ee ON o.entityID = ee.entityID
            WHERE o.isApproved = 1 AND o.status = 'نشط'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getStudentApplications($studentId) {
        $sql = "SELECT ar.*, o.title, o.type, ee.entityName as OrganizationName
                FROM OpportunityRequest ar
                JOIN Opportunity o ON ar.opportunityID = o.opportunityID
                JOIN ExternalEntity ee ON ar.entityID = ee.entityID
                WHERE ar.studentID = :studentId
                ORDER BY ar.requestDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAcceptedOpportunityId($studentId) {
        $sql = "SELECT opportunityID FROM OpportunityRequest WHERE studentID = :studentId AND entityStatus = 'مقبول' LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['opportunityID'] ?? null;
    }

    public function getStudentCertificates($studentId) {
        $sql = "SELECT c.*, ee.entityName FROM Certificate c 
                JOIN ExternalEntity ee ON c.entityID = ee.entityID 
                WHERE c.studentID = :studentId ORDER BY c.issueDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCertificatesCount($studentId) {
        $sql = "SELECT COUNT(*) as total FROM Certificate WHERE studentID = :studentId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    public function getStudentReports($studentId) {
        $sql = "SELECT * FROM StudentReport WHERE studentID = :studentId ORDER BY reportID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function submitReport($type, $content, $studentId, $opportunityId) {
        $sql = "INSERT INTO StudentReport (reportID, reportType, content, data, studentID, opportunityID) 
                VALUES (:reportID, :type, :content, NOW(), :studentId, :opportunityId)";
        $stmt = $this->db->prepare($sql);
        $generatedID = rand(100000, 999999);
        return $stmt->execute([
            ':reportID' => $generatedID,
            ':type' => $type, 
            ':content' => $content,
            ':studentId' => $studentId,
            ':opportunityId' => $opportunityId
        ]);
    }

    public function getStudentProfile($studentId) {
        $sql = "SELECT u.fullName, u.email, u.phoneNumber, s.* FROM Users u 
                JOIN Student s ON u.userID = s.studentID 
                WHERE u.userID = :studentId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':studentId' => $studentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudentProfile($id, $name, $email, $phone, $password = null) {
        $sql = "UPDATE Users SET fullName = :name, email = :email, phoneNumber = :phone";
        if ($password) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE userID = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        return $stmt->execute();
    }
  public function getVolunteerCount($studentId) {
    $sql = "SELECT COUNT(*) as total
            FROM OpportunityRequest r
            JOIN Opportunity o ON r.opportunityID = o.opportunityID
            WHERE r.studentID = :studentId
              AND o.type = 'Volunteer'
              AND r.entityStatus = 'مقبول'";
              
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':studentId' => $studentId]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['total'] ?? 0;
}

public function getStudentVolunteerWorks($studentId) {
    $sql = "SELECT o.title, ee.entityName as OrganizationName
            FROM OpportunityRequest r
            JOIN Opportunity o ON r.opportunityID = o.opportunityID
            JOIN ExternalEntity ee ON o.entityID = ee.entityID
            WHERE r.studentID = :studentId
              AND o.type = 'Volunteer'
              AND r.entityStatus = 'مقبول'
            ORDER BY r.requestDate DESC"; 
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':studentId' => $studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getSmartNotifications($studentId) {
        $notifications = [];
        
        $sqlApps = "SELECT o.title as CompanyName, ar.supervisorStatus as academic_status, 
                           ar.entityStatus as external_status 
                    FROM OpportunityRequest ar
                    JOIN Opportunity o ON ar.opportunityID = o.opportunityID
                    WHERE ar.studentID = :studentId 
                    ORDER BY ar.requestDate DESC LIMIT 3";
        $stmt = $this->db->prepare($sqlApps);
        $stmt->execute([':studentId' => $studentId]);
        $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($apps as $app) {
            if ($app['academic_status'] == 'معتمد' && $app['external_status'] == 'قيد الانتظار') {
                $notifications[] = [
                    'title' => 'موافقة أكاديمية',
                    'message' => "تمت الموافقة على طلبك لفرصة " . $app['CompanyName'] . " من قبل المشرف، وبانتظار رد المؤسسة.",
                    'icon' => 'bi-person-check', 'color' => 'blue'
                ];
            } elseif ($app['academic_status'] == 'معتمد' && $app['external_status'] == 'مقبول') {
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