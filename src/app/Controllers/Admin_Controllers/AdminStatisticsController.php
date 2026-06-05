<?php

require_once __DIR__ . '/../../Models/AdminModel.php';

class AdminStatisticsController {
    private $adminModel;

    public function __construct($db = null) {
        $this->adminModel = new AdminModel($db);
    }

    public function index() {
        $stats = $this->adminModel->getAdvancedStatistics();
        $partners = $this->adminModel->getPartnersReport();

        require_once VIEW_PATH . '/admin/admin_statistics.php';
    }
}