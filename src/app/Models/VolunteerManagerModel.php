<?php
class VolunteerManagerModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getActiveVolunteersCount($manager_id) {
        $sql = "SELECT COUNT(DISTINCT studentID) as count 
                FROM OpportunityRequest 
                WHERE entityID = ? AND entityStatus = 'مقبول'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getTotalCompletedHours($manager_id) {
        $sql = "SELECT SUM(hours) as total 
                FROM Attendance
                WHERE entityID = ? AND status = 'حاضر'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

  public function getManagerProfile($manager_id)
{
    $sql = "SELECT 
                entityID,
                entityName,
                location,
                employeeName,
                employeeEmail
            FROM ExternalEntity
            WHERE entityID = ?";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manager_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

  public function updateProfile($manager_id, $employeeName, $employeeEmail, $location)
{
    $sql = "UPDATE ExternalEntity
            SET employeeName = ?,
                employeeEmail = ?,
                location = ?
            WHERE entityID = ?";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $employeeName,
        $employeeEmail,
        $location,
        $manager_id
    ]);
}

   public function getMyVolunteers($manager_id, $search = '') {

    $params = [$manager_id];
    $searchQuery = "";

    if (!empty($search)) {
        $searchQuery = " AND u.fullName LIKE ?";
        $params[] = "%{$search}%";
    }

    $sql = "
        SELECT
            u.userID AS id,
            u.fullName AS name,
            s.academicYear AS student_id_number,
            s.majorName AS major,

            COALESCE(
            (
                SELECT SUM(a.hours)
                FROM Attendance a
                JOIN ExternalEntity ee
                    ON a.entityID = ee.entityID
                WHERE a.studentID = u.userID
                  AND a.status = 'حاضر'
                  AND ee.entityName LIKE 'مؤسسة%'
            ),
            0
            ) AS completed_hours,

            s.requiredVolunteerHours AS required_hours

        FROM Users u

        JOIN Student s
            ON u.userID = s.studentID

        JOIN OpportunityRequest ar
            ON u.userID = ar.studentID

        WHERE ar.entityID = ?
          AND ar.entityStatus = 'مقبول'
          $searchQuery

        GROUP BY u.userID
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

  public function getStudentFullDetails($student_id) {

    $sql = "SELECT 
                u.userID as id,
                u.fullName as name,
                s.academicYear as student_id_number,
                s.majorName as major,
                s.requiredVolunteerHours as required_hours,

                (
                    SELECT COALESCE(SUM(a.hours), 0)
                    FROM Attendance a
                    JOIN ExternalEntity ee
                        ON a.entityID = ee.entityID
                    WHERE a.studentID = ?
                      AND a.status = 'حاضر'
                      AND ee.entityName LIKE 'مؤسسة%'
                ) as completed_hours

            FROM Users u
            JOIN Student s 
                ON u.userID = s.studentID
            WHERE u.userID = ?
              AND u.role = 'طالب'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id, $student_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getStudentAttendanceLogs($student_id) {

    $sql = "
        SELECT
            a.date,
            a.hours AS total_hours,
            a.notes,
            a.status
        FROM Attendance a
        JOIN ExternalEntity ee
            ON a.entityID = ee.entityID
        WHERE a.studentID = ?
          AND ee.entityName LIKE 'مؤسسة%'
        ORDER BY a.date DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$student_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function markVolunteerComplete($studentID) {
    $sql = "UPDATE Student 
            SET volunteerCompleted = 1, volunteerCompletedAt = NOW() 
            WHERE studentID = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$studentID]);
}

    public function getReportsSummary($manager_id) {
        $sql = "
            SELECT 
                COUNT(DISTINCT ar.studentID) as total_volunteers,
                COALESCE(SUM(CASE WHEN a.status = 'متأخر' THEN a.hours ELSE 0 END), 0) as pending_hours,
                COALESCE(SUM(CASE WHEN a.status = 'حاضر' THEN a.hours ELSE 0 END), 0) as approved_hours,
                (SELECT COUNT(*) FROM Student s2
                 JOIN OpportunityRequest ar2 ON s2.studentID = ar2.studentID 
                 WHERE ar2.entityID = ? AND ar2.entityStatus = 'مقبول' AND 
                 (SELECT SUM(hours) FROM Attendance WHERE studentID = s2.studentID AND status = 'حاضر') >= s2.requiredVolunteerHours
                ) as completed_volunteers
            FROM OpportunityRequest ar
            LEFT JOIN Attendance a ON ar.studentID = a.studentID AND ar.entityID = a.entityID
            WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id, $manager_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVolunteersPerformance($manager_id) {
        $sql = "
            SELECT 
                u.userID as id, u.fullName as name, s.academicYear as student_id_number, s.requiredVolunteerHours as required_hours,
                COALESCE(SUM(CASE WHEN a.status = 'حاضر' THEN a.hours ELSE 0 END), 0) as approved_hours,
                (SELECT notes FROM Attendance WHERE studentID = u.userID AND notes IS NOT NULL ORDER BY date DESC LIMIT 1) as last_note
            FROM Users u
            JOIN Student s ON u.userID = s.studentID
            JOIN OpportunityRequest ar ON u.userID = ar.studentID
            LEFT JOIN Attendance a ON u.userID = a.studentID
            WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'
            GROUP BY u.userID";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  public function getVolunteersForAttendance($entity_id) {
    $date = date('Y-m-d');

    $sql = "
        SELECT
            u.userID AS id,
            u.fullName AS name,
            s.academicYear AS student_id_number,
            a.status,
            a.hours AS total_hours,
            a.notes,
            a.checkIn,
            a.checkOut
        FROM Users u
        JOIN Student s
            ON u.userID = s.studentID
        JOIN OpportunityRequest ar
            ON u.userID = ar.studentID
        LEFT JOIN Attendance a
            ON a.studentID = u.userID
            AND a.entityID = ar.entityID
            AND a.opportunityID = ar.opportunityID
            AND a.date = ?
        WHERE ar.entityID = ?
          AND ar.entityStatus = 'مقبول'
        ORDER BY u.fullName
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$date, $entity_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveAttendance($data) {

    $sqlLookup = "
        SELECT entityID, opportunityID
        FROM OpportunityRequest
        WHERE studentID = :studentID
          AND entityID = :entityID
          AND entityStatus = 'مقبول'
        ORDER BY requestDate DESC
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sqlLookup);

    $stmt->execute([
        'studentID' => $data['studentID'],
        'entityID'  => $data['entityID']
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return false;
    }

    $sql = "
        INSERT INTO Attendance
        (
            date,
            status,
            checkIn,
            checkOut,
            hours,
            notes,
            studentID,
            entityID,
            opportunityID
        )
        VALUES
        (
            :date,
            :status,
            :checkIn,
            :checkOut,
            :hours,
            :notes,
            :studentID,
            :entityID,
            :opportunityID
        )
        ON DUPLICATE KEY UPDATE
            status   = VALUES(status),
            checkIn  = VALUES(checkIn),
            checkOut = VALUES(checkOut),
            hours    = VALUES(hours),
            notes    = VALUES(notes)
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        'date'          => $data['date'],
        'status'        => $data['status'],
        'checkIn'       => $data['checkIn'],
        'checkOut'      => $data['checkOut'],
        'hours'         => $data['hours'],
        'notes'         => $data['notes'],
        'studentID'     => $data['studentID'],
        'entityID'      => $row['entityID'],
        'opportunityID' => $row['opportunityID']
    ]);
}

    public function getDynamicNotifications($manager_id) {
        $sql = "
            (SELECT 
                u.userID as id,
                'اعتماد ساعات' as title,
                CONCAT('تم تسجيل ساعات حضور للطالب ', u.fullName, ' بمقدار ', a.hours, ' ساعة.') as message,
                a.updated_at as event_time,
                'present' as status
            FROM Attendance a
            JOIN Users u ON a.studentID = u.userID
            WHERE a.entityID = ? AND a.status = 'حاضر' 
            AND a.updated_at >= DATE_SUB(NOW(), INTERVAL 7 DAY))

            UNION ALL

            (SELECT 
                u.userID as id,
                'متطوع جديد' as title,
                CONCAT('تم قبول طلب التطوع للطالب ', u.fullName, ' بنجاح.') as message,
                ar.requestDate as event_time,
                'new' as status
            FROM OpportunityRequest ar
            JOIN Users u ON ar.studentID = u.userID
            WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'
            AND ar.requestDate >= DATE_SUB(NOW(), INTERVAL 7 DAY))

            UNION ALL

            (SELECT 
                u.userID as id,
                'إكمال الساعات' as title,
                CONCAT('أتم الطالب ', u.fullName, ' جميع الساعات المطلوبة بنجاح.') as message,
                NOW() as event_time,
                'completed' as status
            FROM Users u
            JOIN Student s ON u.userID = s.studentID
            JOIN OpportunityRequest ar ON u.userID = ar.studentID
            WHERE ar.entityID = ? AND ar.entityStatus = 'مقبول'
            AND (SELECT SUM(hours) FROM Attendance WHERE studentID = u.userID AND status = 'حاضر') >= s.requiredVolunteerHours)

            ORDER BY event_time DESC LIMIT 20";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manager_id, $manager_id, $manager_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}