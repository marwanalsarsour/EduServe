<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerReportsController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $reports = $this->model->getOrganizationReports();
        require_once VIEW_PATH . '/volunteer/volunteer_employer_reports.php';
    }
}