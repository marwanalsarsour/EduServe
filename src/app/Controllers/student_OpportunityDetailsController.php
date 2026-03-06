<?php
require_once __DIR__ . '/../Core/Database.php';

class student_OpportunityDetailsController {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: /student_opportunities");
            exit();
        }

        $db = (new Database())->getConnection();

        
        $stmt = $db->prepare("
            SELECT o.*, org.Name as OrganizationName, org.Email as OrgEmail, org.Phone as OrgPhone
            FROM Opportunity o
            JOIN Organization org ON o.OrganizationID = org.OrganizationID
            WHERE o.OpportunityID = :id
        ");
        $stmt->execute(['id' => $id]);
        $opportunity = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$opportunity) {
            die("الفرصة غير موجودة أو تم حذفها.");
        }

        require_once VIEW_PATH . '/student/student_opportunity-details.php';
    }
}