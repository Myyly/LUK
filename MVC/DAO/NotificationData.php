<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/NotificationModal.php';
class NotificationData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    
    public function getNotifications($id_user) 
{
    try {
        $query = "
            SELECT * 
            FROM Notifications 
            WHERE id_user = ? 
            ORDER BY created_at DESC"; // Sắp xếp theo thời gian tạo giảm dần

        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notification = new NotificationModal(
                $row['id_notification'],
                $row['id_user'],
                $row['type'],
                $row['content'],
                $row['is_read'],
                $row['created_at'],
                $row['post_id']
            );
            $notifications[] = $notification;
        }
        $stmt->close();
        return $notifications;
    } catch (Exception $e) {
        error_log("Error fetching notifications: " . $e->getMessage());
        return []; 
    }
}
public function addNotification($id_user, $type, $content, $post_id)
{
    try {
        $query = "
            INSERT INTO Notifications (id_user, type, content, is_read, created_at, post_id) 
            VALUES (?, ?, ?, 0, NOW(), ?)";

        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->bind_param("issi", $id_user, $type, $content, $post_id);

        if ($stmt->execute()) {
            $stmt->close();
            return true; 
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        error_log("Error adding notification: " . $e->getMessage());
        return false; 
    }
}
public function getNotificationByPostAndUser($id_user, $post_id, $type)
{
    try {
        $query = "
            SELECT id_notification 
            FROM Notifications 
            WHERE id_user = ? AND post_id = ? AND type = ? 
            LIMIT 1";

        $stmt = $this->conn->getConnection()->prepare($query);
        $stmt->bind_param("iis", $id_user, $post_id, $type);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['id_notification']; // Trả về ID thông báo
        } else {
            return null; // Không tìm thấy
        }
    } catch (Exception $e) {
        error_log("Error fetching notification: " . $e->getMessage());
        return null;
    }
}
public function deleteNotification($id_notification)
{
    try {
        $query = "DELETE FROM Notifications WHERE id_notification = ?";

        $stmt = $this->conn->getConnection()->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }

        $stmt->bind_param("i", $id_notification);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Thành công
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        error_log("Error deleting notification: " . $e->getMessage());
        return false; // Thất bại
    }
}
}