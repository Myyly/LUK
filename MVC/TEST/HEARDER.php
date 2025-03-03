<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/AccountController.php';
require_once '../../Controllers/MessageController.php';
$accountController = new AccountController();
$messageController = new MessageController();

$idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);
$messages = $messageController->getConversations($idUser);

?>
<link rel="stylesheet" href="/CSS/variables.css">
<script src="https://cdn.socket.io/4.5.1/socket.io.min.js"></script>
<script src="/MVC/Views/Profile/notification_event.js"></script>
<div class="header">
    <div class="logo">
        <a href="/index.php"><img src="/assets/images/LuxLogo.png" alt="Logo"></a>
    </div>
    <div class="search">
        <input type="text" placeholder="Tìm kiếm trên Luk">
        <i class="fas fa-search"></i>
    </div>
    <div class="nav-icons">
        <a href="/index.php" class="icon"><i class="fas fa-home"></i></a>
        <a href="#" class="icon"><i class="fas fa-tv"></i></a>
        <a href="#" class="icon"><i class="fas fa-users"></i></a>
        <a href="#" class="icon" onclick="toggleChatMenu()">
            <i class="fa-solid fa-comment-dots"></i>
            <span id="notificationCount" class="notification-count">0</span>
        </a>
        <a href="#" class="icon">
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
                            <a href="profile.php?id=<?php echo $idUser; ?>"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li>
                        <li><a href="/MVC/Views/Account/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </form>
            </div>
        </div>
        <?php include '../Message/chat_menu.php'; ?>
    </div>
</div>
<style>
    /* Header container */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header input[type="text"] {
        width: 100%;
        padding: 8px 20px;
        border: 1px solid #ccc;
        border-radius: 20px;
        background-color: #f0f2f5;
    }

    .header .search {
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .header .search input[type="text"] {
        width: 350px;
        padding: 10px 40px 10px 20px;
        font-size: 16px;
        border-radius: 20px;
        border: 1px solid #ccc;
        outline: none;
        background-color: #f0f2f5;
    }

    .header .search i {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        color: #606770;
    }

    .header a img {
        width: 40px;
        height: 40px;
        margin-right: 15px;

    }

    .nav-icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .nav-icons .icon {
        font-size: 22px;
        color: #606770;
        text-decoration: none;
        padding: 10px;
    }

    .nav-icons .icon:hover {
        background-color: var(--nav-icons-hover-background);
        border-radius: 50%;
        color: var(--link-hover-color);
        padding: 10px;
    }

    .nav-icons .avatar {
        display: flex;
        align-items: center;
        margin-left: 15px;
    }

    .nav-icons .avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .nav-icons .avatar span {
        font-size: 16px;
        color: #333;
    }

    .avatar {
        position: relative;
    }

    .avatar img {
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background-color: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 200px;
        z-index: 1;
    }

    .dropdown-menu ul {
        list-style-type: none;
        padding: 10px;
        margin: 0;
    }

    .dropdown-menu ul li {
        padding: 10px 0;
    }

    .dropdown-menu ul li a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
    }

    .dropdown-menu ul li a i {
        margin-right: 10px;
    }

    .dropdown-menu ul li:hover {
        background-color: #f0f2f5;
        border-radius: 8px;
    }

    .notification-count {
        position: absolute;
        top: 5px;
        right: 145px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 3px 8px;
        font-size: 11px;
    }
    /* Thông báo chuông */
#bellNotificationCount {
    position: absolute;
    top: 5px;
    right: 90px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 3px 8px;
    font-size: 11px;
    display: block; /* Ẩn thông báo mặc định */
}
</style>
<script>
    // const socket = io('http://localhost:4000');
    let notificationCount = 0;
    function toggleDropdown() {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }
    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.avatar img')) {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    }
    function toggleChatMenu() {
        
        if(notificationCount > 0){
            notificationCount--;
            document.getElementById('notificationCount').textContent = notificationCount;
        }
        const chatMenu = document.getElementById("chatMenu");
        if (chatMenu.style.display === "block") {
            chatMenu.style.display = "none";
        } else {
            chatMenu.style.display = "block";
        }
    }

</script>
<script>
        socket.on('notification_update', (data) => {
            const idUser = <?php echo json_encode($idUser); ?>; // Nhúng idUser từ PHP vào JavaScript
            handleNotification(idUser, data); // Gọi hàm handleNotification từ notification.js
        });
    </script>
