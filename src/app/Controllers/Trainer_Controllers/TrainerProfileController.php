<?php
class TrainerProfileController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        require_once '../src/models/TrainerModel.php';
        $this->model = new TrainerModel($this->db);
    }

    public function index() {
        $trainer_id = $_SESSION['user_id'];
        $profile = $this->model->getTrainerProfile($trainer_id);
        require_once '../src/views/trainer/trainer_profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trainer_id = $_SESSION['user_id'];
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            ];
            $this->model->updateProfile($trainer_id, $data);
            header('Location: /trainer/profile?status=success');
        }
    }
}