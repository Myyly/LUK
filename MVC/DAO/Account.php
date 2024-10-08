<?php
require_once __DIR__ . '/../DAO/Database.php';

class AccountData extends Database {
    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }
    public function SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status) {
        if ($email === NULL && $phone_number === NULL) {
            throw new InvalidArgumentException('Both email and phone number cannot be NULL');
        }
        if ($password_hash === NULL || $full_name === NULL || $date_of_birth === NULL || $gender === NULL || $status === NULL) {
            throw new InvalidArgumentException('One or more required parameters are NULL');
        }
    
        $query = "INSERT INTO Users (email, phone_number, password_hash, full_name, date_of_birth, gender, profile_picture_url, bio, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
    
        if (!$stmt->bind_param("sssssssss", $email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status)) {
            throw new Exception('Binding parameters failed: ' . $stmt->error);
        }
    
        if ($stmt->execute() === false) {
            throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
        return $this->conn->getConnection()->insert_id;
    }
    public function checkEmailExist($email){
        $query = "SELECT COUNT(*) as count FROM Users WHERE email = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if($stmt){
            $stmt -> bind_param("s",$email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result ->fetch_assoc();
            $count = $row['count'];
            if($count > 0){
                return true;
            }else {
                return false;
            }
        }else{
            return false;
        }
    }
}
?>