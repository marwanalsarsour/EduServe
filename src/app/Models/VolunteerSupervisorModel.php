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
            'today_notifications'  => $realNotificationCount 
        ];
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

    public function getPendingAttendance() {
        $sql = "SELECT att.attendanceID, att.date, att.hours, u.fullName as student_name, att.notes
                FROM Attendance att
                JOIN Users u ON att.studentID = u.userID
                WHERE att.status = 'متأخر' 
                ORDER BY att.date DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveDailyAttendance($hour_id) {
        $sql = "UPDATE Attendance SET status = 'حاضر' WHERE attendanceID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $hour_id]);
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
        $sql = "SELECT * FROM Opportunity WHERE opportunityID = :id";
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

        $sql1 = "SELECT u.fullName as name, vo.title, va.requestDate as created_at 
                 FROM OpportunityRequest va
                 JOIN Users u ON va.studentID = u.userID
                 JOIN Opportunity vo ON va.opportunityID = vo.opportunityID
                 WHERE va.supervisorStatus = 'بانتظار المشرف' AND vo.type = 'تطوع'
                 ORDER BY va.requestDate DESC LIMIT 5";
        
        $pendingApps = $this->db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pendingApps as $app) {
            $notifications[] = [
                'title' => 'طلب تطوع بانتظار المراجعة',
                'message' => "قام الطالب {$app['name']} بالتقديم على فرصة ({$app['title']}).",
                'time_ago' => $this->time_elapsed_string($app['created_at']),
                'is_read' => false
            ];
        }

        $sql2 = "SELECT u.fullName as name, vh.date, vh.hours 
                 FROM Attendance vh
                 JOIN Users u ON vh.studentID = u.userID
                 JOIN OpportunityRequest opr ON u.userID = opr.studentID
                 JOIN Opportunity op ON opr.opportunityID = op.opportunityID
                 WHERE vh.status = 'متأخر' AND op.type = 'تطوع'
                 ORDER BY vh.date DESC LIMIT 5";
        
        $pendingHours = $this->db->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pendingHours as $hour) {
            $notifications[] = [
                'title' => 'اعتماد ساعات تطوع',
                'message' => "المؤسسة أكدت حضور الطالب {$hour['name']} بواقع {$hour['hours']} ساعة ليوم {$hour['date']}.",
                'time_ago' => 'اليوم',
                'is_read' => false
            ];
        }

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
        $sql = "SELECT * FROM Opportunity WHERE type = 'تطوع' ORDER BY createdAt DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOpportunity($data) {
        $sql = "INSERT INTO Opportunity (opportunityID, title, type, seats, entityID, supervisorID, status, createdAt, description) 
                VALUES (:id, :title, 'تطوع', :seats, :entityID, :supervisorID, 'نشط', NOW(), :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'          => $data['id'],
            ':title'       => $data['title'],
            ':seats'       => $data['seats'],
            ':entityID'    => $data['entityID'],
            ':supervisorID'=> $data['supervisorID'],
            ':description' => $data['description']
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
        return $stmt->execute([
            ':name'  => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':id'    => $id
        ]);
    }

    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET password = :password WHERE userID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':password' => $hashed_password,
            ':id'       => $id
        ]);
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
                       s.requiredTrainingHours as required_hours,
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
                       op.title as opportunity_title, s.requiredTrainingHours as req_hours, ee.entityName as org_name
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
}