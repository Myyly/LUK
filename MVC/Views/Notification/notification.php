<?php
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

?>
<style>
    .notifications {
        display: none;
        position: absolute;
        top: 60px;
        right: 20px;
        width: 300px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    .header {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header h2 {
        font-size: 18px;
        margin: 0;
        font-size: 20px;
        font-weight: bold;
    }

    .tabs span {
        margin-left: 10px;
        cursor: pointer;
        color: #555;
        font-size: 14px;
    }

    .tabs .active {
        color: #1877f2;
        font-weight: bold;
    }

    .notification-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .notification-item.unread {
        background-color: #f9f9f9;
    }

    .notification-item .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .notification-item .content {
        flex-grow: 1;
    }

    .notification-item .content p {
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .notification-item .content .time {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
        display: block;
    }

    .view-more {
        display: block;
        width: 100%;
        padding: 10px;
        border: none;
        background: #f0f2f5;
        color: #1877f2;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
    }
</style>

<div class="notifications" id="notifications">
    <div class="header">
        <h2>Thông báo</h2>
        <div class="tabs">
            <span class="active">Tất cả</span>
        </div>
    </div>
    <div class="notification-list">
        <?php
        if (!empty($notifications)) {
            foreach ($notifications as $notification) {
                $user_notifications = [];
                if ($notification->getType() == "like") {
                    foreach ($likes as $like) {
                        if ($notification->getPost_id() == $like->getPost_id()) {
                            $user = $accountController->findUserbyId($like->getUser_like_id());
                            if ($user) {
                                $user_notifications[] = $user;
                            }
                        }
                    }
                }
                // Lấy người dùng từ Comments nếu loại thông báo là "comment"
                elseif ($notification->getType() == "comment") {
                    foreach ($comments as $comment) {
                        if ($notification->getPost_id() == $comment->getPost_id()) {
                            $user = $accountController->findUserbyId($comment->getUser_cmt_id());
                            if ($user) {
                                $user_notifications[] = $user;
                            }
                        }
                    }
                }
                // Hiển thị thông báo cho từng người trong danh sách
                foreach ($user_notifications as $user_notification) {
                    if ($user_notification->getUser_id() != $idUser) {
                        $name = $user_notification->getFull_name();
                        $avatar = $user_notification->getProfile_picture_url();
                        $avatarSrc = $avatar
                            ? 'data:image/jpeg;base64,' . base64_encode($avatar)
                            : "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";

        ?>
                        <div class="notification-item">
                            <img src="<?php echo $avatarSrc ?>" alt="User" class="avatar">
                            <div class="content">
                                <p>
                                    <strong><?php echo $name; ?></strong>
                                    <?php echo $notification->getContent(); ?>
                                </p>
                                <span class="time"><?php echo $notification->getCreated_at(); ?></span>
                            </div>
                        </div>
        <?php
                    }
                }
            }
        } else {
            echo "<p>Không có thông báo nào.</p>";
        }
        ?>
    </div>
    <button class="view-more">Xem thông báo trước đó</button>
</div>
<script>
    function addNewNotification(data) {
    fetch("/MVC/Process/photo_process.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id_user: data.id_user
        })
    })
    .then(response => response.json())
    .then(responseData => {
        var name = responseData.fullName;
        var avatarSrc = responseData.profilePicture;
        var notificationItem = document.createElement('div');
        notificationItem.classList.add('notification-item');
        notificationItem.innerHTML = `
            <img src="${avatarSrc}" alt="User" class="avatar">
            <div class="content">
                <p><strong>${name}</strong> ${data.content}</p>
                <span class="time">${new Date(data.sent_at).toLocaleString()}</span>
            </div>
        `;
        var notificationList = document.querySelector('.notification-list');
        notificationList.prepend(notificationItem);
    })
    .catch(error => {
        console.error("Error fetching user info:", error);
    });
}
    socket.on('receive_comment', (data) => {
        const id_user_data = String(data.id_user).trim(); 
        const normalizedSenderId = String(senderId).trim();
            if (id_user_data !== normalizedSenderId) {
                addNewNotification(data)
        } 
    });
    socket.on('receive_like', (data) => {
        const id_user_data = String(data.id_user).trim(); 
        const normalizedSenderId = String(senderId).trim();
            if (id_user_data !== normalizedSenderId) {
                addNewNotification(data)
        } 
    });
</script>