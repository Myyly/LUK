<?php
// Đảm bảo đã include file AccountController hoặc khởi tạo $accountController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/AccountController.php';
require_once BASE_DIR . '/Controllers/FriendController.php';

$accountController = new AccountController();
$friendController = new FriendController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $idUser = $data['idUser'];
    $keyword = $data['keyword'];
    if($keyword != null){
    $friendsList = $friendController->searchFriendsByFullName($idUser, $keyword);
    }
    else {
        $friendsList = $friendController->getFriendsList($idUser);
    }
    $result = [];
    foreach ($friendsList as $friend) {
        $result[] = [
            'friend_id' => $friend['friend_id'],
            'full_name' => htmlspecialchars($friend['full_name']),
            'profile_picture_url' => $friend['profile_picture_url'] ? base64_encode($friend['profile_picture_url']) : null,
            'mutual_friends_count' => $friendController->getMutualFriendsCount($idUser, $friend['friend_id']),
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($result);
}


?>


