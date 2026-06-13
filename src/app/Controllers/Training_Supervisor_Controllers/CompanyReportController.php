<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class CompanyReportController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

   public function index()
{
    $reports = $this->model->getCompanyReports($_SESSION['user_id']);

    $finalEvaluations = $this->model->getFinalEvaluations($_SESSION['user_id']);

    $data = [
        'reports' => $reports,
        'finalEvaluations' => $finalEvaluations
    ];

    require_once VIEW_PATH . '/supervisor/supervisor-employer-reports.php';
}
}