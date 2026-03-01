<?php
require_once __DIR__ . '/../Core/Database.php';

class OpportunitiesController {
    
    public function index() {
        $db = (new Database())->getConnection();

        
        $stmt = $db->prepare("SELECT * FROM Opportunity WHERE Status = 'Open' ORDER BY CreatedAt DESC");
        $stmt->execute();
        $opportunities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once VIEW_PATH . '/student/student_opportunities.php';
    }
}