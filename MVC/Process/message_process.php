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
    $data = json_decode(file_get_contents(filename: "php://input"), true);
    // Kiểm tra nếu dữ liệu có đầy đủ các trường cần thiết
    if (isset($data['idUser_chat'])) {
        $idUserChat = $data['idUser_chat'];
        $messages = $messageController->getChatDetails($idUser, $idUserChat);
        if ($messages) {
            $response = [];
            foreach ($messages as $message) {
                $avatarUrl = $accountController->findUserbyId(id: $message->getSender_id())->getProfile_picture_url();
                if ($message->getSender_id() != $_SESSION['idUser']) {
                    // Check if the user has an avatar, if not set a default one
                    if ($avatarUrl) {
                        // If avatar exists, encode it in base64
                        $base64Image = base64_encode($avatarUrl);
                        $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                    } else {
                        // Default avatar URL if no avatar is found
                        $avatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
                    }
                } else {
                    $avatarSrc = "";
                }
                $response[] = [
                    'sender_id' => $message->getSender_id(),
                    'message_content' => $message->getMessage_content(),
                    'sent_at' => $message->getSent_at(),
                    'avatar_user_chat' => $avatarSrc
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo json_encode([]);
        }
    } elseif (isset($data['sender_id'], $data['receiver_id'], $data['message_content'])) {
        $sender_id = $data['sender_id'];
        $receiver_id = $data['receiver_id'];
        $message_content = $data['message_content'];
        try {
            $result = $messageController->addMessage($sender_id, $receiver_id, $message_content);
            if ($result) {
                $response = [
                    'status' => 'success',
                    'message' => 'Tin nhắn đã được gửi.',
                    'data' => [
                        'sender_id' => $sender_id,
                        'receiver_id' => $receiver_id,
                        'message_content' => $message_content,
                        'sent_at' => date('Y-m-d H:i:s'),
                    ],
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra khi gửi tin nhắn.',
                ];
            }
        } catch (Exception $e) {
            error_log("Error processing message: " . $e->getMessage());
            $response = [
                'status' => 'error',
                'message' => 'Có lỗi khi xử lý tin nhắn.',
            ];
        }
        echo json_encode($response);
    } else if (isset($data['sender_id'], $data['receiver_id'])) {
        $senderId = $data['sender_id'];
        $receiverId = $data['receiver_id'];
        $arr_check = $messageController->getChatDetails($senderId, $receiverId);
        if ($receiverId == $idUser) {
           $userInfo  = $accountController->findUserbyId($senderId );
        } else if ($senderId == $idUser) {
            $userInfo  = $accountController->findUserbyId($receiverId);
        }
      //  $userInfo = $accountController->findUserbyId($sender_id);
        $id = $userInfo->getUser_id();
        $name_user = $userInfo->getFull_name();
        $avatar_user = $userInfo->getProfile_picture_url();
        $AvatarSrc = $avatar_user
            ? 'data:image/jpeg;base64,' . base64_encode($avatar_user)
            : "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
    
            $response = [
                'success' => true,
                'fullName' => $name_user,
                'id' => $id,
                'profilePicture' => $AvatarSrc,
                'chatDetails' => $arr_check,
                'lastMessage' => !empty($arr_check) ? end($arr_check)->getMessage_content() : ''
            ];
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
}
