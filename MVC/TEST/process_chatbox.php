<?php
session_start();
define('BASE_DIR', dirname(__DIR__));

require_once BASE_DIR . '/Controllers/MessageController.php';
require_once BASE_DIR . '/Controllers/AccountController.php';

$idUser = $_SESSION['idUser'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$accountController = new AccountController();
$messageController = new MessageController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $idUserChat = $data['idUser_chat'];
    $messages = $messageController->getChatDetails($idUser , $idUserChat); // Lấy tin nhắn

    if ($messages) {
        $response = [];
        foreach ($messages as $message) {
            $avatarUrl = $accountController->findUserbyId(id: $message->getSender_id())->getProfile_picture_url();
            if ($message->getSender_id() != $_SESSION['idUser']){
            // Check if the user has an avatar, if not set a default one
            if ($avatarUrl) {
                // If avatar exists, encode it in base64
                $base64Image = base64_encode($avatarUrl);
                $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
            } else {
                // Default avatar URL if no avatar is found
                $avatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
            }
        }else {
            $avatarSrc = "";
        }

            $response[] = [
                'sender_id' => $message->getSender_id(),
                'message_content' => $message->getMessage_content(),
                'sent_at' => $message->getSent_at(),
                'avatar_user_chat' => $avatarSrc // Use base64-encoded image or fallback URL
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response); 
    } else {
        echo json_encode([]);
    }
}

