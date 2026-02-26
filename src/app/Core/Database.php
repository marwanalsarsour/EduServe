<?php

class Database {
    private $host = "db"; 
    private $dbname = "eduserve_db";
    private $username = "root";
    private $password = "root_password"; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            die("خطأ في الاتصال: " . $exception->getMessage());
        }
        return $this->conn;
    }
}