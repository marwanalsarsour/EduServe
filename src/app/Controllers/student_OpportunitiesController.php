<?php

class student_OpportunitiesController extends Controller {
    
    public function index() {
        $studentModel = $this->model('StudentModel');
        $opportunities = $studentModel->getOpenOpportunities();
        
        require_once VIEW_PATH . '/student/student_opportunities.php';
    }
}