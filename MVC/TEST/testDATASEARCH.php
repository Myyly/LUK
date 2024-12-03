<?php 
session_start();
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/AccountController.php';

$idUser = $_SESSION['idUser'] ?? 6; // ID người dùng hiện tại từ session (giá trị mặc định là 6)

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tạo đối tượng AccountController
$accountController = new AccountController();

$keyword = "L";

// Lấy danh sách tất cả người dùng
$allUsers = $accountController->searchAllUsersByKeyword($keyword);

// Lọc bỏ người dùng hiện tại khỏi danh sách tất cả người dùng
$allUsers = array_filter($allUsers, function ($user) use ($idUser) {
    return $user['user_id'] != $idUser;
});

// Lấy danh sách bạn bè
$friends = $accountController->searchFriendsByKeyword($idUser, $keyword);

// Lọc bỏ người dùng hiện tại khỏi danh sách bạn bè
$friends = array_filter($friends, function ($friend) use ($idUser) {
    return $friend['user_id'] != $idUser;
});

// Lọc ra danh sách người dùng không có trong danh sách bạn bè
$otherUsers = array_udiff($allUsers, $friends, function ($a, $b) {
    return $a['user_id'] <=> $b['user_id'];
});

// Kết hợp danh sách bạn bè và người dùng còn lại
$finalUsers = array_merge($friends, $otherUsers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .section-title {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Kết quả tìm kiếm</h1>

    <h2 class="section-title">Danh sách hiển thị (ưu tiên bạn bè trước)</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Profile Picture</th>
            <th>Loại</th>
        </tr>
        <?php foreach ($finalUsers as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['user_id']) ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td>
                <?php if (!empty($user['profile_picture_url'])): ?>
                    <img src="<?= htmlspecialchars($user['profile_picture_url']) ?>" alt="Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td>
                <?= in_array($user, $friends) ? 'Bạn bè' : 'Người dùng khác' ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>