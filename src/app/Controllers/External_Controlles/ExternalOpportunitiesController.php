<?php
require_once APP_PATH . '/Models/ExternalEntityModel.php';

class ExternalOpportunitiesController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new ExternalEntityModel($db);
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'external_entity') {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        $org_id = $_SESSION['user_id'];
        $opportunities = $this->model->getOpportunities($org_id, $search);
        require_once VIEW_PATH . '/external-organization/external_opoportunities-management.php';
    }


    public function create() {
        require_once VIEW_PATH . '/external-organization/external_adding-opportunities.php';
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $org_id = $_SESSION['user_id'];
            if ($this->model->createOpportunity($org_id, $_POST)) {
                header('Location: /external/opportunities?success=added');
            } else {
                header('Location: /external/opportunities/add?error=failed');
            }
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->model->updateOpportunity($_POST['id'], $_POST);
            header('Location: /external/opportunities?success=updated');
            exit;
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->model->deleteOpportunity($_POST['id']);
            header('Location: /external/opportunities?success=deleted');
            exit;
        }
    }
}