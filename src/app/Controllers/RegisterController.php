<?php

require_once __DIR__ . '/../models/User.php';

class RegisterController {
    private $userModel;

    public function __construct($db = null) {
        if ($db !== null) {
            $this->userModel = new User($db);
        } else {
            global $db_connection; 
            $this->userModel = new User($db_connection); 
        }
    }

    public function showRegisterForm() {
        require_once VIEW_PATH . '/auth/register.php';
    }

    public function processRegistration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $registrationData = [
                'fullname'    => trim($_POST['fullname']),
                'email'       => trim($_POST['email']),
                'password'    => $_POST['password'],
                'phoneNumber' => trim($_POST['phoneNumber']),
                'role'        => $_POST['role']
            ];

            if (empty($registrationData['email']) || empty($registrationData['password']) || empty($registrationData['role'])) {
                die("يرجى ملء جميع الحقول المطلوبة بشكل صحيح.");
            }

            if ($this->userModel->emailExists($registrationData['email'])) {
                header("Location: /register?error=email_exists");
                exit();
            }

            if ($registrationData['role'] === 'student') {
                $registrationData['majorName']    = $_POST['majorName'] ?? '';
                $registrationData['academicYear'] = $_POST['academicYear'] ?? 1;
            } 
            elseif ($registrationData['role'] === 'academic_supervisor') {
                $registrationData['departmentName'] = $_POST['departmentName'] ?? '';
                $registrationData['supervision_type'] = $_POST['supervision_type'] ?? ''; 
            } 
            elseif ($registrationData['role'] === 'external_entity') {
                $registrationData['entityName']    = $_POST['entityName'] ?? '';
                $registrationData['location']      = $_POST['location'] ?? '';
                $registrationData['employeeName']  = $_POST['employeeName'] ?? '';
                $registrationData['employeeEmail'] = $_POST['employeeEmail'] ?? '';
            }

            if ($this->userModel->registerUser($registrationData)) {
                header("Location: /login?registration=success");
                exit();
            } else {
                header("Location: /register?error=failed");
                exit();
            }
        }
    }
}