<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$idUser = $_SESSION['idUser'];
// require_once('MVC/Controllers/EmotionController.php');
// require_once 'MVC/Controllers/AccountController.php';
// require_once 'MVC/Process/time_process.php';
require_once '../../Controllers/EmotionController.php';
require_once '../../Controllers/AccountController.php';
require_once '../../Process/time_process.php';
$emotionController = new EmotionController();
$accountController = new AccountController();
$emotions = $emotionController->getAllEmotions();
$user = $accountController->findUserbyId($idUser);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/index.css">
    <link rel="stylesheet" href="/assets/CSS/create_post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .container-newsfeed {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .posts {
        width: 80%;
        background-color: #f9f9f9;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .container-create-post {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .main-content {
        background-color: var(--background-page);
    }
</style>
</head>


</body>
<?php include_once '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <!-- <div class="stories">
        <div class="story">Story 1</div>
        <div class="story">Story 2</div>
        <div class="story">Story 3</div>
        <div class="story">Story 4</div>
    </div> -->
    <div class="container-create-post">
        <?php include 'create_post.php'; ?>
    </div>
    <div class="container-newsfeed">
        <div class="posts">
            <?php include 'content_newfeed.php'; ?>
        </div>
    </div>
</div>

</html>