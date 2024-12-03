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
        $allUsers = $accountController->searchAllUsersByKeyword($keyword);
        $allUsers = array_filter($allUsers, function ($user) use ($idUser) {
            return $user['user_id'] != $idUser;
        });
        $friends = $accountController->searchFriendsByKeyword($idUser, $keyword);
        $friends = array_filter($friends, function ($friend) use ($idUser) {
            return $friend['user_id'] != $idUser;
        });
        // Lọc ra danh sách người dùng không có trong danh sách bạn bè
        $otherUsers = array_udiff($allUsers, $friends, function ($a, $b) {
            return $a['user_id'] <=> $b['user_id'];
        });
        $finalUsers = array_merge($friends, $otherUsers);
        }
    $result = [];
    foreach ($finalUsers as $user) {
    
            $profilePicture = $user['profile_picture_url']; // Đây là dữ liệu hình ảnh BLOB
            $profilePictureBase64 = $profilePicture ? base64_encode($profilePicture) : null;
            
            $result[] = [
                'user_id' => $user['user_id'],
                'full_name' => htmlspecialchars($user['full_name']),
                'profile_picture_url' => $profilePictureBase64,  // Mã hóa base64 và trả về
            ];
    
        
    }
    header('Content-Type: application/json');
    echo json_encode($result);
}


?>


