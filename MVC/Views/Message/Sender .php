<?php
require_once '../../Controllers/MessageController.php';
$messageController = new MessageController();
$messages = $messageController->getConversations($idUser);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<link rel="stylesheet" href="/assets/CSS/variables.css">
<style>
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

    .chat-detail .chat-input button {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        cursor: pointer;
    }
    .close i {
    font-size: 24px; /* Thay đổi kích thước icon */
    color: #fafafa; /* Màu sắc */
    cursor: pointer; /* Hiệu ứng con trỏ khi hover */
    transition: transform 0.2s ease; /* Hiệu ứng khi hover */
}

.close i:hover {
    transform: scale(1.2); /* Phóng to icon khi hover */
    color: #ff5c5c; /* Đổi màu khi hover (tuỳ chỉnh nếu muốn) */
}
#chatMessages {
    max-height: 500px; 
    overflow-y: auto;
    border: 1px solid #ccc;
}
</style>


<div id="chatDetail" class="chat-detail" >
<div class="chat-header-detail">
            <img src="${avatarUrl}" alt="Avatar" class="chat-avatar">
            <span class="chat-header-username"><strong>${userName}</strong></span>
            <span class="close" onclick="closeChatDetail()">
                <i class="fa-solid fa-circle-xmark" style="color: #fafafa;"></i>
            </span>
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
let receiverId = null;  // Biến lưu trữ receiver_id
let avatarUrl = null;   // Biến lưu trữ avatarUrl
function scrollToBottom() {
    const chatMessagesContainer = document.getElementById("chatMessages");
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}
scrollToBottom();
///////////////////////////// Chat SOCKET.IO
socket.on('receive_message', (data) => {
    console.log('Received message:', data); 
    const senderId = '6';
    const receiverId = '8';
            // Phân loại tin nhắn nhận hay gửi
            if (data.sender_id === senderId && data.receiver_id === receiverId) {
                addMessage(data, 'sent');
            } else if (data.sender_id === receiverId && data.receiver_id === senderId) {
                addMessage(data, 'received');
            }
   
});
function addMessage(data, type) {
    const chatMessagesContainer = document.getElementById("chatMessages");
    // Tạo phần tử tin nhắn
    const messageElement = document.createElement("div");
    messageElement.classList.add("chat-message", type); // Thêm class type (sent/received)

    // Nếu là tin nhắn "received", thêm avatar
    if (type === "received" && data.avatar_user_chat) {
        const avatarElement = document.createElement("img");
        avatarElement.classList.add("avatar");
        avatarElement.src = data.avatar_user_chat;
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

    // Thêm tin nhắn vào khung chat
    chatMessagesContainer.appendChild(messageElement);

    // Cuộn xuống cuối khung chat
    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
}

         function sendMessage() {
        //     const senderIdInput = document.getElementById('senderId');
        //     const receiverIdInput = document.getElementById('receiverId');
            const messageInput = document.getElementById('message');

            const senderId = '6';
            const receiverId = '8';
            const message = messageInput.value.trim();

            if (senderId && receiverId && message) {
                const data = {
                    sender_id: senderId,
                    receiver_id: receiverId,
                    message_content: message,
                    sent_at: new Date().toISOString(),
                };

                socket.emit('send_message', data);
                messageInput.value = '';
            } else {
                alert('Please enter Sender ID, Receiver ID, and a message.');
            }
        
}
</script>
