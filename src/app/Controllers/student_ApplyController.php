<?php
require_once __DIR__ . '/../Core/Database.php';

class student_ApplyController {
    
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $opportunityId = $_GET['id'] ?? null;
        if (!$opportunityId) {
            header("Location: /student_opportunities");
            exit();
        }

        $db = (new Database())->getConnection();
        $stmt = $db->prepare("
            SELECT o.*, org.Name as OrganizationName, o.OrganizationID 
            FROM Opportunity o
            JOIN Organization org ON o.OrganizationID = org.OrganizationID
            WHERE o.OpportunityID = :id
        ");
        $stmt->execute(['id' => $opportunityId]);
        $opportunity = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$opportunity) {
            die("الفرصة المطلوبة غير متوفرة حالياً.");
        }

        require_once VIEW_PATH . '/student/student_apply.php';
    }

    
    public function submit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $db = (new Database())->getConnection();
        $studentId = $_SESSION['user_id'];
        $opportunityId = $_POST['opportunity_id'];
        $entityId = $_POST['entity_id'];

       
        $cvPath = null;
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/cvs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = "cv_" . $studentId . "_" . time() . ".pdf";
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadDir . $fileName)) {
                $cvPath = '/uploads/cvs/' . $fileName;
            }
        }

        
        $stmt = $db->prepare("
            INSERT INTO OpportunityRequest 
            (requestDate, studentID, opportunityID, entityID, entityStatus, supervisorStatus, CV_Path) 
            VALUES (NOW(), :sid, :oid, :eid, 'Pending', 'Pending', :cv)
        ");
        
        $success = $stmt->execute([
            'sid' => $studentId,
            'oid' => $opportunityId,
            'eid' => $entityId,
            'cv'  => $cvPath
        ]);

        if ($success) {
            $_SESSION['msg'] = "تم إرسال طلبك بنجاح! بانتظار موافقة المؤسسة والمشرف الأكاديمي.";
            header("Location: /student_my-application");
            exit();
        } else {
            die("حدث خطأ تقني أثناء معالجة الطلب.");
        }
    }
}