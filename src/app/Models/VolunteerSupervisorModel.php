<?php

class VolunteerSupervisorModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDashboardStats() {
        $liveNotifications = $this->getLiveNotifications();
        $realNotificationCount = count($liveNotifications);

        return [
            'active_opportunities' => $this->getCustomCount('Opportunity', "status = 'نشط' AND type = 'تطوع'"),
            'pending_applications' => $this->getCustomCount('OpportunityRequest', "supervisorStatus = 'بانتظار المشرف'"),
            'pending_hours'        => $this->getCustomSum('Attendance', 'hours', "status = 'متأخر'"),
            'today_notifications'  => $realNotificationCount,
            'pending_opportunities'=> $this->getCustomCount('Opportunity', "isApproved = 0 AND type = 'تطوع'")
        ];
    }

    public function approveVolunteerOpportunity($opportunityId, $supervisorId) {
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

    public function getRecentApplications($limit = 5) {
        $sql = "SELECT opr.requestID as id, u.fullName as student_name, op.title as opportunity_title, opr.requestDate as created_at 
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.supervisorStatus = 'بانتظار المشرف' AND op.type = 'تطوع'
                ORDER BY opr.requestDate DESC LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // الدالة المصلحة للحضور (بدون academicStatus)
    public function getPendingAcademicAttendance() {
        $sql = "SELECT 
                    att.attendanceID,
                    att.studentID,
                    u.fullName AS student_name,
                    att.date,
                    att.checkIn,
                    att.checkOut,
                    att.hours,
                    att.status,
                    att.notes
                FROM Attendance att
                JOIN Users u ON att.studentID = u.userID
                WHERE att.status = 'متأخر'
                ORDER BY att.date DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // دالة اعتماد الحضور المصلحة
    public function approveDailyAttendance($attendanceID) {
        $sql1 = "SELECT orq.supervisorID
                 FROM Attendance att
                 JOIN OpportunityRequest orq 
                    ON att.studentID = orq.studentID 
                   AND att.opportunityID = orq.opportunityID
                 WHERE att.attendanceID = :id";

        $stmt1 = $this->db->prepare($sql1);
        $stmt1->execute([':id' => $attendanceID]);
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

        if (!$row) return false;

        $supervisorID = $row['supervisorID'];
        
        $sql2 = "UPDATE Attendance 
                 SET status = 'حاضر',
                     academicSupervisorID = :supervisorID,
                     academicApprovedAt = NOW()
                 WHERE attendanceID = :id";

        $stmt2 = $this->db->prepare($sql2);

        return $stmt2->execute([
            ':id' => $attendanceID,
            ':supervisorID' => $supervisorID
        ]);
    }

    public function getStudentsForApproval() {
        $sql = "SELECT opr.requestID as application_id, u.fullName as student_name, op.title as opportunity_title, 
                       (SELECT SUM(hours) FROM Attendance WHERE studentID = opr.studentID AND status = 'حاضر') as confirmed_hours
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.supervisorStatus = 'معتمد' AND op.type = 'تطوع'"; 
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateFinalApproval($application_id, $hours, $result) {
        $sql = "UPDATE OpportunityRequest SET supervisorStatus = 'معتمد', rejectReason = :result WHERE requestID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':result' => $result, ':id' => $application_id]);
    }

    public function getOpportunityById($id) {
        $sql = "SELECT
                    o.*,
                    ee.entityName AS entity_name,
                    u.fullName AS supervisor_name
                FROM Opportunity o
                LEFT JOIN ExternalEntity ee ON o.entityID = ee.entityID
                LEFT JOIN AcademicSupervisor s ON o.supervisorID = s.supervisorID
                LEFT JOIN Users u ON s.supervisorID = u.userID
                WHERE o.opportunityID = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOpportunity($id, $data) {
        $sql = "UPDATE Opportunity 
                SET title = :title, description = :description, status = :status 
                WHERE opportunityID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':status'      => $data['status'],
            ':id'          => $id
        ]);
    }

    public function getOrganizationReports() {
        $sql = "SELECT ev.reportID, ev.content, ev.period, ev.rating, ev.data, u.fullName as student_name, ee.entityName as org_name 
                FROM EvaluationReport ev
                JOIN Users u ON ev.studentID = u.userID
                JOIN ExternalEntity ee ON ev.entityID = ee.entityID
                ORDER BY ev.data DESC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentsForFinalGrading() {
        $sql = "SELECT opr.requestID as application_id, u.fullName as student_name, opr.studentID as student_id_number 
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.supervisorStatus = 'معتمد' AND op.type = 'تطوع'"; 
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function submitFinalEvaluation($application_id, $grade, $recommendations) {
        $sql = "UPDATE OpportunityRequest 
                SET supervisorStatus = 'معتمد', 
                    rejectReason = CONCAT('التقييم: ', :grade, ' - توصيات: ', :rec)
                WHERE requestID = :id";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':grade' => $grade,
            ':rec'   => $recommendations,
            ':id'    => $application_id
        ]);
    }

    public function getLiveNotifications() {
        $notifications = [];
        // ... (تم اختصارها لنفس كودك السابق)
        return $notifications;
    }

    private function time_elapsed_string($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        if ($diff->d > 0) return 'منذ ' . $diff->d . ' يوم';
        if ($diff->h > 0) return 'منذ ' . $diff->h . ' ساعة';
        if ($diff->i > 0) return 'منذ ' . $diff->i . ' دقيقة';
        return 'الآن';
    }

    private function getCustomCount($table, $condition) {
        $stmt = $this->db->query("SELECT COUNT(*) FROM $table WHERE $condition");
        return $stmt->fetchColumn() ?: 0;
    }

    private function getCustomSum($table, $column, $condition) {
        $stmt = $this->db->query("SELECT SUM($column) FROM $table WHERE $condition");
        return $stmt->fetchColumn() ?: 0;
    }

    public function getAllOpportunities() {
        $sql = "SELECT Opportunity.*, ExternalEntity.entityName AS entity_name 
                FROM Opportunity 
                LEFT JOIN ExternalEntity ON Opportunity.entityID = ExternalEntity.entityID 
                WHERE Opportunity.type = 'تطوع' 
                ORDER BY Opportunity.createdAt DESC";
            
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOpportunity($data) {
        $sql = "INSERT INTO Opportunity (opportunityID, title, type, seats, entityID, supervisorID, status, createdAt, description) 
                VALUES (:id, :title, 'تطوع', :seats, :entityID, :supervisorID, 'نشط', NOW(), :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'           => $data['id'],
            ':title'        => $data['title'],
            ':seats'        => $data['seats'],
            ':entityID'     => $data['entityID'],
            ':supervisorID' => $data['supervisorID'],
            ':description'  => $data['description']
        ]);
    }

    public function deleteOpportunity($id) {
        $sql = "DELETE FROM Opportunity WHERE opportunityID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getSupervisorProfile($id) {
        $sql = "SELECT u.* FROM Users u WHERE u.userID = :id AND (u.role = 'مشرف تطوع' OR u.role = 'volunteer_supervisor')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $name, $email, $phone) {
        $sql = "UPDATE Users SET fullName = :name, email = :email, phoneNumber = :phone WHERE userID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':id' => $id]);
    }

    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET password = :password WHERE userID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':password' => $hashed_password, ':id' => $id]);
    }

    public function getAllApplications() {
        $sql = "SELECT opr.*, u.fullName as student_name, s.majorName as major, op.title as opportunity_title 
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Student s ON opr.studentID = s.studentID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.supervisorStatus = 'بانتظار المشرف' AND op.type = 'تطوع'
                ORDER BY opr.requestDate DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateApplicationStatus($app_id, $status) {
        $sql = "UPDATE OpportunityRequest SET supervisorStatus = :status WHERE requestID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $app_id]);
    }

    public function getActiveVolunteers() {
        $sql = "SELECT opr.requestID as application_id, u.userID as student_id, u.fullName as student_name, 
                       s.academicYear as university_id, op.title as opportunity_title, 
                       s.requiredVolunteerHours as required_hours,
                       COALESCE((SELECT SUM(hours) FROM Attendance WHERE studentID = u.userID AND status = 'حاضر'), 0) as completed_hours
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Student s ON opr.studentID = s.studentID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.supervisorStatus = 'معتمد' AND op.type = 'تطوع'
                ORDER BY u.fullName ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApplicationDetails($app_id) {
        $sql = "SELECT opr.*, u.fullName as student_name, s.academicYear as university_id, s.majorName as major,
                       op.title as opportunity_title, s.requiredVolunteerHours as req_hours, ee.entityName as org_name
                FROM OpportunityRequest opr
                JOIN Users u ON opr.studentID = u.userID
                JOIN Student s ON opr.studentID = s.studentID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                JOIN ExternalEntity ee ON op.entityID = ee.entityID
                WHERE opr.requestID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $app_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentPreviousHours($student_id) {
        $sql = "SELECT SUM(att.hours) as total_hours, COUNT(DISTINCT opr.opportunityID) as total_opps 
                FROM OpportunityRequest opr
                JOIN Attendance att ON opr.studentID = att.studentID
                JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                WHERE opr.studentID = :student_id AND opr.supervisorStatus = 'معتمد' AND att.status = 'حاضر' AND op.type = 'تطوع'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPendingOpportunities() {
        $sql = "SELECT * FROM Opportunity WHERE isApproved = 0 AND type = 'تطوع'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}