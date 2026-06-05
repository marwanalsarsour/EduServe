<?php
class TrainerNotificationsController {
    private $model;
    private $db;

    public function __construct($db = null) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/TrainerModel.php';
        
        $this->model = new TrainerModel($this->db);
    }

    public function index() {
        $trainer_id = $_SESSION['user_id'];
        $raw_notifications = $this->model->getRecentStudentEvents($trainer_id);
        
        foreach ($raw_notifications as &$n) {
            $n['time_ago'] = $this->timeAgo($n['event_time']);
        }

        $data = ['notifications' => $raw_notifications];
        
        require_once VIEW_PATH . '/trainer/trainer_notifications.php';
    }

    private function timeAgo($timestamp) {
        $time = strtotime($timestamp);
        $diff = time() - $time;
        if ($diff < 60) return 'الآن';
        if ($diff < 3600) return 'منذ ' . round($diff / 60) . ' دقيقة';
        if ($diff < 86400) return 'منذ ' . round($diff / 3600) . ' ساعة';
        return date('Y-m-d', $time);
    }
}