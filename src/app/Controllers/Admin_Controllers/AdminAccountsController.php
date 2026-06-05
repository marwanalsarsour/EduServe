<?php

require_once __DIR__ . '/../../Models/AdminModel.php'; 

class AdminAccountsController {
    private $adminModel;

    public function __construct($db = null) {
        $this->adminModel = new AdminModel($db);
    }

    public function index() {
        $users = $this->adminModel->getAllUsers();
        
        require_once VIEW_PATH . '/admin/admin_accounts.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userID      = $_POST['userID'] ?? 0;
            $fullName    = $_POST['fullName'] ?? '';
            $email       = $_POST['email'] ?? '';
            $password    = $_POST['password'] ?? ''; 
            $phoneNumber = $_POST['phoneNumber'] ?? '';
            $role        = $_POST['role'] ?? '';

            if ($this->adminModel->updateUser($userID, $fullName, $email, $password, $phoneNumber, $role)) {
                header("Location: /admin/accounts?success=updated");
                exit;
            }
        }
    }

    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userID = $_POST['userID'] ?? 0;

            if ($this->adminModel->deleteUser($userID)) {
                header("Location: /admin/accounts?success=deleted");
                exit;
            }
        }
    }
}