const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);

// Middleware phục vụ file tĩnh
app.use(express.static(__dirname + '/public'));

const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

io.on('connection', (socket) => {
    console.log(`User connected: ${socket.id}`);

    // Khi người dùng kết nối, họ sẽ tham gia vào một room với ID của họ
    socket.on('join_room', (userId) => {
        socket.join(userId);
        console.log(`User ${userId} joined room ${userId}`);
    });

    // Xử lý gửi tin nhắn
    socket.on('send_message', (data) => {
        console.log(data);

        // Gửi tin nhắn đến người nhận
        io.to(data.receiver_id).emit('receive_message', data);

        // Gửi phản hồi tin nhắn đến chính người gửi
        io.to(data.sender_id).emit('receive_message', data);
    });

    // Khi người dùng ngắt kết nối
    socket.on('disconnect', () => {
        console.log(`User disconnected: ${socket.id}`);
    });
});

server.listen(4000, () => {
    console.log('WebSocket server is running on http://localhost:4000');
});