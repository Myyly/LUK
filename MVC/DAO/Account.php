<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/AccountModal.php';


class AccountData extends Database {
    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }
    public function SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url) {
        if ($email === NULL && $phone_number === NULL) {
            throw new InvalidArgumentException('Both email and phone number cannot be NULL');
        }
        if ($password_hash === NULL || $full_name === NULL || $date_of_birth === NULL || $gender === NULL || $status === NULL) {
            throw new InvalidArgumentException('One or more required parameters are NULL');
        }
    
        $query = "INSERT INTO Users (email, phone_number, password_hash, full_name, date_of_birth, gender, profile_picture_url, bio, status,cover_photo_url) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
    
        if (!$stmt->bind_param("ssssssssss", $email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url)) {
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
    public function LoginByEmail($email){
        $query = "SELECT * FROM Users WHERE email = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if(!$stmt){
            throw new Exception("Prepare statment failed: " .$this -> conn->getConnection()->error);
        }
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >0){
            $row = $result->fetch_assoc();
            $user = new AccountModal(
                $row['user_id'],
                $row['email'],
                $row['phone_number'],
                $row['password_hash'],
                $row['full_name'],
                $row['profile_picture_url'],
                $row['bio'],
                $row['date_of_birth'],
                $row['gender'],
                $row['created_at'],
                $row['updated_at'],
                $row['last_active'],
                $row['status'],
                $row['cover_photo_url']
            );
            $stmt->close();
            return $user;
        }else {
            $stmt ->close();
            return null;
        }
    }
    public function LoginByPhoneNumber($phone_number){
        $query = "SELECT * FROM Users WHERE phone_number = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if(!$stmt){
            throw new Exception("Prepare statment failed: " .$this -> conn->getConnection()->error);
        }
        $stmt->bind_param("s",$phone_number);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >0){
            $row = $result->fetch_assoc();
            $user = new AccountModal(
                $row['user_id'],
                $row['email'],
                $row['phone_number'],
                $row['password_hash'],
                $row['full_name'],
                $row['profile_picture_url'],
                $row['bio'],
                $row['date_of_birth'],
                $row['gender'],
                $row['created_at'],
                $row['updated_at'],
                $row['last_active'],
                $row['status'],
                $row['cover_photo_url']

            );
            $stmt->close();
            return $user;
        }else {
            $stmt ->close();
            return null;
        }
    }
    public function resetPassword($email,$newpass){
        $password_hash = password_hash($newpass, PASSWORD_BCRYPT);
        $query = "UPDATE Users SET password_hash = ? WHERE email = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if(!$stmt){
            throw new Exception("Prepare statement failed: ".$this->conn->getConnection()->error);
        }
        $stmt->bind_param("ss",$password_hash,$email);
        if($stmt->execute()==false){
            throw new Exception("Excute failed: ".$stmt->error);
        }
        $stmt->close();
        return true;

    } public function findUserbyId($id){
        $query = "SELECT * FROM Users WHERE user_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if(!$stmt){
            throw new Exception("Prepare statment failed: " .$this -> conn->getConnection()->error);
        }
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >0){
            $row = $result->fetch_assoc();
            $user = new AccountModal(
                $row['user_id'],
                $row['email'],
                $row['phone_number'],
                $row['password_hash'],
                $row['full_name'],
                $row['profile_picture_url'],
                $row['bio'],
                $row['date_of_birth'],
                $row['gender'],
                $row['created_at'],
                $row['updated_at'],
                $row['last_active'],
                $row['status'],
                $row['cover_photo_url']

            );
            $stmt->close();
            return $user;
        }else {
            $stmt ->close();
            return null;
        }
    }
    public function updateAvatar($id, $imageData) {
        $stmt = $this->conn->getConnection()->prepare("UPDATE Users SET profile_picture_url = ? WHERE user_id = ?");
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("bi", $imageData, $id);
        $stmt->send_long_data(0, $imageData);
    
        if ($stmt->execute() === false) {
            throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
        return true;
    }
    public function updateCover($id, $imageData) {
        $stmt = $this->conn->getConnection()->prepare("UPDATE Users SET cover_photo_url = ? WHERE user_id = ?");
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
        // Sử dụng kiểu dữ liệu đúng
        $stmt->bind_param("bi", $imageData, $id);
        $stmt->send_long_data(0, $imageData);
    
        if ($stmt->execute() === false) {
            throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
        return true;
    }
    public function updateUserProfile($id, $profile_picture_url, $cover_photo_url, $bio) {
        $query = "UPDATE Users SET profile_picture_url = ?, cover_photo_url = ?, bio = ? WHERE user_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("sssi", $profile_picture_url, $cover_photo_url, $bio, $id);
        $success = $stmt->execute();
        if (!$success) {
            throw new Exception("Update failed: " . $stmt->error);
        }
        $stmt->close();
        return $success;
    }
    public function getTotalFriends($userId) {
        $query = "SELECT COUNT(*) AS total_friends 
                  FROM Friends 
                  WHERE (user_id = ? OR friend_id = ?) 
                  AND status = 'accepted'";
        
        $stmt = $this->conn->getConnection()->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("ii", $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total_friends'];
    }
}
?>