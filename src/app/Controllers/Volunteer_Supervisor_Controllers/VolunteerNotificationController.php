<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerNotificationController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $notifications = $this->model->getLiveNotifications();
        
        $data = ['notifications' => $notifications];
        require_once VIEW_PATH . '/volunteer/volunteer_notifications.php';
    }
}