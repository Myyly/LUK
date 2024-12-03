<?php
// require_once '../../Controllers/MessageController.php';
// $messageController = new MessageController();
// $messages = $messageController->getConversations($idUser);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<link rel="stylesheet" href="/assets/CSS/variables.css">
<style>
    .chat-menu {
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

    .chat-menu .chat-header {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .chat-menu .chat-header input {
        width: 100% !important;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 20px;
        background-color: #f0f2f5;
    }

    .chat-menu .chat-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .chat-menu .chat-item {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
    }

    .chat-menu .chat-item:hover {
        background-color: #f0f2f5;
        border-radius: 8px;
    }

    .chat-menu .chat-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .chat-menu .chat-item .chat-info {
        display: flex;
        flex-direction: column;
    }

    .chat-menu .chat-item .chat-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .chat-detail {
        display: none;
        position: fixed;
        bottom: 0;
        right: 20px;
        width: 400px;
        height: 500px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 20;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .chat-detail .chat-header-detail {
        padding: 10px;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
    }

    .chat-detail .chat-header-detail img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .chat-detail .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-detail .chat-message {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        position: relative;
    }

    .chat-detail .chat-message.sent {
        justify-content: flex-end;
        text-align: right;
    }

    .chat-detail .chat-message.received {
        justify-content: flex-start;
        text-align: left;
    }

    .chat-detail .chat-message .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .chat-detail .chat-message .message-content {
        max-width: 70%;
        padding: 10px;
        font-size: 14px;
        border-radius: 10px;
        line-height: 1.4;
        word-wrap: break-word;
        position: relative;
        margin-bottom: 5px;
        /* Khoảng cách với thời gian */
    }

    .chat-detail .chat-message.sent .message-content {
        background-color: var(--background-message);
        color: #fff;
        margin-left: 10px;
    }

    .chat-detail .chat-message.received .message-content {
        background-color: #e0e0e0;
        color: #000;
        margin-right: 10px;
    }

    .chat-detail .chat-message .message-time {
        font-size: 12px;
        color: #999;
        text-align: center;
        /* Căn giữa thời gian */
        margin-top: 5px;
    }

    .chat-detail .chat-message.sent .message-time {
        right: 0;
        text-align: right;
    }

    .chat-detail .chat-message.received .message-time {
        left: 0;
        text-align: left;
    }

    .chat-detail .chat-input {
        padding: 10px;
        background: #fff;
        display: flex;
        align-items: center;
        border-top: 1px solid #ddd;
    }

    .chat-detail .chat-input input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 20px;
        margin-right: 10px;
        font-size: 14px;
    }

    .close  {
        background: var(--primary-color);
        color: white;
        border: none ;
        padding: 8px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 24px; 
    }
     /* .close i {
    background: var(--primary-color);
    font-size: 24px; 
    color: #fafafa; 
    cursor: pointer; 
    transition: transform 0.2s ease;
} */

.close:hover {
    transform: scale(1.2); 
    color: #ff5c5c;
}  
.btn-send-message{
    background: var(--primary-color);
        color: white;
        border: none ;
        padding: 8px 16px;
        border-radius: 20px;
        cursor: pointer;
        
}
#chatMessages {
    max-height: 500px; 
    overflow-y: auto;
    border: 1px solid #ccc;
}
</style>
<div id="chatMenu" class="chat-menu">
    <div class="chat-header">
        <h4 style="font-size: 20px;"><strong>Đoạn chat</strong></h4>
        <input type="text" placeholder="Tìm kiếm trên Messenger">
    </div>
    <ul class="chat-list">
        <?php
        foreach ($messages as $mess) {
            if ($mess->getReceiver_id() == $idUser) {
                $user_chat = $accountController->findUserbyId($mess->getSender_id());
            } else if ($mess->getSender_id() == $idUser) {
                $user_chat = $accountController->findUserbyId($mess->getReceiver_id());
            }
            $img_user_chat = $user_chat->getProfile_picture_url();
            if ($img_user_chat) {
                $base64Image = base64_encode($img_user_chat);
                $avatarSrc_user_chat = 'data:image/jpeg;base64,' . $base64Image;
            } else {
                $avatarSrc_user_chat = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
            }
            $name_user_chat = $user_chat->getFull_name();
        ?>
            <li class="chat-item" data-id-user-chat="<?php echo htmlspecialchars($user_chat->getUser_id()); ?>"
                data-avatar="<?php echo $avatarSrc_user_chat ?>">
                <img src="<?php echo $avatarSrc_user_chat; ?>" alt="Avatar" class="img-header">
                <div class="chat-info">
                    <p class="chat-name"><?php echo $name_user_chat; ?></p>
                    <p class="chat-last-message"><?php echo $mess->getMessage_content(); ?></p>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<div id="chatDetail" class="chat-detail" style="display: none;" >
<div class="chat-header-detail">
            <img src="" alt="Avatar" class="chat-avatar">
            <span class="chat-header-username"><strong></strong></span>
            <!-- <span class="close" onclick="closeChatDetail()">
                <i class="fa-solid fa-circle-xmark" style="color: #fafafa;"></i>
            </span> -->
        </div>
        <div class="chat-messages" id="chatMessages">
            <p>Đang tải tin nhắn...</p>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Nhập tin nhắn" id="message">
            <button type="button" class="btn-send-message" onclick="sendMessage()">Gửi</button>
        </div>
</div>
<script src="https://cdn.socket.io/4.5.1/socket.io.min.js"></script>
<script>
const socket = io('http://localhost:4000');
const chatItems = document.querySelectorAll(".chat-item");
let receiverId = null;  // ID người nhận
let senderId = <?php echo $_SESSION['idUser']; ?>; // ID người gửi
let avatarUrl = null;   // Avatar người nhận
function scrollToBottom() {
    const chatMessagesContainer = document.getElementById("chatMessages");
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}
scrollToBottom();
///////////////////////////// Chat SOCKET.IO

function addMessage(data, type) {
    const chatMessagesContainer = document.getElementById("chatMessages");
    // Tạo phần tử tin nhắn
    const messageElement = document.createElement("div");
    messageElement.classList.add("chat-message", type); // Thêm class type (sent/received)

    // Nếu là tin nhắn "received", hiển thị avatar người nhận
    if (type === "received") {
        const avatarElement = document.createElement("img");
        avatarElement.classList.add("avatar");
        avatarElement.src = data.avatar_user_chat; // Sử dụng avatar người nhận
        messageElement.appendChild(avatarElement);
    }

    // Nội dung tin nhắn
    const messageContent = document.createElement("div");
    messageContent.classList.add("message-content");
    messageContent.textContent = data.message_content;
    messageElement.appendChild(messageContent);

    // Thời gian tin nhắn
    const messageTime = document.createElement("div");
    messageTime.classList.add("message-time");
    messageTime.textContent = new Date(data.sent_at).toLocaleString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    });
    messageElement.appendChild(messageTime);
    chatMessagesContainer.appendChild(messageElement);

    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}
function sendMessage() {
    const messageInput = document.getElementById('message');
    const message = messageInput.value.trim();
    
    if (senderId && receiverId && message) {
        const data = {
            sender_id: senderId, // ID người gửi
            receiver_id: receiverId, // ID người nhận
            message_content: message, // Nội dung tin nhắn
            avatar_user_chat: avatarUrl, // Avatar người gửi
            sent_at: new Date().toISOString(), // Thời gian gửi
        };
        socket.emit('send_message', data); // Gửi tin nhắn qua socket
        updateChatList(data); // Cập nhật danh sách chat
        messageInput.value = ''; // Xóa ô nhập tin nhắn

        // Gửi tin nhắn vào server (PHP)
        fetch("/MVC/Process/message_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                sender_id: senderId,
                receiver_id: receiverId,
                message_content: message, // Nội dung tin nhắn
            })
        })
        .then(response => response.json())
        .then(data => {
            // Xử lý phản hồi từ server nếu cần
        })
        .catch(error => {
            // Xử lý lỗi nếu có
        });

    } else {
        alert('Vui lòng nhập tin nhắn.');
    }
}
</script>

<script>
function openChatDetail(idUser_chat, userName, avatar) {
    receiverId = idUser_chat; // Gán receiverId từ tham số
    avatarUrl = avatar; // Gán avatar người nhận từ tham số
    const chatDetail = document.getElementById("chatDetail");
    chatDetail.style.display = "flex"; // Hiển thị hộp thoại
    chatDetail.innerHTML = `
        <div class="chat-header-detail">
            <img src="${avatar}" alt="Avatar" class="chat-avatar">
            <span class="chat-header-username"><strong>${userName}</strong></span>
            <button class="close"onclick="closeChatDetail()">
                <i class="fa-solid fa-circle-xmark" style="color: #fafafa;"></i>
            </button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <p>Đang tải tin nhắn...</p>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Nhập tin nhắn" id="message">
            <button type="button" class="btn-send-message" onclick="sendMessage()">Gửi</button>
        </div>
    `;

    // Lấy tin nhắn cũ và hiển thị
    fetch("/MVC/Process/message_process.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ idUser_chat: idUser_chat })
    })
        .then(response => response.json())
        .then(data => {
            renderMessages(data); // Hiển thị tin nhắn
        })
        .catch(error => {
            console.error("Error fetching chat details:", error);
            const chatMessagesContainer = document.getElementById("chatMessages");
            chatMessagesContainer.innerHTML = '<p>Lỗi khi tải tin nhắn.</p>';
        });
}
function renderMessages(data) {
    const chatMessagesContainer = document.getElementById("chatMessages");
    chatMessagesContainer.innerHTML = ''; // Clear any existing messages or loading text
    if (data.length > 0) {
        data.forEach(message => {
            const messageElement = document.createElement("div");
            messageElement.classList.add("chat-message");

            if (message.sender_id === <?php echo $_SESSION['idUser']; ?>) {
                messageElement.classList.add("sent");
            } else {
                messageElement.classList.add("received");

                // Hiển thị avatar của người nhận
                const avatarElement = document.createElement("img");
                avatarElement.classList.add("avatar");
                avatarElement.src = message.avatar_user_chat;
                messageElement.appendChild(avatarElement);
            }

            // Nội dung tin nhắn
            const messageContent = document.createElement("div");
            messageContent.classList.add("message-content");
            messageContent.textContent = message.message_content;
            messageElement.appendChild(messageContent);

            // Thời gian tin nhắn
            const messageTime = document.createElement("div");
            messageTime.classList.add("message-time");
            messageTime.textContent = new Date(message.sent_at).toLocaleString("vi-VN", {
                hour: "2-digit",
                minute: "2-digit",
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
            messageElement.appendChild(messageTime);

            // Thêm tin nhắn vào khung chat
            chatMessagesContainer.appendChild(messageElement);
        });
    } else {
        chatMessagesContainer.innerHTML = '<p>Không có tin nhắn.</p>';
    }
}
function closeChatDetail() {
    document.getElementById("chatDetail").style.display = "none";
    document.getElementById("chatMenu").style.display = "none";
    }
chatItems.forEach((item) => {
    item.addEventListener("click", function() {
        receiverId = this.dataset.idUserChat; 
        const userName = this.querySelector(".chat-name").textContent; 
        avatarUrl = this.dataset.avatar; 
        openChatDetail(receiverId, userName, avatarUrl); 
    });
});
function scrollToBottom() {
    const chatMessagesContainer = document.getElementById("chatMessages");
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}
scrollToBottom();

function updateChatList(data) {
    const chatList = document.querySelector('.chat-list');
    const existingChatItem = document.querySelector(`.chat-item[data-id-user-chat="${data.receiver_id}"]`);

    if (existingChatItem) {
        const lastMessage = existingChatItem.querySelector('.chat-last-message');
        if (lastMessage) {
            lastMessage.textContent = data.message_content;
        }
        chatList.prepend(existingChatItem); 
    } else {
        // Nếu chưa có, thêm mới một chat item vào danh sách
        fetch("/MVC/Process/message_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                sender_id: data.sender_id,
                receiver_id: data.receiver_id
            })
        })
        .then(response => response.json())
        .then(userInfo => {
            const newChatItem = document.createElement('li');
            newChatItem.classList.add('chat-item');
            newChatItem.setAttribute('data-id-user-chat', data.receiver_id);
            newChatItem.innerHTML = `
                <img src="${userInfo.avatar || '/path/to/default-avatar.png'}" alt="Avatar" class="img-header">
                <div class="chat-info">
                    <p class="chat-name">${userInfo.full_name || 'Unknown User'}</p>
                    <p class="chat-last-message">${data.message_content || ''}</p>
                </div>
            `;
            chatList.prepend(newChatItem); // Thêm đoạn chat mới vào đầu danh sách
        })
        .catch(error => {
            console.error("Error fetching user info:", error);
        });
    }
}
// socket.on('receive_message', (data) => {
//     const normalizedReceiverId = String(receiverId).trim();
//     const normalizedSenderId = String(senderId).trim();
//     if (String(data.sender_id).trim() === normalizedSenderId && String(data.receiver_id).trim() === normalizedReceiverId) {
//         addMessage(data, 'sent');
//         updateChatList(data);
//     } else if (String(data.sender_id).trim() === normalizedReceiverId && String(data.receiver_id).trim() === normalizedSenderId) {
//         data.avatar_user_chat = avatarUrl;
//         addMessage(data, 'received');
//         updateChatList(data);
//     }
//     // Cập nhật danh sách chat
// });
socket.on('receive_message', (data) => {
    const normalizedReceiverId = String(receiverId).trim(); // ID người nhận
    const normalizedSenderId = String(senderId).trim(); // ID người gửi
    
    // Kiểm tra người nhận và người gửi
    if (String(data.sender_id).trim() === normalizedSenderId && String(data.receiver_id).trim() === normalizedReceiverId) {
        // Nếu là tin nhắn gửi đi
        addMessage(data, 'sent'); // Gửi tin nhắn
        updateChatList(data); // Cập nhật danh sách chat
    } else if (String(data.sender_id).trim() === normalizedReceiverId && String(data.receiver_id).trim() === normalizedSenderId) {
        // Nếu là tin nhắn nhận
        data.avatar_user_chat = avatarUrl; // Gán avatar cho người nhận
        addMessage(data, 'received'); // Nhận tin nhắn
        updateChatList(data); // Cập nhật danh sách chat
    }
});

</script>
