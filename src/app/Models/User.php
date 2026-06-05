<?php

class User {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function findByEmail($email) {
        $query = "SELECT userID, fullName, email, password, role FROM Users WHERE email = :email LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists($email) {
        $query = "SELECT userID FROM Users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    public function registerUser($data) {
        try {
            $this->db->beginTransaction();

            $supervisionType = $data['supervision_type'] ?? '';

            $roleMapping = [
                'student'             => 'طالب',
                'academic_supervisor' => ($supervisionType === 'volunteering' ? 'مشرف تطوع' : 'مشرف تدريب'),
                'external_entity'     => 'جهة خارجية',
                'college_admin'       => 'إدارة كلية' 
            ];

            $dbRole = $roleMapping[$data['role']] ?? $data['role'];

            $query = "INSERT INTO Users (userID, fullName, email, password, phoneNumber, role) 
                      VALUES (:userID, :fullName, :email, :password, :phoneNumber, :role)";
            
            $stmt = $this->db->prepare($query);

            $generatedID = rand(100000, 999999); 
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            $stmt->bindParam(':userID', $generatedID, PDO::PARAM_INT);
            $stmt->bindParam(':fullName', $data['fullname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':phoneNumber', $data['phoneNumber']);
            $stmt->bindParam(':role', $dbRole);
            
            if (!$stmt->execute()) {
                $this->db->rollBack();
                return false;
            }

            switch ($data['role']) {
                case 'student':
                    $queryStudent = "INSERT INTO Student (studentID, majorName, academicYear) 
                                     VALUES (:studentID, :majorName, :academicYear)";
                    $stmtStudent = $this->db->prepare($queryStudent);
                    $stmtStudent->bindParam(':studentID', $generatedID, PDO::PARAM_INT);
                    $stmtStudent->bindParam(':majorName', $data['majorName']);
                    $stmtStudent->bindParam(':academicYear', $data['academicYear'], PDO::PARAM_INT);
                    $stmtStudent->execute();
                    break;

                case 'academic_supervisor':
                    $supType = ($supervisionType === 'volunteering') ? 'تطوع' : 'تدريب';

                    $querySup = "INSERT INTO AcademicSupervisor (supervisorID, supervisorType, departmentName) 
                                 VALUES (:supervisorID, :supervisorType, :departmentName)";
                    $stmtSup = $this->db->prepare($querySup);
                    $stmtSup->bindParam(':supervisorID', $generatedID, PDO::PARAM_INT);
                    $stmtSup->bindParam(':supervisorType', $supType);
                    $stmtSup->bindParam(':departmentName', $data['departmentName']);
                    $stmtSup->execute();
                    break;

                case 'external_entity':
                    $queryEntity = "INSERT INTO ExternalEntity (entityID, entityName, location, employeeName, employeeEmail) 
                                    VALUES (:entityID, :entityName, :location, :employeeName, :employeeEmail)";
                    $stmtEntity = $this->db->prepare($queryEntity);
                    $stmtEntity->bindParam(':entityID', $generatedID, PDO::PARAM_INT);
                    $stmtEntity->bindParam(':entityName', $data['entityName']);
                    $stmtEntity->bindParam(':location', $data['location']);
                    $stmtEntity->bindParam(':employeeName', $data['employeeName']);
                    $stmtEntity->bindParam(':employeeEmail', $data['employeeEmail']);
                    $stmtEntity->execute();
                    break;

                case 'college_admin':
                    break;
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}