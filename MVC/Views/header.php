<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/AccountController.php';
require_once '../../Controllers/NotificationController.php';
require_once '../../Controllers/PostController.php';
require_once '../../Controllers/LikeController.php';
require_once '../../Controllers/CommentController.php';

$accountController = new AccountController();
$notificationController = new NotificationController();
$likeController = new LikeController();
$commentController = new CommentController();
$idUser = $_SESSION['idUser'];
$notifications = $notificationController->getNotifications($idUser);
$likes = $likeController->getAllLikes();
$comments = $commentController->getAllComments();



// require_once '../../Controllers/AccountController.php';
require_once '../../Controllers/MessageController.php';
// $accountController = new AccountController();
$messageController = new MessageController();

// $idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);
$messages = $messageController->getConversations($idUser);

?>
<link rel="stylesheet" href="/CSS/variables.css">
<link rel="stylesheet" href="/assets/CSS/header.css">

<script src="https://cdn.socket.io/4.5.1/socket.io.min.js"></script>
<script src="/MVC/Views/Profile/notification_event.js"></script>
<div class="header">
    <div class="logo">
        <a href="../Newsfeed/home.php"><img src="/assets/images/LuxLogo.png" alt="Logo"></a>
    </div>
    <?php include 'Profile/search.php'; ?>
    <div class="nav-icons">
        <a href="../Newsfeed/home.php" class="icon"><i class="fas fa-home"></i></a>
        <!-- <a href="#" class="icon"><i class="fas fa-tv"></i></a>
        <a href="#" class="icon"><i class="fas fa-users"></i></a> -->
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
                // echo '<img id="avatar_img" class="avatar" src="' . $avatarSrc . '" alt="">';
            }
            ?>
            <!-- Hiển thị avatar -->
            <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" onclick="toggleDropdown()" style="width:50px; height:50px; border-radius:50%;">
            <div class="dropdown-menu">
                <form action="" method="GET">
                    <ul>
                        <li>
                            <a href="/MVC/Views/Profile/profile.php?id=<?php echo $idUser; ?>"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <!-- <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li> -->
                        <li><a href="/MVC/Views/Account/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </form>
            </div>
        </div>
        <?php include '../Message/chat_menu.php'; ?>
        <?php include '..//Notification/notification.php'; ?>

    </div>
</div>

   
<script>
     let notificationCount = 0;
    // function toggleDropdown() {
    //     const dropdownMenu = document.querySelector('.dropdown-menu');
    //     dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    // }
    // // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.avatar img')) {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    }

    // function toggleChatMenu() {
    //     const chatMenu = document.getElementById("chatMenu");
    //     if (chatMenu.style.display === "block") {
    //         chatMenu.style.display = "none";
    //     } else {
    //         chatMenu.style.display = "block";
    //     }
    //     const notification = document.getElementById("notifications");
    //     notification.style.display = "none";
    // }

    // function toggleNotification() {
    //     const notification = document.getElementById("notifications");
    //     if (notification.style.display === "block") {
    //         notification.style.display = "none";
    //     } else {
    //         notification.style.display = "block";
    //     }
    //     const chatMenu = document.getElementById("chatMenu");
    //     chatMenu.style.display = "none";
    // }
</script>
<script>
    socket.on('notification_update', (data) => {
        const idUser = <?php echo json_encode($idUser); ?>; // Nhúng idUser từ PHP vào JavaScript
       // handleNotification(idUser, data); // Gọi hàm handleNotification từ notification.js
       handleNotificationIfChatVisible(idUser, data);
    });
</script>
<!-- /////////////SEARCH -->
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