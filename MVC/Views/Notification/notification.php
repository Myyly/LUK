<?php
// Ví dụ hiển thị thông báo khi nhận sự kiện
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    echo "<div class='notification'>{$message}</div>";
}
?>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

.post {
    margin: 20px 0;
}

.like-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.like-btn:hover {
    background-color: #0056b3;
}

.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    max-width: 300px;
}

.notification {
    background-color: #28a745;
    color: white;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* Icon chuông */
.notification-bell {
    position: fixed;
    top: 20px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}

.notification-bell i {
    color: #007bff;
}

.notification-count {
    position: absolute;
    top: -5px;
    right: -10px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 3px 8px;
    font-size: 14px;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Example</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="post">
        <button id="likeButton" class="like-btn">Like</button>
    </div>

    <!-- Icon chuông và số lượng thông báo -->
    <div id="notificationBell" class="notification-bell">
        <i class="fa fa-bell"></i>
        <span id="notificationCount" class="notification-count">0</span>
    </div>

    <div id="notificationContainer" class="notification-container"></div>

</body>
</html>
<script>
  const socket = io('http://localhost:4000');

// Lấy nút Like và thêm sự kiện click
const likeButton = document.getElementById('likeButton');
likeButton.addEventListener('click', () => {
    // Gửi sự kiện "like" tới server
    socket.emit('like', { username: 'User123', postId: 'Post001' });

    // Đổi màu nút Like
    likeButton.style.backgroundColor = 'red';
    likeButton.innerText = 'Liked';
});

// Số lượng thông báo chưa đọc
let notificationCount = 0;

// Nhận thông báo từ server
socket.on('notification', (data) => {
    const notificationContainer = document.getElementById('notificationContainer');
    const notificationBell = document.getElementById('notificationBell');
    const notificationCountElement = document.getElementById('notificationCount');
    // Hiển thị thông báo
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.innerText = data.message;
    notificationContainer.appendChild(notification);

    // Cập nhật số lượng thông báo
    notificationCount++;
    notificationCountElement.innerText = notificationCount;

    // Ẩn thông báo sau 5 giây
    setTimeout(() => {
        notification.remove();
    }, 5000);
});
</script>