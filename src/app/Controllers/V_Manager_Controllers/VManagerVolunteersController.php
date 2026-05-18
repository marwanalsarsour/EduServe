<?php
class VManagerVolunteersController {
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
        $search = $_GET['search'] ?? '';
        
        $volunteers = $this->model->getMyVolunteers($manager_id, $search);

        foreach ($volunteers as &$v) {
            $required = $v['required_hours'] > 0 ? $v['required_hours'] : 50; // افتراضي 50 ساعة
            $v['progress_percent'] = min(100, round(($v['completed_hours'] / $required) * 100));
            $v['required_limit'] = $required;
        }

        $data = [
            'volunteers' => $volunteers,
            'search' => $search
        ];
        
        require_once '../src/views/v_manager/v_manager_list.php';
    }
}