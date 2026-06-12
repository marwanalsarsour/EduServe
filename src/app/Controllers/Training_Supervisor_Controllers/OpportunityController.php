<?php
require_once APP_PATH . '/Models/SupervisorModel.php';

class OpportunityController {
    private $model;

    public function __construct() {
        global $db;
        $this->model = new SupervisorModel($db);
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header('Location: /login'); exit; }
    }

    public function index() {
        $opportunities = $this->model->getOpportunitiesBySupervisor($_SESSION['user_id']);
        $data = ['opportunities' => $opportunities];
        require_once VIEW_PATH . '/supervisor/supervisor-opportunities.php';
    }

    public function create() {
        // الآن ستعمل هذه الدالة بعد إضافتها في الـ Model
        $entities = $this->model->getAllEntities();
        require_once VIEW_PATH . '/supervisor/supervisor-add-opportunity.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title'         => $_POST['title'] ?? '',
                'type'          => $_POST['type'] ?? '',
                'seats'         => $_POST['seats'] ?? 0,
                'status'        => $_POST['status'] ?? 'نشط',
                'description'   => $_POST['description'] ?? '',
                'conditions'    => $_POST['conditions'] ?? '', 
                'entityID'      => $_POST['entityID'] ?? null, 
                'supervisor_id' => $_SESSION['user_id']
            ];

            if ($this->model->addOpportunity($data)) {
                $_SESSION['success_msg'] = "تمت إضافة فرصة التدريب بنجاح!";
                header('Location: /supervisor/opportunities');
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء الحفظ.";
                header('Location: /supervisor/add-opportunity');
            }
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: /supervisor/opportunities'); exit; }

        $opportunity = $this->model->getOpportunityById($id);
        if (!$opportunity) { die("الفرصة المطلوبة غير موجودة."); }

        $data = ['opportunity' => $opportunity];
        require_once VIEW_PATH . '/supervisor/supervisor-edit-opportunity.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) { header('Location: /supervisor/opportunities'); exit; }

            $data = $this->capturePostData();
            
            if ($this->model->updateOpportunity($id, $data)) {
                $_SESSION['success_msg'] = "تم تحديث البيانات بنجاح.";
                header('Location: /supervisor/opportunities');
            } else {
                $_SESSION['error_msg'] = "حدث خطأ أثناء التحديث.";
                header("Location: /supervisor/edit-opportunity?id=$id");
            }
            exit;
        }
    }

    public function delete($id) {
        if ($this->model->deleteOpportunity($id, $_SESSION['user_id'])) {
            $_SESSION['success_msg'] = "تم حذف الفرصة بنجاح.";
        } else {
            $_SESSION['error_msg'] = "فشلت العملية.";
        }
        header('Location: /supervisor/opportunities');
        exit;
    }

    private function capturePostData() {
        return [
            'title'        => $_POST['title'] ?? '',
            'type'         => $_POST['type'] ?? '',
            'seats'        => $_POST['seats'] ?? 0,
            'status'       => $_POST['status'] ?? 'نشط',
            'description'  => $_POST['description'] ?? '',
            'conditions'   => $_POST['conditions'] ?? '',
            'entityID'     => $_POST['entityID'] ?? null,
            'location'     => $_POST['location'] ?? ''
        ];
    }
}