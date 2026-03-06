<?php
require_once __DIR__ . '/../Core/Database.php';


class student_MyApplicationsController {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $db = (new Database())->getConnection();
        
       
        $studentId = $_SESSION['user_id'] ?? null;

        if (!$studentId) {
            header("Location: /login");
            exit();
        }

        
        $stmt = $db->prepare("
            SELECT ar.*, o.Title, o.Type, org.Name as OrganizationName
            FROM OpportunityRequest ar
            JOIN Opportunity o ON ar.OpportunityID = o.OpportunityID
            JOIN Organization org ON o.OrganizationID = org.OrganizationID
            WHERE ar.StudentID = :sid
            ORDER BY ar.RequestDate DESC
        ");
        $stmt->execute(['sid' => $studentId]);
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once VIEW_PATH . '/student/student_my-application.php';
    }
}