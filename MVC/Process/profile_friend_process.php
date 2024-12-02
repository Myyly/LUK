<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));

require_once BASE_DIR . '/Controllers/AccountController.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
$user = $accountController->findUserbyId($idUser);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Unfriend"])) {
        $idFriend = $_POST["friend_id"];
        $accountController->unfriend($idUser, $idFriend); 
        $_SESSION['unfriended'] = true; 
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Views/Profile/profile_friend.php?idFriend=' . $idFriend . '";'; 
        echo '}, 300);';
        echo '</script>';
    }
    elseif (isset($_POST["addFriend"])) {
        $accountController->addFriend($idUser, $_POST["friend_id"]); 
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Profile/profile_friend.php?idFriend=' . $_POST["friend_id"] . '";'; 
        echo '}, 300);';
        echo '</script>';
    }
    elseif (isset($_POST["Follow"])) {
        // $idFriend = $_POST["friend_id"];
        $friend_id_be = $_POST["friend_id_be"];
        $accountController->addFriend($idUser, $_POST["friend_id"]); 
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Views/Profile/profile_friend.php?idFriend=' . $friend_id_be . '&sk=friends_all";'; 
        echo '}, 0);';
        echo '</script>';
    }
    elseif (isset($_POST["Unfriend_list"])) {
        $friend_id_be = $_POST["friend_id_be"];
        $accountController->unfriend($idUser, $_POST["friend_id"]); 
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Views/Profile/profile_friend.php?idFriend=' . $friend_id_be  . '&sk=friends_all";'; 
        echo '}, 0);';
        echo '</script>';
    }
    
}
?>