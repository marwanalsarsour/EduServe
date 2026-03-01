<?php
require_once __DIR__ . '/../Core/Database.php';

class StudentDashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
            header('Location: /login');
            exit();
        }

        $db = (new Database())->getConnection();
        $studentId = $_SESSION['user_id'];

        
        $stmt = $db->prepare("SELECT * FROM Student WHERE UserID = :id LIMIT 1");
        $stmt->execute(['id' => $studentId]);
        $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $stmt = $db->prepare("
            SELECT orq.*, op.Title as OpportunityTitle, op.OrganizationName 
            FROM OpportunityRequest orq
            JOIN Opportunity op ON orq.OpportunityID = op.OpportunityID
            WHERE orq.StudentID = :id 
            ORDER BY orq.RequestDate DESC LIMIT 1
        ");
        $stmt->execute(['id' => $studentId]);
        $latestRequest = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM Certificate WHERE StudentID = :id");
        $stmt->execute(['id' => $studentId]);
        $certCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

       
        require_once VIEW_PATH . '/student/dashboard.view.php';
    }
}