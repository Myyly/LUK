<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/PostModal.php';
class PostData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function CreatePost($user_id, $content = null, $created_at = null, $emotion_id = null)
{
    $query = "INSERT INTO Posts (user_id, content, created_at, emotion_id) 
              VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->getConnection()->prepare($query);

    if ($stmt === false) {
        throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
    }

    $content = $content ?? '';
    $created_at = $created_at ?? date('Y-m-d H:i:s'); // Thời gian hiện tại nếu không có
    $emotion_id = $emotion_id ?? null; // Gán null nếu không có

    $stmt->bind_param(
        "issi", // Kiểu INT, STRING, STRING, INT
        $user_id,
        $content,
        $created_at,
        $emotion_id
    );

    if (!$stmt->execute()) {
        throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
    }

    $stmt->close();
    return $this->conn->getConnection()->insert_id;
}

    public function deletePost($postId)
{
    try {
        $query = "DELETE FROM Posts WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error delete post: " . $e->getMessage());
    }
}
    public function getAllPostsOfUser($user_id){
        $query = "SELECT * FROM Posts WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $posts = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new PostModal(
                    $row['post_id'],
                    $row['user_id'],
                    $row['content'],
                    $row['created_at'],
                    $row['emotion_id'],
                    $row['like_count'],
                    $row['comment_count'],
                    $row['share_count']
                );
                $posts[] = $post;
            }
        }
        $stmt->close();
        return $posts;
    }
    public function getPostById($post_id)
    {
        $query = "SELECT * FROM Posts WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        
        // Sử dụng $image_id để bind tham số
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Tạo đối tượng PostImage và trả về
            $post = new PostModal(
                $row['post_id'],
                $row['user_id'],
                $row['content'],
                $row['created_at'],
                $row['emotion_id'],
                $row['like_count'],
                $row['comment_count'],
                $row['share_count'],
            );
            $stmt->close();
            return $post;
        } else {
            $stmt->close();
            return null;
        }
    }
    public function increaseLikeCount($post_id) {
        $query = "UPDATE Posts SET like_count = like_count + 1 WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    
        if ($stmt->affected_rows === 0) {
            throw new Exception("No post found with the specified ID.");
        }
        $stmt->close();
    }
    public function decreaseLikeCount($post_id) {
        $query = "UPDATE Posts SET like_count = like_count - 1 WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    
        if ($stmt->affected_rows === 0) {
            throw new Exception("No post found with the specified ID or the like count is already zero.");
        }
        $stmt->close();
    }
    public function increaseCommentCount($post_id) {
        $query = "UPDATE Posts SET comment_count = comment_count + 1 WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    
        if ($stmt->affected_rows === 0) {
            throw new Exception("No post found with the specified ID.");
        }
        $stmt->close();
    }
    public function decreaseCommentCount($post_id) {
        $query = "UPDATE Posts SET comment_count = comment_count - 1 WHERE post_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    
        if ($stmt->affected_rows === 0) {
            throw new Exception("No post found with the specified ID.");
        }
        $stmt->close();
    }
    
}