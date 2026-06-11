<?php

require_once __DIR__ . '/../Models/StudentModel.php';

class student_PortfolioController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['user_id']) ||
            ($_SESSION['user_role'] !== 'طالب' &&
             $_SESSION['user_role'] !== 'student')
        ) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];

        $studentModel = new StudentModel($this->db);
        $student = $studentModel->getStudentProfile($studentId);
        $certificates = $studentModel->getStudentCertificates($studentId);
        $volunteerWorks = $studentModel->getStudentVolunteerWorks($studentId);
        $certsCount = $studentModel->getCertificatesCount($studentId);
        $trainingCount = $studentModel->getAcceptedTrainingCount($studentId);
        $volunteerCount = $studentModel->getVolunteerCount($studentId);
        $trainings = $studentModel->getStudentTrainings($studentId);

        require_once VIEW_PATH . '/student/student_portfolio.php';
    }
}