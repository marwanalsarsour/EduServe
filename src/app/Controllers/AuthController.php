<?php


class AuthController {
    public function login() {
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        
        if (empty($email) || empty($password)) {
            header('Location: /login?error=empty_fields');
            exit();
        }

       
        if ($email === "student@ppu.edu" && $password === "123456") {
            
            
            session_start();
            $_SESSION['student_name'] = "أحمد محمد";
            $_SESSION['is_logged_in'] = true;

            
            header('Location: /student_dashboard');
            exit();
        } else {
            
            header('Location: /login?error=wrong_credentials');
            exit();
        }
    }
}