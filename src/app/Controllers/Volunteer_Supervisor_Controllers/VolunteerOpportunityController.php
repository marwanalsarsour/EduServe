<?php
require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';

class VolunteerOpportunityController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new VolunteerSupervisorModel($db);
    }

    public function index() {
        $opportunities = $this->model->getAllOpportunities();
        $entities = $this->model->getOrganizations(); // لجلب المؤسسات للفورم
        require_once VIEW_PATH . '/volunteer/volunteer_opportunities.php';
    }

  public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $status = $_POST['status'] ?? 'نشط';

        if ($status === 'active') $status = 'نشط';
        elseif ($status === 'closed') $status = 'مغلق';
        elseif ($status === 'inactive') $status = 'مغلق';

        $data = [
            'title'        => $_POST['title'] ?? '',
            'type'         => $_POST['type'] ?? 'تطوع',
            'seats'        => $_POST['seats'] ?? 1,
            'conditions'   => $_POST['conditions'] ?? null,
            'entityID'     => $_POST['entityID'] ?? 0,
            'supervisorID' => $_SESSION['user_id'],
            'description'  => $_POST['description'] ?? null,
            'status'       => $status,
            'isApproved'   => 0
        ];

        if ($this->model->addOpportunity($data)) {
            header('Location: /volunteer_opportunities?status=created');
        } else {
            header('Location: /volunteer_opportunities?status=error');
        }
        exit;
    }
}

    public function edit($id) {
        $opportunity = $this->model->getOpportunityById($id);
        if (!$opportunity) {
            header('Location: /volunteer_opportunities?error=not_found');
            exit;
        }
        require_once VIEW_PATH . '/volunteer/volunteer_edit_opportunity.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['opportunity_id'];

            $status = $_POST['status'] ?? 'نشط';
            if ($status === 'active') $status = 'نشط';
            elseif ($status === 'closed') $status = 'مغلق';
            elseif ($status === 'inactive') $status = 'مغلق';

            $data = [
                'title'        => $_POST['title'] ?? '',
                'type'         => $_POST['type'] ?? 'تطوع',
                'seats'        => $_POST['seats'] ?? 1,
                'conditions'   => $_POST['conditions'] ?? null,
                'description'  => $_POST['description'] ?? null,
                'status'       => $status
            ];

            if ($this->model->updateOpportunity($id, $data)) {
                header('Location: /volunteer_opportunities?status=updated');
            } else {
                header("Location: /volunteer_edit_opportunity?id=$id&status=error");
            }
            exit;
        }
    }

    public function delete($id) {
        if ($id && $this->model->deleteOpportunity($id)) {
            header('Location: /volunteer_opportunities?status=deleted');
        } else {
            header('Location: /volunteer_opportunities?status=error');
        }
        exit;
    }
}