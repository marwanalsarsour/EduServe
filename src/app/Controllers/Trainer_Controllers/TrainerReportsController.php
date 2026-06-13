<?php
class TrainerReportsController {
    private $model;
    private $db;

    public function __construct($db = null) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        global $db;
        $this->db = $db;
        
        require_once APP_PATH . '/models/TrainerModel.php';
        
        $this->model = new TrainerModel($this->db);
    }

public function index() {

    $trainer_id = $_SESSION['user_id'];

    $students = $this->model->getMyStudents($trainer_id);

    $criteria = $this->model->getEvaluationCriteria();

    require_once VIEW_PATH .
    '/trainer/trainer_reports.php';
}

 public function processMonthly() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = [

            'student_id' => $_POST['student_id'],

            'entity_id' => $_SESSION['user_id'],

            'period' => $_POST['period'],

            'rating' => $_POST['rating'],

            'summary' => $_POST['summary']
        ];

        $this->model->saveMonthlyReport($data);

        header('Location: /trainer/reports?success=monthly');
        exit();
    }
}

 public function processFinal() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $evaluationID =
            $this->model->saveFinalEvaluation([

                'student_id' => $_POST['student_id'],

                'entity_id' => $_SESSION['user_id'],

                'total_hours' => $_POST['total_hours'],

                'feedback' => $_POST['feedback']
            ]);

        $criteria =
            $this->model->getEvaluationCriteria();

        foreach ($criteria as $criterion) {

            $field =
                'criterion_' .
                $criterion['criterionID'];

            if (isset($_POST[$field])) {

                $this->model
                    ->saveFinalEvaluationScore(

                        $evaluationID,

                        $criterion['criterionID'],

                        $_POST[$field]
                    );
            }
        }

        header('Location: /trainer/reports?success=final');
        exit();
    }
}
}