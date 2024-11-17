<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/CommentsModal.php';
class CommentsData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function getAllCommentOfPost($post_id)
{
    $query = "SELECT * FROM Comments WHERE post_id = ?";
    $stmt = $this->conn->getConnection()->prepare($query);

    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
    }
    
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $comments = []; // Tạo mảng để chứa tất cả các bình luận
    
    while ($row = $result->fetch_assoc()) {
        $comment = new CommentsModal(
            $row['comment_id'],
            $row['user_cmt_id'],
            $row['post_id'],
            $row['content']
        );
        
        $comments[] = $comment; // Thêm từng bình luận vào mảng
    }
    
    $stmt->close();
    return $comments; // Trả về mảng các bình luận, nếu không có thì sẽ là mảng rỗng
}
public function addComment( $user_cmt_id, $post_id,$content)
{
    $query = "INSERT INTO Comments (user_cmt_id, post_id, content) 
              VALUES (?, ?, ?)";
    
    $stmt = $this->conn->getConnection()->prepare($query);

    $stmt->bind_param("iis", $user_cmt_id, $post_id, $content); // 'i' for integer, 's' for string
    
    if ($stmt->execute()) {
        return "Comment added successfully!";
    } else {
        return "An error occurred while adding the comment!";
    }
}
public function deleteComment($commentId)
{
    try {
        $query = "DELETE FROM Comments WHERE comment_id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error delete post: " . $e->getMessage());
    }
}
}