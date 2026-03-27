<?php

class student_OpportunityDetailsController extends Controller {
    
    public function index() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /student_opportunities");
            exit();
        }

        $studentModel = $this->model('StudentModel');
        $opportunity = $studentModel->getOpportunityFullDetails($id);

        if (!$opportunity) {
            die("الفرصة غير موجودة أو تم حذفها.");
        }

        require_once VIEW_PATH . '/student/student_opportunity-details.php';
    }
}