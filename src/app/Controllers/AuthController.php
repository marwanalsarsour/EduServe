<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $db;

    public function __construct($db = null) {
        $this->db = $db;
    }
    
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header('Location: /login?error=empty_fields');
            exit();
        }

        if (!$this->db) {
            $database = new Database();
            $this->db = $database->getConnection();
        }
        
        $userModel = new User($this->db);
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['userID'];     
            $_SESSION['user_name'] = $user['fullName']; 
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['is_logged_in'] = true;

            switch ($user['role']) {
                case 'طالب':
                case 'student':
                    header('Location: /student_dashboard');
                    break;
                    
                case 'مشرف تدريب':
                case 'supervisor':
                case 'academic_supervisor':
                    header('Location: /supervisor_dashboard');
                    break;
                    
                case 'مشرف تطوع':
                case 'volunteer_supervisor':
                    header('Location: /volunteer_dashboard');
                    break;
                    
                case 'جهة خارجية':
                case 'external_entity':
                    header('Location: /external_dashboard'); 
                    break;
                    
                case 'إدارة كلية':
                case 'college_admin':
                case 'admin':
                case 'مدير':
                    header('Location: /admin/admin_dashboard');
                    break;
                    
                default:
                    header('Location: /login?error=unknown_role');
            }
            exit();
        } else {
            header('Location: /login?error=wrong_credentials');
            exit();
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
        header('Location: /login');
        exit();
    }
}