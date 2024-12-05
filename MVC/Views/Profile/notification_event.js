function handleNotification(idUser, data) {
    const normalizedSenderId = String(data.sender_id).trim();
    const normalizedReceiverId = String(data.receiver_id).trim();
    const normalizedUserId = String(idUser).trim();
    if (normalizedSenderId !== normalizedUserId && normalizedReceiverId == normalizedUserId )  {
        notificationCount++;
        document.getElementById('notificationCount').textContent = notificationCount;
    }
}
function increaseNotification() {
    if (notificationCount > 0) {
        notificationCount--;
        document.getElementById('notificationCount').textContent = notificationCount;
    }
}
function isChatDetailVisible() {
    const chatDetail = document.getElementById("chatDetail");
    return chatDetail.style.display === "flex"; // Kiểm tra nếu `chatDetail` đang hiển thị
}

function handleNotificationIfChatVisible(idUser, data) {
    if (!isChatDetailVisible()) {
        handleNotification(idUser, data);
    }
}

//
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
        const chatMenu = document.getElementById("chatMenu");
        if (chatMenu.style.display === "block") {
            chatMenu.style.display = "none";
        } else {
            chatMenu.style.display = "block";
        }
        const notification = document.getElementById("notifications");
        notification.style.display = "none";
    }

    function toggleNotification() {
        const notification = document.getElementById("notifications");
        if (notification.style.display === "block") {
            notification.style.display = "none";
        } else {
            notification.style.display = "block";
        }
        const chatMenu = document.getElementById("chatMenu");
        chatMenu.style.display = "none";
        if (notificationCountnBell > 0) {
            notificationCountnBell--;
        } else notificationCountnBell = 0;
        document.getElementById('bellNotificationCount').textContent = notificationCountnBell;
        }
    

    
