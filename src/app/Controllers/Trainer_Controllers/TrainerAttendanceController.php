<?php

class TrainerAttendanceController
{
    private $model;
    private $db;

    public function __construct($db = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/TrainerModel.php';
        $this->model = new TrainerModel($this->db);
    }

    public function index()
    {
        $entity_id = $_SESSION['user_id'] ?? null;
        $attendance_list = $this->model->getTodayAttendance($entity_id);
        
        require_once VIEW_PATH . '/trainer/trainer_attendance.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $entity_id = $_SESSION['user_id'];
                $student_id = $_POST['studentID'];

                $saveData = [
                    'studentID' => $student_id,
                    'entityID'  => $entity_id,
                    'date'      => date('Y-m-d'),
                    'checkIn'   => $_POST['checkIn'],
                    'checkOut'  => $_POST['checkOut'],
                    'hours'     => $_POST['hours'],
                    'status'    => $_POST['status'],
                    'notes'     => $_POST['notes'] ?? ''
                ];

                $success = $this->model->saveAttendance($saveData);
                echo json_encode(['success' => $success]);
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            exit;
        }
    }
}