<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// require_once '../../Controllers/Account.php';
require_once 'MVC/Controllers/AccountController.php';
require_once 'MVC/Controllers/MessageController.php';
require_once 'MVC/Controllers/NotificationController.php';
require_once 'MVC/Controllers/PostController.php';
require_once 'MVC/Controllers/LikeController.php';
require_once 'MVC/Controllers/CommentController.php';


$messageController = new MessageController();
$accountController = new AccountController();
$notificationController = new NotificationController();
$likeController = new LikeController();
$commentController = new CommentController();

$idUser = $_SESSION['idUser'];

$notifications = $notificationController->getNotifications($idUser);
$likes = $likeController->getAllLikes();
$comments = $commentController->getAllComments();
$messages = $messageController->getConversations($idUser);
$user = $accountController->findUserbyId($idUser);
?>
<link rel="stylesheet" href="/CSS/variables.css">
<div class="header">
    <div class="logo">
        <a href="index.php"><img src="/assets/images/LuxLogo.png" alt="Logo"></a>
    </div>
    <?php include 'MVC/Views/Profile/search.php' ?>
    <div class="nav-icons">
    <a href="/index.php" class="icon"><i class="fas fa-home"></i></a>
        <!-- <a href="#" class="icon"><i class="fas fa-tv"></i></a> -->
        <!-- <a href="#" class="icon"><i class="fas fa-users"></i></a> -->
        <a href="#" class="icon" onclick="toggleChatMenu()">
            <i class="fa-solid fa-comment-dots"></i>
            <span id="notificationCount" class="notification-count">0</span>
        </a>
        <a href="#" class="icon" onclick="toggleNotification()">
            <i class="fas fa-bell"></i>
            <span id="bellNotificationCount" class="notification-count">0</span> <!-- Số lượng thông báo -->
        </a>
        <div class="avatar">
            <?php
            $img = $user->getProfile_picture_url();
            if ($img) {
                $base64Image = base64_encode($img);
                $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                //  echo '<img id="avatar_img" class="avatar" src="' . $avatarSrc . '" alt="">';
            }
            ?>
            <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" onclick="toggleDropdown()" style="width:50px; height:50px; border-radius:50%;">
            <div class="dropdown-menu">
                <form action="" method="GET">
                    <ul>
                        <li>
                            <a href="./MVC/Views/Profile/profile.php?id=<?php echo $idUser; ?>"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <!-- <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li> -->
                        <li><a href="/MVC/Views/Account/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </form>
            </div>
        </div>
        <?php include 'MVC/Views/Message/chat_menu.php';?>
        <?php include 'MVC/Views/Notification/notification.php'; ?>
    </div>
</div>
<link rel="stylesheet" href="/assets/CSS/header.css">
<script src="/MVC/Views/Profile/notification_event.js"></script>

<script>
     let notificationCount = 0;
    window.onclick = function(event) {
        if (!event.target.matches('.avatar img')) {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    }
    

</script>
<script>
    let notificationCountnBell = 0;
    socket.on('receive_like', (data) => {
        const idUser = <?php echo json_encode($idUser); ?>;
        const normalizedidUser = String(idUser).trim(); 
        if(String(data.id_user).trim() != normalizedidUser){
        notificationCountnBell++;
        document.getElementById('bellNotificationCount').textContent = notificationCountnBell;
        }
    });
    socket.on('receive_comment', (data) => {
        const idUser = <?php echo json_encode($idUser); ?>;
        const normalizedidUser = String(idUser).trim(); 
        if(String(data.id_user).trim() != normalizedidUser){
         notificationCountnBell++;
        document.getElementById('bellNotificationCount').textContent = notificationCountnBell;
        }
    });
    socket.on('receive_unlike', (data) => {
        const idUser = <?php echo json_encode($idUser); ?>;
        const normalizedidUser = String(idUser).trim(); 
        if(String(data.id_user).trim() != normalizedidUser){
        if (notificationCountnBell > 0) {
            notificationCountnBell--;
        } else notificationCountnBell = 0;
        document.getElementById('bellNotificationCount').textContent = notificationCountnBell;
        }
    });
    // function clickNotification(){
    //     if (notificationCountnBell > 0) {
    //         notificationCountnBell--;
    //     } else notificationCountnBell = 0;
    //     document.getElementById('bellNotificationCount').textContent = notificationCountnBell;
      //  }
//     socket.on('receive_message', (data) => {
//     // Chỉ tăng thông báo nếu người gửi chưa trong danh sách
//     if (!unreadUsers.has(data.sender_id)) {
//         unreadUsers.add(data.sender_id);
//         notificationCount++;
//         document.getElementById('notificationCount').textContent = notificationCount;
//     }
// });
</script>