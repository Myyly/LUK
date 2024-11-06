<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/AccountModal.php';


class ProfileData extends Database {
    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }
    //about
    public function updateUserInfo($userId, $bio, $phoneNumber, $email, $gender, $dateOfBirth) {
        $query = "UPDATE Users SET bio = ?, phone_number = ?, email = ?, gender = ?, date_of_birth = ? WHERE user_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("sssssi", $bio, $phoneNumber, $email, $gender, $dateOfBirth, $userId);
            if ($stmt->execute()) {
            $stmt->close();
            return true; 
        } else {
            $stmt->close();
            return false; 
        }
    }
    
}