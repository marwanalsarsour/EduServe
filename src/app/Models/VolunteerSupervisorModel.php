<?php

class VolunteerSupervisorModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDashboardStats() {
        return [
            'active_opportunities' => $this->getCount('Volunteer_Opportunities', "status = 'active'"),
            'pending_applications' => $this->getCount('Volunteer_Applications', "status = 'pending'"),
            'pending_hours'        => $this->getSum('Volunteer_Hours', 'hours_worked', "status = 'pending'"),
            'today_notifications'  => 7 
        ];
    }

    public function getRecentApplications($limit = 5) {
        $sql = "SELECT va.id, u.name as student_name, vo.title as opportunity_title, va.created_at 
                FROM Volunteer_Applications va
                JOIN Users u ON va.student_id = u.id
                JOIN Volunteer_Opportunities vo ON va.opportunity_id = vo.id
                WHERE va.status = 'pending'
                ORDER BY va.created_at DESC LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingAttendance() {
        $sql = "SELECT vh.*, u.name as student_name 
                FROM Volunteer_Hours vh
                JOIN Volunteer_Applications va ON vh.application_id = va.id
                JOIN Users u ON va.student_id = u.id
                WHERE vh.status = 'confirmed' 
                ORDER BY vh.date DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveDailyAttendance($hour_id) {
        $sql = "UPDATE Volunteer_Hours SET status = 'approved' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $hour_id]);
    }

    public function getStudentsForApproval() {
        $sql = "SELECT va.id as application_id, u.name as student_name, vo.title as opportunity_title, 
                       (SELECT SUM(hours_worked) FROM Volunteer_Hours WHERE application_id = va.id AND status = 'approved') as confirmed_hours
                FROM Volunteer_Applications va
                JOIN Users u ON va.student_id = u.id
                JOIN Volunteer_Opportunities vo ON va.opportunity_id = vo.id
                WHERE va.status = 'accepted'"; 
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateFinalApproval($application_id, $hours, $result) {
        $sql = "UPDATE Volunteer_Applications SET final_hours = :hours, evaluation = :result, status = 'completed' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':hours' => $hours, ':result' => $result, ':id' => $application_id]);
    }

    public function getOpportunityById($id) {
        $sql = "SELECT * FROM Volunteer_Opportunities WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOpportunity($id, $data) {
        $sql = "UPDATE Volunteer_Opportunities 
                SET title = :title, org_name = :org, hours = :hours, description = :description, status = :status 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':org'         => $data['org'],
            ':hours'       => $data['hours'],
            ':description' => $data['description'],
            ':status'      => $data['status'],
            ':id'          => $id
        ]);
    }

    public function getOrganizationReports() {
        $sql = "SELECT vr.*, u.name as student_name, vo.org_name 
                FROM Volunteer_Reports vr
                JOIN Volunteer_Applications va ON vr.application_id = va.id
                JOIN Users u ON va.student_id = u.id
                JOIN Volunteer_Opportunities vo ON va.opportunity_id = vo.id
                ORDER BY vr.created_at DESC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentsForFinalGrading() {
    $sql = "SELECT va.id as application_id, u.name as student_name, u.student_id_number 
            FROM Volunteer_Applications va
            JOIN Users u ON va.student_id = u.id
            WHERE va.status = 'accepted'"; 
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
   }
   public function submitFinalEvaluation($application_id, $grade, $recommendations) {
    $sql = "UPDATE Volunteer_Applications 
            SET evaluation = :grade, 
                supervisor_recommendations = :rec, 
                status = 'completed',
                completed_at = NOW() 
            WHERE id = :id";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':grade' => $grade,
        ':rec'   => $recommendations,
        ':id'    => $application_id
    ]);
    }

    public function getLiveNotifications() {
        $notifications = [];

        $sql1 = "SELECT u.name, vo.title, va.created_at 
                 FROM Volunteer_Applications va
                 JOIN Users u ON va.student_id = u.id
                 JOIN Volunteer_Opportunities vo ON va.opportunity_id = vo.id
                 WHERE va.status = 'pending' 
                 ORDER BY va.created_at DESC LIMIT 5";
        
        $pendingApps = $this->db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pendingApps as $app) {
            $notifications[] = [
                'title' => 'طلب تطوع بانتظار المراجعة',
                'message' => "قام الطالب {$app['name']} بالتقديم على فرصة ({$app['title']}).",
                'time_ago' => $this->time_elapsed_string($app['created_at']),
                'is_read' => false
            ];
        }

        $sql2 = "SELECT u.name, vh.date, vh.hours_worked 
                 FROM Volunteer_Hours vh
                 JOIN Volunteer_Applications va ON vh.application_id = va.id
                 JOIN Users u ON va.student_id = u.id
                 WHERE vh.status = 'confirmed' 
                 ORDER BY vh.date DESC LIMIT 5";
        
        $pendingHours = $this->db->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pendingHours as $hour) {
            $notifications[] = [
                'title' => 'اعتماد ساعات عمل',
                'message' => "المؤسسة أكدت حضور الطالب {$hour['name']} بواقع {$hour['hours_worked']} ساعة ليوم {$hour['date']}.",
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

    private function getCount($table, $condition) {
        $stmt = $this->db->query("SELECT COUNT(*) FROM $table WHERE $condition");
        return $stmt->fetchColumn() ?: 0;
    }

    private function getSum($table, $column, $condition) {
        $stmt = $this->db->query("SELECT SUM($column) FROM $table WHERE $condition");
        return $stmt->fetchColumn() ?: 0;
    }

    public function getAllOpportunities() {
        $sql = "SELECT * FROM Volunteer_Opportunities ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOpportunity($data) {
        $sql = "INSERT INTO Volunteer_Opportunities (title, org_name, hours, description, status, created_at) 
                VALUES (:title, :org, :hours, :description, 'active', NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title'       => $data['title'],
            ':org'         => $data['org'],
            ':hours'       => $data['hours'],
            ':description' => $data['description']
        ]);
    }

    public function deleteOpportunity($id) {
        $sql = "DELETE FROM Volunteer_Opportunities WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

public function getSupervisorProfile($id) {
    $sql = "SELECT * FROM users WHERE id = :id AND role = 'volunteer_supervisor'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateProfile($id, $name, $email, $phone) {
    $sql = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id";
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
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':password' => $hashed_password,
        ':id'       => $id
    ]);
}

public function getAllApplications() {
    $sql = "SELECT va.*, u.name as student_name, u.major, vo.title as opportunity_title 
            FROM volunteer_applications va
            JOIN users u ON va.student_id = u.id
            JOIN volunteer_opportunities vo ON va.opportunity_id = vo.id
            WHERE va.status = 'pending'
            ORDER BY va.applied_at DESC";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public function updateApplicationStatus($app_id, $status) {
    $sql = "UPDATE volunteer_applications SET status = :status WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':status' => $status, ':id' => $app_id]);
}

public function getActiveVolunteers() {
    $sql = "SELECT va.id as application_id, u.id as student_id, u.name as student_name, 
                   u.university_id, vo.title as opportunity_title, 
                   vo.hours as required_hours, va.completed_hours
            FROM volunteer_applications va
            JOIN users u ON va.student_id = u.id
            JOIN volunteer_opportunities vo ON va.opportunity_id = vo.id
            WHERE va.status = 'approved'
            ORDER BY u.name ASC";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public function getApplicationDetails($app_id) {
    $sql = "SELECT va.*, u.name as student_name, u.university_id, u.major, u.gpa, u.level,
                   vo.title as opportunity_title, vo.hours as req_hours, org.name as org_name
            FROM volunteer_applications va
            JOIN users u ON va.student_id = u.id
            JOIN volunteer_opportunities vo ON va.opportunity_id = vo.id
            JOIN users org ON vo.organization_id = org.id
            WHERE va.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $app_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getStudentPreviousHours($student_id) {
    $sql = "SELECT SUM(completed_hours) as total_hours, COUNT(id) as total_opps 
            FROM volunteer_applications 
            WHERE student_id = :student_id AND status = 'completed'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateApplicationStatus($app_id, $status) {
    $sql = "UPDATE volunteer_applications SET status = :status WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':status' => $status, ':id' => $app_id]);
}
}