<?php
class PendingOpportunitiesController {
    private $model;
    private $role;
    private $supervisorId;

    public function __construct($db) { // أضفت $db هنا لضمان تمريره
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->role = $_SESSION['user_role'] ?? '';
        $this->supervisorId = $_SESSION['user_id'] ?? null;
        
        require_once APP_PATH . '/Models/SupervisorModel.php';
        require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';
        
        $this->model = ($this->role === 'مشرف تدريب') ? new SupervisorModel($db) : new VolunteerSupervisorModel($db);
    }

    public function index() {
        $data['opportunities'] = $this->model->getPendingOpportunities();
        require_once VIEW_PATH . '/shared/pending_opportunities.php';
    }

    public function approve() {
        $id = $_POST['opportunity_id'] ?? null;
        if ($id) {
            if ($this->model instanceof SupervisorModel) {
                $this->model->approveOpportunity($id, $this->supervisorId);
            } else {
                $this->model->approveVolunteerOpportunity($id);
            }
        }
        header('Location: /supervisor_pending-opportunities');
        exit();
    }
}