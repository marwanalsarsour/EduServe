<?php
class VManagerReportsController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/VolunteerManagerModel.php';
        $this->model = new VolunteerManagerModel($this->db);
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        
        $summary = $this->model->getReportsSummary($manager_id);
        $performance = $this->model->getVolunteersPerformance($manager_id);

        require_once '../src/views/v_manager/v_manager_reports.php';
    }
}