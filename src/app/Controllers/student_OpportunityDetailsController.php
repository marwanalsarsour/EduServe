<?php
require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_OpportunityDetailsController {
    
    public function index() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /student_opportunities");
            exit();
        }

        global $db, $db_connection, $conn;
        $activeConnection = $db_connection ?? $db ?? $conn;

        $studentModel = new StudentModel($activeConnection);
        
        $opportunity = $studentModel->getOpportunityById($id);

        if (!$opportunity) {
            die("الفرصة غير موجودة أو تم حذفها.");
        }

        require_once VIEW_PATH . '/student/student_opportunity-details.php';
    }
}