<?php
class ExternalTrainersController {
    private $model;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/ExternalEntityModel.php';
        
        $this->model = new ExternalEntityModel($this->db);
    }

    public function index() {
        $org_id = $_SESSION['user_id'];
        
        $trainer = $this->model->getTrainerByOrg($org_id);
        
        $availableStudents = $this->model->getUnassignedStudents($org_id);

        require_once VIEW_PATH . '/external-organization/external_trainers-management.php';
    }

    public function assign() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->assignStudentToTrainer($_POST['student_id'], $_POST['trainer_id']);
            header('Location: /external/trainers?success=assigned');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['trainer_id'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'specialization' => $_POST['specialization']
            ];
            
            $this->model->updateTrainer($data);
            
            header('Location: /external/trainers?success=updated');
            exit();
        }
    }
}