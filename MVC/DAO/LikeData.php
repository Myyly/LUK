<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/LikeModal.php';
class LikeData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function isPostLikedByUser($userId, $postId)
    {
        try {
            $query = "SELECT * FROM Likes WHERE user_like_id = ? AND post_id = ?";
            $stmt = $this->conn->getConnection()->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
            }
    
            $stmt->bind_param("ii", $userId, $postId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $isLiked = $result->num_rows > 0;
    
            $stmt->close();
            return $isLiked; 
        } catch (Exception $e) {
            error_log("Error checking post like status: " . $e->getMessage());
            return false; 
        }
    }
    public function addLike($userId, $postId)
    {
        try {
            $query = "INSERT INTO Likes (user_like_id, post_id) VALUES (?, ?)";
            $stmt = $this->conn->getConnection()->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
            }
    
            $stmt->bind_param("ii", $userId, $postId);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            error_log("Error adding like: " . $e->getMessage());
        }
    }
    public function removeLike($userId, $postId)
{
    try {
        $query = "DELETE FROM Likes WHERE user_like_id = ? AND post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->bind_param("ii", $userId, $postId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error removing like: " . $e->getMessage());
    }
}
public function getAllLikes()
{
    try {
        $query = "SELECT * FROM Likes";
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $likes = [];
        while ($row = $result->fetch_assoc()) {
            $like = new LikeModal(
                $row['like_id'],         // ID của lượt like (nếu có cột này)
                $row['user_like_id'],    // ID người dùng
                $row['post_id'],         // ID bài đăng
            );
            $likes[] = $like;
        }

        $stmt->close();
        return $likes;
    } catch (Exception $e) {
        error_log("Error fetching all likes: " . $e->getMessage());
        return []; // Trả về mảng rỗng nếu có lỗi
    }
}



    
}