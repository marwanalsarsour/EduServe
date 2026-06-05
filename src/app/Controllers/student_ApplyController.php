<?php 
require_once __DIR__ . '/../Models/StudentModel.php'; 

class student_ApplyController {
    
  public function index() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    $opportunityId = $_GET['id'] ?? null;
    if (!$opportunityId) {
        header("Location: /student_opportunities");
        exit();
    }

    global $db, $db_connection, $conn;
    $activeConnection = $db_connection ?? $db ?? $conn;

    $studentModel = new StudentModel($activeConnection);

    $sql = "SELECT * FROM Opportunity WHERE opportunityID = :id AND isApproved = 1 AND status = 'نشط'";
    $stmt = $activeConnection->prepare($sql);
    $stmt->execute([':id' => $opportunityId]);
    $opportunity = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$opportunity) {
        die("عذراً، هذه الفرصة غير متاحة أو بانتظار الموافقة الأكاديمية.");
    }

    require_once VIEW_PATH . '/student/student_apply.php';
}

    public function submit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $studentId = $_SESSION['user_id'] ?? null;
        if (!$studentId) {
            die("يرجى تسجيل الدخول أولاً لإرسال الطلب.");
        }
        
        $opportunityId = $_POST['opportunity_id'] ?? null;
        $entityId = $_POST['entity_id'] ?? null;

        $cvPath = null;
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/cvs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = "cv_" . $studentId . "_" . time() . ".pdf";
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadDir . $fileName)) {
                $cvPath = '/uploads/cvs/' . $fileName;
            }
        }

        global $db, $db_connection, $conn;
        $activeConnection = $db_connection ?? $db ?? $conn;

        $studentModel = new StudentModel($activeConnection);
        $success = $studentModel->submitOpportunityRequest($studentId, $opportunityId, $entityId, $cvPath);

        if ($success) {
            $_SESSION['msg'] = "تم إرسال طلبك بنجاح! بانتظار موافقة المؤسسة والمشرف الأكاديمي.";
            header("Location: /student_my-application");
            exit();
        } else {
            die("حدث خطأ تقني أثناء معالجة الطلب.");
        }
    }
}