<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class OpportunityController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $opportunities = $this->model->getOpportunitiesBySupervisor($_SESSION['user_id']);
        $data = ['opportunities' => $opportunities];
        require_once VIEW_PATH . '/supervisor/supervisor-opportunities.php';
    }

    public function create() {
        require_once VIEW_PATH . '/supervisor/supervisor-add-opportunity.php';
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->capturePostData();
            $data['supervisor_id'] = $_SESSION['user_id'];

            if ($this->model->addOpportunity($data)) {
                $_SESSION['success_msg'] = "تمت إضافة فرصة التدريب بنجاح!";
                header('Location: /supervisor/opportunities'); 
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء الحفظ، حاول مرة أخرى.";
                header('Location: /supervisor/add-opportunity');
            }
            exit;
        }
    }


    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /supervisor/opportunities');
            exit;
        }

        $opportunity = $this->model->getOpportunityById($id);
        
        if (!$opportunity) {
            die("الفرصة المطلوبة غير موجودة أو تم حذفها.");
        }

        $data = ['opportunity' => $opportunity];
        require_once VIEW_PATH . '/supervisor/supervisor-edit-opportunity.php';
    }


    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /supervisor/opportunities');
                exit;
            }

            $data = $this->capturePostData();

            if ($this->model->updateOpportunity($id, $data)) {
                $_SESSION['success_msg'] = "تم تحديث بيانات الفرصة بنجاح.";
                header('Location: /supervisor/opportunities');
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء تحديث البيانات.";
                header("Location: /supervisor/edit-opportunity?id=$id");
            }
            exit;
        }
    }


    public function delete($id) {
        if ($this->model->deleteOpportunity($id, $_SESSION['user_id'])) {
            $_SESSION['success_msg'] = "تم حذف الفرصة بنجاح.";
        } else {
            $_SESSION['error_msg'] = "عذراً، فشلت عملية الحذف.";
        }
        header('Location: /supervisor/opportunities');
        exit;
    }


    private function capturePostData() {
        return [
            'title'         => $_POST['title'] ?? '',
            'type'          => $_POST['type'] ?? '',
            'organization'  => $_POST['organization'] ?? '',
            'location'      => $_POST['location'] ?? '',
            'duration'      => $_POST['duration'] ?? '',
            'start_date'    => $_POST['start_date'] ?? '',
            'deadline'      => $_POST['deadline'] ?? '',
            'seats'         => $_POST['seats'] ?? 0,
            'contact_email' => $_POST['contact_email'] ?? '',
            'contact_phone' => $_POST['contact_phone'] ?? '',
            'status'        => $_POST['status'] ?? 'active',
            'description'   => $_POST['description'] ?? '',
            'requirements'  => $_POST['requirements'] ?? ''
        ];
    }
}