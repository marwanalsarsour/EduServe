<?php
require_once __DIR__ . '/../Core/Database.php';

class student_ProfileController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
       
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $studentId = $_SESSION['user_id'];
        $db = (new Database())->getConnection();

      
        $stmt = $db->prepare("SELECT * FROM Students WHERE studentID = :id");
        $stmt->execute(['id' => $studentId]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        
        $certs = $db->prepare("SELECT COUNT(*) FROM Certificates WHERE studentID = :id");
        $certs->execute(['id' => $studentId]);
        $certsCount = $certs->fetchColumn();

        $training = $db->prepare("SELECT COUNT(*) FROM Applications WHERE StudentID = :id AND Status = 'Accepted'");
        $training->execute(['id' => $studentId]);
        $trainingCount = $training->fetchColumn();

        $volunteerCount = 0; // يمكنك إضافة استعلامها لاحقاً

        require_once VIEW_PATH . '/student/student_profile.php';
    }

    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $studentId = $_SESSION['user_id'];
        $db = (new Database())->getConnection();

        $name  = $_POST['fullName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pass  = $_POST['password'];
        $confirmPass = $_POST['confirm_password'];

        
        if (!empty($pass) && $pass !== $confirmPass) {
            $_SESSION['error'] = "كلمات المرور غير متطابقة!";
            header("Location: /student_profile");
            exit();
        }

        try {
            $sql = "UPDATE Students SET fullName = :name, email = :email, phone = :phone";
            $params = [
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
                'id'    => $studentId
            ];

            if (!empty($pass)) {
                $sql .= ", password = :pass";
                $params['pass'] = password_hash($pass, PASSWORD_DEFAULT);
            }

            $sql .= " WHERE studentID = :id";
            $stmt = $db->prepare($sql);
            
            if ($stmt->execute($params)) {
                $_SESSION['msg'] = "تم تحديث البيانات بنجاح";
            } else {
                $_SESSION['error'] = "حدث خطأ أثناء التحديث";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "خطأ في قاعدة البيانات: " . $e->getMessage();
        }

        header("Location: /student_profile");
        exit();
    }
}