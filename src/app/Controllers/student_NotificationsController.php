<?php
require_once __DIR__ . '/../Core/Database.php';

class student_NotificationsController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $db = (new Database())->getConnection();
        $notifications = [];

        try {
          
            $stmt = $db->prepare("SELECT CompanyName, academic_status, external_status, updated_at 
                                  FROM Applications 
                                  WHERE StudentID = :id 
                                  ORDER BY updated_at DESC LIMIT 3");
            $stmt->execute(['id' => $studentId]);
            $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($apps as $app) {
                
                if ($app['academic_status'] == 'Accepted' && $app['external_status'] == 'Pending') {
                    $notifications[] = [
                        'title' => 'موافقة أكاديمية',
                        'message' => "تمت الموافقة على طلبك لدى " . $app['CompanyName'] . " من قبل المشرف الأكاديمي، وبانتظار رد الجهة الخارجية.",
                        'icon' => 'bi-person-check', 
                        'color' => 'blue' 
                    ];
                } 
               
                elseif ($app['academic_status'] == 'Accepted' && $app['external_status'] == 'Accepted') {
                    $notifications[] = [
                        'title' => 'قبول نهائي!',
                        'message' => "تهانينا! تمت الموافقة النهائية على تدريبك لدى " . $app['CompanyName'] . " من المشرف والجهة الخارجية.",
                        'icon' => 'bi-check-circle-fill', 
                        'color' => 'green' 
                    ];
                }
            }

           
            $stmtOp = $db->prepare("SELECT title, company_name FROM Opportunities 
                                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 2 DAY) 
                                    ORDER BY created_at DESC LIMIT 3");
            $stmtOp->execute();
            $newOps = $stmtOp->fetchAll(PDO::FETCH_ASSOC);

            foreach ($newOps as $op) {
                $notifications[] = [
                    'title' => 'فرصة تدريب جديدة',
                    'message' => "تمت إضافة فرصة جديدة: " . $op['title'] . " لدى " . $op['company_name'] . ". تفقدها الآن!",
                    'icon' => 'bi-briefcase', 
                    'color' => 'black' 
                ];
            }

        } catch (PDOException $e) {
            
            error_log($e->getMessage());
        }

        
        require_once VIEW_PATH . '/student/student_notifications.php';
    }
}