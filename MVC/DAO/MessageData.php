<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/MessageModal.php';
class MessageData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function getConversations($user_id)
    {
        try {
            // Truy vấn lấy danh sách cuộc hội thoại duy nhất giữa người dùng và các người dùng khác
            $query = "
                SELECT
                    LEAST(sender_id, receiver_id) AS participant_1,
                    GREATEST(sender_id, receiver_id) AS participant_2,
                    MAX(sent_at) AS last_sent_at
                FROM Messages
                WHERE sender_id = ? OR receiver_id = ?
                GROUP BY participant_1, participant_2
                ORDER BY last_sent_at DESC
            ";
    
            $stmt = $this->conn->getConnection()->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
            }
    
            // Gắn tham số vào câu truy vấn
            $stmt->bind_param("ii", $user_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Tạo một mảng các đối tượng MessageModal từ kết quả truy vấn
            $conversations = [];
            while ($row = $result->fetch_assoc()) {
                // Lấy thông tin người tham gia
                $sender_id = $row['participant_1'];
                $receiver_id = $row['participant_2'];
    
                // Lấy thông tin tin nhắn mới nhất từ các cặp người tham gia
                $messageQuery = "
                    SELECT * FROM Messages
                    WHERE (sender_id = ? AND receiver_id = ?) 
                       OR (sender_id = ? AND receiver_id = ?)
                    ORDER BY sent_at DESC LIMIT 1
                ";
    
                $messageStmt = $this->conn->getConnection()->prepare($messageQuery);
                $messageStmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
                $messageStmt->execute();
                $messageResult = $messageStmt->get_result();
    
                if ($messageRow = $messageResult->fetch_assoc()) {
                    // Tạo một đối tượng MessageModal cho tin nhắn mới nhất
                    $message = new MessageModal(
                        $messageRow['message_id'],
                        $messageRow['sender_id'],
                        $messageRow['receiver_id'],
                        $messageRow['message_content'],
                        $messageRow['sent_at']
                    );
                    $conversations[] = $message; // Thêm vào mảng các cuộc hội thoại
                }
    
                $messageStmt->close();
            }
    
            // Đóng kết nối statement và trả về mảng các cuộc hội thoại
            $stmt->close();
            return $conversations;
        } catch (Exception $e) {
            // Ghi lại lỗi vào log và trả về mảng rỗng nếu có lỗi
            error_log("Error fetching conversations: " . $e->getMessage());
            return []; // Hoặc có thể trả về false tùy theo cách bạn muốn xử lý lỗi
        }
    }
public function getChatDetails($user_id, $other_user_id)
{
    try {
        $query = "
            SELECT * 
            FROM Messages 
            WHERE (sender_id = ? AND receiver_id = ?) 
               OR (sender_id = ? AND receiver_id = ?) 
            ORDER BY sent_at ASC"; // Sắp xếp theo thời gian gửi tin nhắn
        
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        // Gắn tham số vào câu truy vấn
        $stmt->bind_param("iiii", $user_id, $other_user_id, $other_user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Tạo một mảng các đối tượng MessageModal từ kết quả truy vấn
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $message = new MessageModal(
                $row['message_id'],
                $row['sender_id'],
                $row['receiver_id'],
                $row['message_content'],
                $row['sent_at']
            );
            $messages[] = $message;
        }

        // Đóng kết nối statement và trả về mảng tin nhắn
        $stmt->close();
        return $messages;
    } catch (Exception $e) {
        // Ghi lại lỗi vào log và trả về mảng rỗng nếu có lỗi
        error_log("Error fetching chat details: " . $e->getMessage());
        return []; // Hoặc có thể trả về false tùy theo cách bạn muốn xử lý lỗi
    }
}
public function addMessage($sender_id, $receiver_id, $message_content)
{
    try {
        $query = "
            INSERT INTO Messages (sender_id, receiver_id, message_content, sent_at) 
            VALUES (?, ?, ?, NOW())
        ";
        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message_content);
        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("Failed to insert message: " . $stmt->error);
        }

        $stmt->close();
        return true;
    } catch (Exception $e) {
        error_log("Error adding message: " . $e->getMessage());
        return false;
    }
}

    
}