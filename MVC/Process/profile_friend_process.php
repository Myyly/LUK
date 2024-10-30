<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/Account.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';

$user = $accountController->findUserbyId($idUser);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Unfriend"])) {}
        $accountController->unfriend($idUser, $_POST["friend_id"]); 
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Views/Account/profile_friend.php?idFriend=' . $_POST["friend_id"] . '";'; // Sửa lỗi ở đây
        echo '}, 300);';
        echo '</script>';
    }
