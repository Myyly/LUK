<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/CommentModal.php';
class CommentData extends Database
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
        $comment = new CommentModal(
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
public function getAllComments()
{
    try {
        $query = "SELECT * FROM Comments"; // Truy vấn tất cả bình luận
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $comments = []; // Tạo mảng chứa các bình luận

        while ($row = $result->fetch_assoc()) {
            $comment = new CommentModal(
                $row['comment_id'],  // ID của bình luận
                $row['user_cmt_id'], // ID của người dùng đã bình luận
                $row['post_id'],     // ID bài đăng mà bình luận thuộc về
                $row['content'],     // Nội dung của bình luận
            );
            $comments[] = $comment; // Thêm bình luận vào mảng
        }

        $stmt->close();
        return $comments; // Trả về mảng các đối tượng CommentModal
    } catch (Exception $e) {
        error_log("Error fetching all comments: " . $e->getMessage());
        return []; // Trả về mảng rỗng nếu có lỗi
    }
}
}