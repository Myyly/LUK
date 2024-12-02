<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat App</title>
    <script src="https://cdn.socket.io/4.7.1/socket.io.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .chat-container {
            width: 800px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .chat-header {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .chat-messages {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            background: #f9f9f9;
        }
        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .chat-input button {
            padding: 10px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background: #0056b3;
        }
        .chat-message {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }
        .chat-message.sent {
            align-items: flex-end;
        }
        .chat-message.received {
            align-items: flex-start;
        }
        .chat-message .message-content {
            max-width: 70%;
            padding: 10px;
            border-radius: 8px;
            background: #007bff;
            color: white;
        }
        .chat-message.received .message-content {
            background: #f1f1f1;
            color: #333;
        }
        .chat-message .message-time {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Simple Chat</div>
        <div class="chat-messages" id="chatMessages"></div>
        <div class="chat-input">
            <input type="text" id="senderId" placeholder="Sender ID" style="width: 80px; margin-right: 5px;">
            <input type="text" id="receiverId" placeholder="Receiver ID" style="width: 80px; margin-right: 5px;">
            <input type="text" id="message" placeholder="Enter message..." style="flex: 1; margin-right: 5px;">
            <button onclick="sendMessage()" style="flex-shrink: 0;">Send</button>
        </div>
    </div>

    <script>
        const socket = io('http://localhost:4000');
        const chatMessagesContainer = document.getElementById('chatMessages');

        // Gửi tin nhắn
        function sendMessage() {
            const senderIdInput = document.getElementById('senderId');
             const receiverIdInput = document.getElementById('receiverId');
            const messageInput = document.getElementById('message');

            const senderId = senderIdInput.value.trim();
            const receiverId = receiverIdInput.value.trim();
            const message = messageInput.value.trim();

            if (senderId && receiverId && message) {
                const data = {
                    sender_id: senderId,
                    receiver_id: receiverId,
                    message_content: message,
                    sent_at: new Date().toISOString(),
                };

                socket.emit('send_message', data);

                // Hiển thị tin nhắn gửi
              //  displayMessage(data, 'sent');

                messageInput.value = '';
            } else {
                alert('Please enter Sender ID, Receiver ID, and a message.');
            }
        }

        // Nhận tin nhắn
        socket.on('receive_message', (data) => {
            const senderIdInput = document.getElementById('senderId');
            const receiverIdInput = document.getElementById('receiverId');

            const senderId = senderIdInput.value.trim();
            const receiverId = receiverIdInput.value.trim();

            // Phân loại tin nhắn nhận hay gửi
            if (data.sender_id === senderId && data.receiver_id === receiverId) {
                displayMessage(data, 'sent');
            } else if (data.sender_id === receiverId && data.receiver_id === senderId) {
                displayMessage(data, 'received');
            }
        });

        // Hiển thị tin nhắn
        function displayMessage(data, type) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('chat-message', type);

            const messageContent = document.createElement('div');
            messageContent.classList.add('message-content');
            messageContent.textContent = data.message_content;
            messageElement.appendChild(messageContent);

            const messageTime = document.createElement('div');
            messageTime.classList.add('message-time');
            messageTime.textContent = new Date(data.sent_at).toLocaleTimeString('vi-VN');
            messageElement.appendChild(messageTime);

            chatMessagesContainer.appendChild(messageElement);
            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
        }
    </script>
</body>