<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$idUser = $_SESSION['idUser'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/assets/CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

</head>

  
</body>
<?php include 'index_header.php'; ?>
<div class="sidebar">
        <ul>
            <li><a href="/MVC/Views/Account/profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Bạn bè</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Kỷ niệm</a></li>
            <li><a href="#"><i class="fas fa-save"></i> Đã lưu</a></li>
            <li><a href="#"><i class="fas fa-users-cog"></i> Nhóm</a></li>
            <li><a href="#"><i class="fas fa-video"></i> Video</a></li>
        </ul>
    </div>
    <div class="main-content">
    <div class="stories">
            <div class="story">Story 1</div>
            <div class="story">Story 2</div>
            <div class="story">Story 3</div>
            <div class="story">Story 4</div>
        </div>
        <!-- Posts -->
        <div class="posts">
            <div class="post">
                <h3>SGUni Photography Club</h3>
                <p>SGU tôi yêu 💙🍀</p>
                <img src="image1.jpg" alt="Post image">
            </div>
        </div>
        
    </div>

</html>
