
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);

// Middleware phục vụ file tĩnh
app.use(express.static(__dirname + '/public'));

const io = new Server(server, {
    cors: {
        origin: "*", // Cho phép tất cả các nguồn gốc (chỉ dùng trong phát triển)
        methods: ["GET", "POST"], // Cho phép các phương thức HTTP
    },
});

// Khi một kết nối socket được tạo
io.on('connection', (socket) => {
    console.log(`User connected: ${socket.id}`); // Sử dụng dấu backticks để xử lý chuỗi template
    socket.on('send_message', (data) => {
        console.log(data);
        io.emit('receive_message', data); // Phát tin nhắn đến tất cả các client kết nối
        io.emit('notification_update', data);
        
    });
    socket.on('send_like', (data) => {
        console.log(data);
        io.emit('receive_like', data); // Phát tin nhắn đến tất cả các client kết nối    
    });
    socket.on('send_unlike', (data) => {
        console.log(data);
        io.emit('receive_unlike', data);
    });
    socket.on('send_comment', (data) => {
        console.log(data);
        io.emit('receive_comment', data); // Phát tin nhắn đến tất cả các client kết nối    
    });

    // Khi một socket ngắt kết nối
    socket.on('disconnect', () => {
        console.log(`User disconnected: ${socket.id}`); // Sử dụng dấu backticks để xử lý chuỗi template
    });
});

// Lắng nghe trên cổng 4000
server.listen(4000, () => {
    console.log('WebSocket server is running on http://localhost:4000');
});

