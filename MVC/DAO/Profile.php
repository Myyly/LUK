<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/AccountModal.php';
require_once __DIR__ . '/../Modals/PostsModal.php';
require_once __DIR__ . '/../Modals/PostImagesModal.php';


class ProfileData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    //about
    public function updateUserInfo($userId, $bio, $phoneNumber, $email, $gender, $dateOfBirth)
    {
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
    //post
    public function CreatePost($user_id, $content = null, $created_at = null, $emotion_id = null)
    {
        $query = "INSERT INTO Posts (user_id, content, created_at, emotion_id) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->getConnection()->prepare($query);

        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
        $content = $content ?? '';
        $created_at = $created_at ?? ''; 
        

        if ($emotion_id === '' || $emotion_id === null) {
            $emotion_id = null;
        }
        $stmt->bind_param(
            "isss", 
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
                $post = new PostsModal(
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
    
    public function AddPostImage($post_id, $image_path) {
        $query = "INSERT INTO PostImages (post_id, image_data) VALUES (?, ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
    
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
    
        $stmt->bind_param("is", $post_id, $image_path);
    
        if (!$stmt->execute()) {
            throw new mysqli_sql_exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
    }
    
public function getAllImagesOfPost($post_id){
    $query= "SELECT * FROM PostImage WHERE post_id = ?";
    $stmt = $this->conn->getConnection()->prepare($query);
    if(!$stmt){
        throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
    }
    $stmt->bind_param("i",$post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $image = new PostsImagesModal(
                $row['image_id'],
                $row['post_id'],
                $row['image_data'],
            );
            $images[] = $image;
        }
    }
    $stmt->close();
    return $images;
}
public function getImagesById($image_id)
{
    $query = "SELECT * FROM PostImage WHERE image_id = ?";
    $stmt = $this->conn->getConnection()->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
    }
    
    // Sử dụng $image_id để bind tham số
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Tạo đối tượng PostImage và trả về
        $postImage = new PostsImagesModal(
            $row['image_id'],
            $row['post_id'],
            $row['image_data']
        );

        $stmt->close();
        return $postImage;
    } else {
        $stmt->close();
        return null;
    }
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
        $post = new PostsModal(
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
}
