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

        // --- التعديل الجوهري هنا: جلب البيانات الصحيحة من جدول الفرصة مباشرة ---
        global $db, $db_connection, $conn;
        $activeConnection = $db_connection ?? $db ?? $conn;
        
        // جلب الـ entityID والـ supervisorID معاً لضمان سلامة العلاقات (Foreign Keys)
        $stmt = $activeConnection->prepare("SELECT entityID, supervisorID FROM Opportunity WHERE opportunityID = :oid");
        $stmt->execute([':oid' => $opportunityId]);
        $oppData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$oppData) {
            die("خطأ: بيانات الفرصة غير موجودة.");
        }

        $entityId = $oppData['entityID']; 
        $supervisorId = $oppData['supervisorID'] ?? 0; 
        
        // التحقق من أن الـ entityID ليس فارغاً لتجنب خطأ المفتاح الأجنبي
        if (empty($entityId)) {
            die("خطأ: لا يمكن إرسال الطلب لأن الفرصة لا ترتبط بجهة خارجية صالحة.");
        }
        // -------------------------------------------------------------

        $cvPath = null;
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/cvs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = "cv_" . $studentId . "_" . time() . ".pdf";
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadDir . $fileName)) {
                $cvPath = '/uploads/cvs/' . $fileName;
            }
        }

        $studentModel = new StudentModel($activeConnection);
        
        // الآن نمرر الـ 5 معاملات التي تتوقعها دالة الموديل:
        $success = $studentModel->submitOpportunityRequest($studentId, $opportunityId, $entityId, $supervisorId, $cvPath);

        if ($success) {
            $_SESSION['msg'] = "تم إرسال طلبك بنجاح!";
            header("Location: /student_my-application");
            exit();
        } else {
            die("حدث خطأ تقني أثناء معالجة الطلب.");
        }
    }
}