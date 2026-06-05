<?php

require_once __DIR__ . '/../Core/Database.php'; 

class AdminModel {
    private $db;


    public function __construct($db_connection = null) {
        if ($db_connection !== null) {
            $this->db = $db_connection;
        } else {
            global $db; 
            if (isset($db) && $db !== null) {
                $this->db = $db;
            } else {
                $database = new Database();
                $this->db = $database->getConnection();
            }
        }
    }

    public function getDashboardStats() {
        // الآن ستعمل الـ query بشكل آمن لأن $this->db مستحيل أن تكون null
        $totalAccountsQuery = $this->db->query("SELECT COUNT(userID) as total FROM Users");
        $totalAccounts = $totalAccountsQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $activeStudentsQuery = $this->db->query("SELECT COUNT(userID) as total FROM Users WHERE role = 'طالب'");
        $activeStudents = $activeStudentsQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $pendingCertificatesQuery = $this->db->query("SELECT COUNT(*) as total FROM Certificate WHERE isApproved = 0");
        $pendingCertificates = $pendingCertificatesQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $currentMonth = date('m');
        $currentYear = date('Y');
        $monthlyAttendanceQuery = $this->db->query("SELECT COUNT(*) as total FROM Attendance WHERE MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'");
        $monthlyReports = $monthlyAttendanceQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return [
            'totalAccounts'       => $totalAccounts,
            'activeStudents'      => $activeStudents,
            'pendingCertificates' => $pendingCertificates,
            'monthlyReports'      => $monthlyReports
        ];
    }

    public function getAllUsers() {
        $query = $this->db->query("SELECT userID, fullName, email, phoneNumber, role FROM Users ORDER BY userID DESC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($userID, $fullName, $email, $password, $phoneNumber, $role) {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE Users SET fullName = :fullName, email = :email, password = :password, phoneNumber = :phoneNumber, role = :role WHERE userID = :userID");
            $stmt->bindParam(':password', $hashedPassword);
        } else {
            $stmt = $this->db->prepare("UPDATE Users SET fullName = :fullName, email = :email, phoneNumber = :phoneNumber, role = :role WHERE userID = :userID");
        }

        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteUser($userID) {
        $stmt = $this->db->prepare("DELETE FROM Users WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getQualifiedStudents() {
        $query = $this->db->query("SELECT userID, fullName, role FROM Users WHERE role = 'طالب' ORDER BY fullName ASC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

public function issueCertificate($studentId, $certTitle, $secureKeyHash, $verificationCode) {
    $stmt = $this->db->prepare("
        SELECT opportunityID, entityID 
        FROM OpportunityRequest 
        WHERE studentID = :studentID 
        LIMIT 1
    ");
    $stmt->bindParam(':studentID', $studentId, PDO::PARAM_INT);
    $stmt->execute();
    $oppData = $stmt->fetch(PDO::FETCH_ASSOC);

    $opportunityId = $oppData['opportunityID'] ?? null;
    $entityId      = $oppData['entityID'] ?? null;

    $stmt = $this->db->prepare("SELECT certificateID FROM Certificate WHERE studentID = :studentID AND opportunityID = :opportunityID");
    $stmt->bindParam(':studentID', $studentId, PDO::PARAM_INT);
    $stmt->bindParam(':opportunityID', $opportunityId, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return false; 
    }

    $generatedID = rand(100000, 999999);
    $currentDate = date('Y-m-d');

    $stmt = $this->db->prepare("
        INSERT INTO Certificate (certificateID, issueDate, isApproved, studentID, entityID, opportunityID) 
        VALUES (:certificateID, :issueDate, 1, :studentID, :entityID, :opportunityID)
    ");
    
    $stmt->bindParam(':certificateID', $generatedID, PDO::PARAM_INT);
    $stmt->bindParam(':issueDate', $currentDate);
    $stmt->bindParam(':studentID', $studentId, PDO::PARAM_INT);
    $stmt->bindParam(':entityID', $entityId, PDO::PARAM_INT);
    $stmt->bindParam(':opportunityID', $opportunityId, PDO::PARAM_INT);

    return $stmt->execute();
}

    public function getAdvancedStatistics() {
        $studentsQuery = $this->db->query("SELECT COUNT(userID) as total FROM Users WHERE role = 'طالب'");
        $totalStudents = $studentsQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $hoursQuery = $this->db->query("SELECT SUM(hours) as total FROM Attendance");
        $totalHours = $hoursQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        if (!$totalHours) $totalHours = 0; 

        $partnersQuery = $this->db->query("SELECT COUNT(entityID) as total FROM ExternalEntity");
        $totalPartners = $partnersQuery->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return [
            'totalStudents' => $totalStudents,
            'totalHours'    => $totalHours,
            'totalPartners' => $totalPartners
        ];
    }

    public function getPartnersReport() {
        $sql = "SELECT 
                    ee.entityName as partner_name,
                    (SELECT COUNT(DISTINCT studentID) FROM Attendance WHERE entityID = ee.entityID) as student_count,
                    (SELECT IFNULL(SUM(hours), 0) FROM Attendance WHERE entityID = ee.entityID) as total_hours,
                    u.phoneNumber as partner_phone
                FROM ExternalEntity ee
                JOIN Users u ON ee.entityID = u.userID
                ORDER BY total_hours DESC";
                
        $query = $this->db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDynamicNotifications() {
        $notifications = [];
        $currentDate = date('Y-m-d H:i');

        $requestsQuery = $this->db->query("
            SELECT opr.requestID, u.fullName, opr.requestDate 
            FROM OpportunityRequest opr
            JOIN Users u ON opr.studentID = u.userID 
            WHERE opr.supervisorStatus = 'بانتظار المشرف' 
            ORDER BY opr.requestDate DESC 
            LIMIT 5
        ");

        if ($requestsQuery) {
            while ($row = $requestsQuery->fetch(PDO::FETCH_ASSOC)) {
                $notifications[] = [
                    'type' => 'audit',
                    'icon' => 'bi-exclamation-triangle-fill',
                    'title' => 'طلب فرصة معلق وبانتظار الإشراف',
                    'message' => 'هناك طلب انضمام لفرصة تدريب/تطوع مقدم من الطالب ' . htmlspecialchars($row['fullName']) . ' بانتظار معالجة المشرف.',
                    'link' => '/admin/requests?id=' . $row['requestID'],
                    'btn_text' => 'مراجعة الطلب',
                    'time' => $row['requestDate']
                ];
            }
        }

        $studentsHoursQuery = $this->db->query("
            SELECT u.userID, u.fullName, SUM(att.hours) as total_hours 
            FROM Users u
            JOIN Attendance att ON u.userID = att.studentID
            WHERE u.role = 'طالب' 
            AND u.userID NOT IN (SELECT studentID FROM Certificate)
            GROUP BY u.userID, u.fullName
            HAVING total_hours >= 100
            LIMIT 5
        ");

        if ($studentsHoursQuery) {
            while ($row = $studentsHoursQuery->fetch(PDO::FETCH_ASSOC)) {
                $notifications[] = [
                    'type' => 'certificate',
                    'icon' => 'bi-award-fill',
                    'title' => 'وصول طالب للحد المستحق للشهادة',
                    'message' => 'أتم الطالب ' . htmlspecialchars($row['fullName']) . ' عدداً كبيراً من الساعات الميدانية (' . $row['total_hours'] . ' ساعة). النظام يقترح مراجعة حسابه لإصدار شهادته.',
                    'link' => '/admin/certificates',
                    'btn_text' => 'إصدار وثيقة رقمية',
                    'time' => $currentDate
                ];
            }
        }

        usort($notifications, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return $notifications;
    }
   public function getAdminProfile($adminID) {
    $stmt = $this->db->prepare("SELECT userID, fullName, email, phoneNumber, role FROM Users WHERE userID = :userID LIMIT 1");
    $stmt->bindParam(':userID', $adminID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function updateAdminProfile($adminID, $fullName, $email, $phoneNumber, $password = null) {
        $checkEmail = $this->db->prepare("SELECT userID FROM Users WHERE email = :email AND userID != :userID");
        $checkEmail->bindParam(':email', $email);
        $checkEmail->bindParam(':userID', $adminID, PDO::PARAM_INT);
        $checkEmail->execute();
        if ($checkEmail->rowCount() > 0) {
            return 'email_exists'; 
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE Users SET fullName = :fullName, email = :email, phoneNumber = :phoneNumber, password = :password WHERE userID = :userID");
            $stmt->bindParam(':password', $hashedPassword);
        } else {
            $stmt = $this->db->prepare("UPDATE Users SET fullName = :fullName, email = :email, phoneNumber = :phoneNumber WHERE userID = :userID");
        }

        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':userID', $adminID, PDO::PARAM_INT);

        return $stmt->execute();
    }
}