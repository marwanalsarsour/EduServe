<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    
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

        $database = new Database();
        $db = $database->getConnection();
        $userModel = new User($db);

        $user = $userModel->findByEmail($email);

    
        if ($user && password_verify($password, $user['password'])) {
            
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['is_logged_in'] = true;

          
            switch ($user['role']) {
                case 'student':
                    header('Location: /student_dashboard');
                    break;
                case 'supervisor':
                    header('Location: /supervisor_dashboard');
                    break;
                case 'admin':
                    header('Location: /admin_dashboard');
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