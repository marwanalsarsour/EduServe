<?php
class PendingOpportunitiesController {
    private $model;
    private $role;
    private $supervisorId;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->role = $_SESSION['user_role'] ?? '';
        $this->supervisorId = $_SESSION['user_id'] ?? null;
        
        require_once APP_PATH . '/Models/SupervisorModel.php';
        require_once APP_PATH . '/Models/VolunteerSupervisorModel.php';
        
        // إنشاء الموديل المناسب بناءً على الدور
        $this->model = ($this->role === 'مشرف تدريب') ? new SupervisorModel($db) : new VolunteerSupervisorModel($db);
    }

    public function index() {
        // جلب الفرص المعلقة حسب نوع المشرف
        $data['opportunities'] = $this->model->getPendingOpportunities();
        require_once VIEW_PATH . '/shared/pending_opportunities.php';
    }

    public function approve() {
        $id = $_POST['opportunity_id'] ?? null;
        
        // التأكد من وجود ID للفرصة و ID للمشرف في السيشن
        if ($id && $this->supervisorId) {
            
            // استخدام instanceof للتحقق من نوع الموديل وتمرير الـ supervisorId للطرفين
            if ($this->model instanceof SupervisorModel) {
                // مشرف تدريب
                $this->model->approveOpportunity($id, $this->supervisorId);
            } else {
                // مشرف تطوع (تم تحديثها لتستقبل الـ supervisorId)
                $this->model->approveVolunteerOpportunity($id, $this->supervisorId);
            }
        }
        
        // إعادة التوجيه إلى صفحة الفرص المعلقة بعد إتمام العملية
        header('Location: /supervisor_pending-opportunities');
        exit();
    }
}