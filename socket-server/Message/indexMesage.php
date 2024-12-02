<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realtime Chat with Socket.io</title>
</head>
<body>
    <h1>Realtime Chat</h1>
    <div id="chat" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: auto;">
        <!-- Tin nhắn sẽ hiển thị ở đây -->
    </div>
    <input type="text" id="message" placeholder="Nhập tin nhắn..." style="width: 80%;">
    <button id="send">Gửi</button>

    <script src="https://cdn.socket.io/4.5.1/socket.io.min.js"></script>
    <script>
        // Kết nối tới server Socket.io (Node.js)
        const socket = io('http://localhost:4000'); 

        // Nhận tin nhắn từ server
        socket.on('receive_message', (data) => {
            const chatDiv = document.getElementById('chat');
            const message = document.createElement('p');
            message.textContent = `${data.username}: ${data.message}`;
            chatDiv.appendChild(message);
            chatDiv.scrollTop = chatDiv.scrollHeight; // Tự động cuộn xuống
        });

        // Gửi tin nhắn
        document.getElementById('send').addEventListener('click', () => {
            const messageInput = document.getElementById('message');
            const message = messageInput.value;
            if (message) {
                socket.emit('send_message', {
                    username: 'User 1', // Có thể thay bằng tên người dùng từ PHP
                    message: message,
                });
                messageInput.value = '';
            }
        });
    </script>
</body>
</html>