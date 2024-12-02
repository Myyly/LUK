<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/FriendModal.php';
class FriendData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
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
    public function getFriendsList($userId) {
        $query = "
            SELECT 
                CASE 
                    WHEN f.user_id = ? THEN f.friend_id 
                    ELSE f.user_id 
                END AS friend_id, 
                u.full_name, 
                u.profile_picture_url 
            FROM Friends f 
            JOIN Users u ON (
                (f.friend_id = u.user_id AND f.user_id = ?) OR 
                (f.user_id = u.user_id AND f.friend_id = ?)
            )
            WHERE f.status = 'accepted'
        ";
    
        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bind_param("iii", $userId, $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $friends = [];
        while ($row = $result->fetch_assoc()) {
            $friends[] = $row;
        }
        
        return $friends;
    }
    public function unfriend($userId, $friendId) {
        $query = "DELETE FROM Friends WHERE user_id = ? AND friend_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bind_param("ii", $userId, $friendId);
        $stmt->execute();
        $stmt->close();
    }
    public function getMutualFriendsCount($userId1, $userId2) {
        $query = "
            SELECT COUNT(*) AS mutual_friends_count 
            FROM Friends AS f1 
            JOIN Friends AS f2 ON f1.friend_id = f2.friend_id
            WHERE f1.user_id = ? AND f2.user_id = ? AND f1.status = 'accepted' AND f2.status = 'accepted'
        ";
    
        $stmt = $this->conn->getConnection()->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
    
        $stmt->bind_param("ii", $userId1, $userId2);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row['mutual_friends_count'];
            $stmt->close();
            return $count;
        } else {
            $stmt->close();
            return 0; 
        }
    }
    public function checkFriendshipStatus($userId1, $userId2) {
        $query = "SELECT status FROM Friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        
        $stmt->bind_param("iiii", $userId1, $userId2, $userId2, $userId1);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['status']; 
        } else {
            return null; 
        }
    }
    public function acceptFriendRequest($userId, $friendId) {
        $query = "UPDATE Friends SET status = 'accepted' WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("iiii", $userId, $friendId, $friendId, $userId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        return true; 
    }
    public function addFriend($userId, $friendId) {
        $requestedAt = date('Y-m-d H:i:s');
        $query = "INSERT INTO Friends (user_id, friend_id, status, requested_at) VALUES (?, ?, 'accepted', ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("iis", $userId, $friendId, $requestedAt);
        if (!$stmt->execute()) {
            throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
        return true; 
    }
    public function searchFriendsByFullName($idUser, $fullName) {
        // Chuẩn bị câu truy vấn
        $query = "SELECT u.user_id AS friend_id, u.full_name, u.profile_picture_url 
                  FROM Users u
                  INNER JOIN Friends f ON (u.user_id = f.friend_id OR u.user_id = f.user_id)
                  WHERE (f.user_id = ? OR f.friend_id = ?) 
                  AND u.full_name LIKE ? 
                  AND u.user_id != ?";
        // Chuẩn bị câu lệnh truy vấn
        $stmt = $this->conn->getConnection()->prepare($query);
    
        // Kiểm tra lỗi khi chuẩn bị câu truy vấn
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị câu truy vấn: " . $this->conn->getConnection()->error);
        }
    
        // Tạo chuỗi tìm kiếm với ký tự wildcard
        $likeFullName = "%" . $fullName . "%";
    
        // Gán giá trị cho các tham số
        $stmt->bind_param("iisi", $idUser, $idUser, $likeFullName, $idUser);
    
        // Thực thi câu truy vấn
        $stmt->execute();
    
        // Lấy kết quả
        $result = $stmt->get_result();
    
        // Tạo danh sách bạn bè từ kết quả truy vấn
        $friends = [];
        while ($row = $result->fetch_assoc()) {
            $friends[] = $row;
        }
    
        // Đóng câu lệnh
        $stmt->close();
    
        return $friends;
    }

    
}