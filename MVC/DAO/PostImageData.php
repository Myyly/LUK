<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/PostImageModal.php';
class PostImageData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function AddPostImage($post_id, $image_data) {
        $query = "INSERT INTO PostImage (post_id, image_data) VALUES (?, ?)";
        $stmt = $this->conn->getConnection()->prepare($query);
    
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $this->conn->getConnection()->error);
        }
    
        $null = null;
        $stmt->bind_param("ib", $post_id, $null);
    
        // Gửi dữ liệu ảnh
        if (!$stmt->send_long_data(1, $image_data)) {
            throw new Exception('Error sending long data.');
        }
    
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
                $image = new PostImageModal(
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
            $postImage = new PostImageModal(
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


    
}