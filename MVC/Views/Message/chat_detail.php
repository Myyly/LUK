<!-- <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<link rel="stylesheet" href="/assets/CSS/chat_detail.css">


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
   
//     });
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

    // Thêm tin nhắn vào khung chat
    chatMessagesContainer.appendChild(messageElement);

    // Cuộn xuống cuối khung chat
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
        socket.emit('send_message', data);
        updateChatList(data);
        messageInput.value = '';
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
           // renderMessages(data); // Hiển thị tin nhắn
        })
        .catch(error => {
            // console.error("Error fetching chat details:", error);
            // const chatMessagesContainer = document.getElementById("chatMessages");
            // chatMessagesContainer.innerHTML = '<p>Lỗi khi tải tin nhắn.</p>';
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
    // Gửi yêu cầu đến API để lấy thông tin người dùng và lịch sử chat
    fetch("/MVC/Process/message_process.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            sender_id: data.sender_id,
            receiver_id: data.receiver_id
        })
    })
        .then(response => response.json())
        .then(userInfo => {
            const chatList = document.querySelector('.chat-list'); // Danh sách chat
            const existingChatItem = document.querySelector(
                `.chat-item[data-id-user-chat="${data.receiver_id}"]`
            );

            // Tin nhắn cuối cùng
            let lastMessageContent = data.message_content;

            if (userInfo.chatDetails && userInfo.chatDetails.length > 0) {
                // Cập nhật nội dung đoạn chat có sẵn
                if (existingChatItem) {
                    existingChatItem.querySelector('.chat-last-message').textContent = lastMessageContent;
                    chatList.prepend(existingChatItem); // Đưa đoạn chat lên đầu danh sách
                }
            } else {
                // Tạo đoạn chat mới nếu không có lịch sử tin nhắn
                if (!existingChatItem) {
                    const newChatItem = document.createElement('li');
                    newChatItem.classList.add('chat-item');
                    newChatItem.setAttribute('data-id-user-chat', data.receiver_id);
                    newChatItem.innerHTML = `
                        <img src="${userInfo.profilePicture}" alt="Avatar" class="img-header">
                        <div class="chat-info">
                            <p class="chat-name">${userInfo.fullName}</p>
                            <p class="chat-last-message">${lastMessageContent}</p>
                        </div>
                    `;
                    chatList.prepend(newChatItem); // Thêm đoạn chat mới vào danh sách
                }
            }
        })
        .catch(error => {
            console.error("Error fetching user info:", error);
        });
}
</script> -->
