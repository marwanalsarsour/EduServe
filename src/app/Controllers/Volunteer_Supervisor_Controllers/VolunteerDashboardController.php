<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerDashboardController {
    private $model;

    public function __construct() {
       
        global $db; 
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
      
        $data = [
            'stats' => $this->model->getDashboardStats(),
            'applications' => $this->model->getRecentApplications()
        ];

     
        require_once VIEW_PATH . '/volunteer/volunteer_dashboard.php';
    }
}