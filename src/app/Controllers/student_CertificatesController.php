<?php
require_once __DIR__ . '/../Core/Database.php';

class student_CertificatesController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $db = (new Database())->getConnection();

        try {
       
            $stmt = $db->prepare("SELECT * FROM Certificates WHERE StudentID = :id ORDER BY IssueDate DESC");
            $stmt->execute(['id' => $studentId]);
            $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $certificates = [];
        }

        
        require_once VIEW_PATH . '/student/student_certificates.php';
    }
}