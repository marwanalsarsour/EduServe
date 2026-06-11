<?php

class TrainerProfileController
{
    private $model;
    private $db;

    public function __construct($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;

        require_once APP_PATH . '/Models/TrainerModel.php';

        $this->model = new TrainerModel($this->db);
    }

    public function index()
    {
        $trainer_id = $_SESSION['user_id'];

        $profile = $this->model->getTrainerProfile($trainer_id);

        if (!$profile) {
            $profile = [
                'employeeName' => '',
                'employeeEmail' => '',
                'entityName' => '',
                'location' => ''
            ];
        }

        require_once VIEW_PATH . '/trainer/trainer_profile.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $trainer_id = $_SESSION['user_id'];

            $data = [
                'employeeName'  => $_POST['employeeName'] ?? '',
                'employeeEmail' => $_POST['employeeEmail'] ?? '',
                'location'      => $_POST['location'] ?? ''
            ];

            $this->model->updateProfile($trainer_id, $data);

            header('Location: /trainer/profile?status=success');
            exit();
        }
    }
}