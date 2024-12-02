<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));

// require_once BASE_DIR . '/Controllers/AccountController.php';
// $accountController = new AccountController();
// $idUser = $_SESSION['idUser'];
// $idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
// $user = $accountController->findUserbyId($idUser);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnClosePost"])) {
        echo '<script>';
        echo '    window.location.href = "/index.php";'; 
        echo '</script>';
        }
        }