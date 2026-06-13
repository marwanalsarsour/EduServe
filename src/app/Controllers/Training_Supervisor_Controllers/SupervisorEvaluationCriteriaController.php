<?php

require_once APP_PATH . '/Models/SupervisorModel.php';

class SupervisorEvaluationCriteriaController {

    private $model;

    public function __construct($db) {
        $this->model = new SupervisorModel($db);
    }

    public function index() {

        $criteria = $this->model->getAllEvaluationCriteria();

        require VIEW_PATH .
        '/supervisor/supervisor_evaluation_criteria.php';
    }

    public function add() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['criterionName']);
            $score = intval($_POST['maxScore']);

            $this->model->addEvaluationCriterion(
                $name,
                $score
            );
        }

        header('Location: /supervisor_evaluation_criteria');
        exit;
    }

    public function update() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = intval($_POST['criterionID']);

            $name = trim($_POST['criterionName']);

            $score = intval($_POST['maxScore']);

            $this->model->updateEvaluationCriterion(
                $id,
                $name,
                $score
            );
        }

        header('Location: /supervisor_evaluation_criteria');
        exit;
    }

    public function delete($id) {

        $this->model->deleteEvaluationCriterion($id);

        header('Location: /supervisor_evaluation_criteria');
        exit;
    }
}