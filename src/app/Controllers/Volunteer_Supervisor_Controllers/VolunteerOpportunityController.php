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
        require_once VIEW_PATH . '/volunteer/volunteer_opportunities.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title'       => $_POST['title'],
                'org'         => $_POST['org'],
                'hours'       => $_POST['hours'],
                'description' => $_POST['description']
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
            $data = [
                'title'       => $_POST['title'],
                'org'         => $_POST['org'],
                'hours'       => $_POST['hours'],
                'description' => $_POST['description'],
                'status'      => $_POST['status']
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