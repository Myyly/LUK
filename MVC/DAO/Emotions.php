<?php
require_once __DIR__ . '/../DAO/Database.php';
require_once __DIR__ . '/../Modals/EmotionsModal.php';
class EmotionsData extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function getAllEmotions()
    {
        $query = "SELECT * FROM Emotions";
        $stmt = $this->conn->getConnection()->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $emotions = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $emotion = new EmotionsModal(
                    $row['id'],
                    $row['name'],
                    $row['image']
                );
                $emotions[] = $emotion;
            }
        }
        $stmt->close();
        return $emotions;
    }
    public function getEmotionById($id)
    {
        $query = "SELECT * FROM Emotions WHERE id = ?";
        $stmt = $this->conn->getConnection()->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->getConnection()->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $emotion = new EmotionsModal(
                $row['id'],
                $row['name'],
                $row['image']
            );
            $stmt->close();
            return $emotion;
        } else {
            $stmt->close();
            return null;
        }
    }
}
