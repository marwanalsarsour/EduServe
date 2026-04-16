<?php

class SupervisorModel {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function getSupervisorProfile($id) {
        $query = "SELECT name, email, phone, department, faculty FROM Users WHERE id = :id AND role = 'supervisor' LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $data) {
        $query = "UPDATE Users SET name = :name, email = :email, phone = :phone WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':name'  => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':id'    => $id
        ]);
    }

    public function updatePassword($id, $new_password) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE Users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':password' => $hashed, ':id' => $id]);
    }

    public function getSupervisorData($id) {
        $query = "SELECT name, email FROM Users WHERE id = :id AND role = 'supervisor' LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDashboardStats($supervisor_id) {
        $stats = [];
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Students WHERE supervisor_id = :sid");
        $stmt->execute([':sid' => $supervisor_id]);
        $stats['students_count'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Reports r JOIN Students s ON r.student_id = s.id WHERE s.supervisor_id = :sid AND r.status = 'pending'");
        $stmt->execute([':sid' => $supervisor_id]);
        $stats['pending_reports'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Training_Applications WHERE supervisor_id = :sid AND status = 'pending'");
        $stmt->execute([':sid' => $supervisor_id]);
        $stats['pending_applications'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Notifications WHERE user_id = :sid AND is_read = 0");
        $stmt->execute([':sid' => $supervisor_id]);
        $stats['unread_notifications'] = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT AVG(progress_value) FROM Students WHERE supervisor_id = :sid");
        $stmt->execute([':sid' => $supervisor_id]);
        $stats['average_progress'] = round($stmt->fetchColumn() ?? 0);

        return $stats;
    }

    public function getRecentActivity($supervisor_id) {
        $query = "SELECT s.name as student_name, a.description, a.created_at as date 
                  FROM Student_Activities a
                  JOIN Students s ON a.student_id = s.id
                  WHERE s.supervisor_id = :sid
                  ORDER BY a.created_at DESC LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sid', $supervisor_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOpportunity($data) {
        $query = "INSERT INTO Training_Opportunities 
                  (supervisor_id, title, type, organization, location, duration, start_date, deadline, seats, contact_email, contact_phone, status, description, requirements) 
                  VALUES 
                  (:supervisor_id, :title, :type, :organization, :location, :duration, :start_date, :deadline, :seats, :contact_email, :contact_phone, :status, :description, :requirements)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':supervisor_id' => $data['supervisor_id'],
            ':title'         => $data['title'],
            ':type'          => $data['type'],
            ':organization'  => $data['organization'],
            ':location'      => $data['location'],
            ':duration'      => $data['duration'],
            ':start_date'    => $data['start_date'],
            ':deadline'      => $data['deadline'],
            ':seats'         => $data['seats'],
            ':contact_email' => $data['contact_email'],
            ':contact_phone' => $data['contact_phone'],
            ':status'        => $data['status'],
            ':description'   => $data['description'],
            ':requirements'  => $data['requirements']
        ]);
    }
    
    public function getPendingApplications($supervisor_id) {
        $query = "SELECT ta.id, u.name as student_name, topp.title as opportunity, ta.status 
                  FROM Training_Applications ta
                  JOIN Users u ON ta.student_id = u.id
                  JOIN Training_Opportunities topp ON ta.opportunity_id = topp.id
                  WHERE ta.supervisor_id = :sid AND ta.status = 'pending'";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateApplicationStatus($app_id, $status) {
        $query = "UPDATE Training_Applications SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $app_id
        ]);
    }

    public function getPendingAttendance($supervisor_id) {
        $query = "SELECT sa.id, u.name as student_name, sa.week_number as week, sa.hours_worked as hours, sa.status 
                  FROM Student_Attendance sa
                  JOIN Users u ON sa.student_id = u.id
                  JOIN Students s ON s.id = u.id
                  WHERE s.supervisor_id = :sid AND sa.status = 'pending'";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAttendanceStatus($attendance_id, $status) {
        $query = "UPDATE Student_Attendance SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => $attendance_id
        ]);
    }

    public function getOpportunityById($id) {
        $query = "SELECT * FROM Training_Opportunities WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOpportunity($id, $data) {
        $query = "UPDATE Training_Opportunities SET 
                    title = :title, 
                    type = :type, 
                    organization = :organization, 
                    location = :location, 
                    duration = :duration, 
                    start_date = :start_date, 
                    deadline = :deadline, 
                    seats = :seats, 
                    contact_email = :contact_email, 
                    contact_phone = :contact_phone, 
                    status = :status, 
                    description = :description, 
                    requirements = :requirements 
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':title'         => $data['title'],
            ':type'          => $data['type'],
            ':organization'  => $data['organization'],
            ':location'      => $data['location'],
            ':duration'      => $data['duration'],
            ':start_date'    => $data['start_date'],
            ':deadline'      => $data['deadline'],
            ':seats'         => $data['seats'],
            ':contact_email' => $data['contact_email'],
            ':contact_phone' => $data['contact_phone'],
            ':status'        => $data['status'],
            ':description'   => $data['description'],
            ':requirements'  => $data['requirements'],
            ':id'            => $id
        ]);
    }

    public function getCompanyReports($supervisor_id) {
        $query = "SELECT 
                    u.name as student_name, 
                    ce.company_name, 
                    ce.rating, 
                    ce.notes, 
                    ce.created_at as report_date,
                    ce.id as report_id
                  FROM Company_Evaluations ce
                  JOIN Users u ON ce.student_id = u.id
                  JOIN Students s ON s.id = u.id
                  WHERE s.supervisor_id = :sid
                  ORDER BY ce.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveFinalEvaluation($data) {
        $query = "INSERT INTO Final_Evaluations (student_id, supervisor_id, final_grade, notes, created_at) 
                  VALUES (:student_id, :supervisor_id, :final_grade, :notes, NOW())
                  ON DUPLICATE KEY UPDATE 
                  final_grade = :final_grade, 
                  notes = :notes, 
                  updated_at = NOW()";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':student_id'    => $data['student_id'],
            ':supervisor_id' => $data['supervisor_id'],
            ':final_grade'   => $data['final_grade'],
            ':notes'         => $data['notes']
        ]);
    }


    public function getStudentById($student_id, $supervisor_id) {
        $query = "SELECT * FROM Students WHERE id = :student_id AND supervisor_id = :sid LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':student_id' => $student_id, ':sid' => $supervisor_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOpportunitiesBySupervisor($supervisor_id) {
        $query = "SELECT id, title, organization, status FROM Training_Opportunities 
                  WHERE supervisor_id = :sid ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteOpportunity($id, $supervisor_id) {
        $query = "DELETE FROM Training_Opportunities WHERE id = :id AND supervisor_id = :sid";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id, ':sid' => $supervisor_id]);
    }

    public function getPendingReports($supervisor_id) {
        $query = "SELECT r.id, u.name as student_name, r.week_number, r.file_path, r.created_at, r.status 
                  FROM Reports r
                  JOIN Students s ON r.student_id = s.id
                  JOIN Users u ON s.id = u.id
                  WHERE s.supervisor_id = :sid AND r.status = 'pending'
                  ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':sid' => $supervisor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateReportStatus($report_id, $status, $feedback = null) {
        $query = "UPDATE Reports SET status = :status, feedback = :feedback WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status'   => $status,
            ':feedback' => $feedback,
            ':id'       => $report_id
        ]);
    }

    public function getFullStudentDetails($student_id) {
        $query = "SELECT u.name, u.email, u.phone, s.university_id, s.major, s.portfolio_link, s.academic_transcript 
                  FROM Students s
                  JOIN Users u ON s.id = u.id
                  WHERE s.id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentReports($student_id) {
        $query = "SELECT title, status, created_at FROM Reports 
                  WHERE student_id = :id 
                  ORDER BY created_at DESC LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupervisedStudents($supervisor_id, $searchTerm = '') {
        $sql = "SELECT 
                    u.id, 
                    u.name, 
                    s.major, 
                    s.university_id,
                    s.required_hours,
                    (SELECT SUM(hours_worked) FROM Student_Attendance WHERE student_id = u.id AND status = 'approved') as completed_hours,
                    (SELECT organization FROM Training_Opportunities JOIN Training_Applications ON Training_Opportunities.id = Training_Applications.opportunity_id WHERE Training_Applications.student_id = u.id AND Training_Applications.status = 'accepted' LIMIT 1) as company,
                    (SELECT COUNT(*) FROM Reports WHERE student_id = u.id AND status = 'pending') as pending_reports_count,
                    s.status
                FROM Students s
                JOIN Users u ON s.id = u.id
                WHERE s.supervisor_id = :sid";

        if (!empty($searchTerm)) {
            $sql .= " AND (u.name LIKE :search OR s.university_id LIKE :search OR s.major LIKE :search)";
        }

        $stmt = $this->db->prepare($sql);
        $params = [':sid' => $supervisor_id];
        if (!empty($searchTerm)) {
            $params[':search'] = '%' . $searchTerm . '%';
        }
        
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}