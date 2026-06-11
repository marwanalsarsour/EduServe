<?php

require_once __DIR__ . '/../../Models/StudentModel.php';

class ExternalStudentPortfolioController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function show($id)
    {
        $studentModel = new StudentModel($this->db);

        $student = $studentModel->getStudentProfile($id);
        $certificates = $studentModel->getStudentCertificates($id);
        $volunteerWorks = $studentModel->getStudentVolunteerWorks($id);
        $certsCount = $studentModel->getCertificatesCount($id);
        $trainingCount = $studentModel->getAcceptedTrainingCount($id);
        $volunteerCount = $studentModel->getVolunteerCount($id);
        $trainings = $studentModel->getStudentTrainings($id);

        require VIEW_PATH . '/external-organization/external_student_portfolio.php';
    }
}