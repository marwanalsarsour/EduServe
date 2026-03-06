<?php
require_once __DIR__ . '/../Core/Database.php';

class student_ReportsController {
    
   
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $db = (new Database())->getConnection();
        
        
        $stmt = $db->prepare("SELECT * FROM StudentReports WHERE studentID = :sid ORDER BY reportID DESC");
        $stmt->execute(['sid' => $studentId]);
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once VIEW_PATH . '/student/student_reports.php';
    }

    
     
    public function submit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            die("غير مصرح بالوصول.");
        }

        $db = (new Database())->getConnection();
        $studentId = $_SESSION['user_id'];
        
      
        $reportType = $_POST['reportType'] ?? 'General';
        $content = $_POST['content'] ?? '';

        
        $stmtOpp = $db->prepare("SELECT OpportunityID FROM Applications WHERE StudentID = :sid AND Status = 'Accepted' LIMIT 1");
        $stmtOpp->execute(['sid' => $studentId]);
        $opp = $stmtOpp->fetch(PDO::FETCH_ASSOC);
        
       
        $opportunityId = $opp['OpportunityID'] ?? null;

       
        $filePath = null;
        if (isset($_FILES['report_file']) && $_FILES['report_file']['error'] === UPLOAD_ERR_OK) {
            
            $uploadDir = BASE_PATH . '/public/uploads/reports/';
            
          
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            
            $extension = pathinfo($_FILES['report_file']['name'], PATHINFO_EXTENSION);
            $fileName = "report_" . $studentId . "_" . time() . "." . $extension;
            
            if (move_uploaded_file($_FILES['report_file']['tmp_name'], $uploadDir . $fileName)) {
               
                $filePath = '/uploads/reports/' . $fileName;
            }
        }

      
        $stmt = $db->prepare("
            INSERT INTO StudentReports (reportType, content, data, studentID, opportunityID) 
            VALUES (:type, :content, :data, :sid, :oid)
        ");
        
        $success = $stmt->execute([
            'type'    => $reportType,
            'content' => $content,
            'data'    => $filePath, 
            'sid'     => $studentId,
            'oid'     => $opportunityId
        ]);

        if ($success) {
            $_SESSION['msg'] = "تم رفع التقرير بنجاح.";
            header("Location: /student_reports");
            exit();
        } else {
            
            if ($filePath && file_exists(BASE_PATH . '/public' . $filePath)) {
                unlink(BASE_PATH . '/public' . $filePath);
            }
            die("خطأ فني: فشل تسجيل بيانات التقرير في النظام.");
        }
    }
}