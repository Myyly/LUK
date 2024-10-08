<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <title>SMS Verification</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2; /* Màu nền sáng */
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column; /* Thay đổi thành cột */
    align-items: center;
    height: 100vh; /* Đảm bảo chiều cao 100% */
}

.header {
    width: 100%;
    background-color: white; /* Màu nền của header */
    padding: 15px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 50px;
}

.header .logo h1 {
    color: var(--primary-color); /* Màu logo */
    font-size: 36px;
    font-weight: bold;
}

.container {
    background-color: white; /* Màu nền của container */
    padding: 30px; /* Tăng khoảng cách bên trong */
    border-radius: 8px; /* Bo tròn các góc */
    box-shadow: 0 0 15px rgba(0,0,0,0.2); /* Tăng độ mờ cho bóng */
    text-align: center; /* Căn giữa văn bản */
    width: 320px; /* Đặt chiều rộng cố định */
    border: 1px solid #e0e0e0; /* Thêm đường viền nhẹ */
    margin-top: 20px; /* Thêm khoảng cách trên để tách khỏi header */
}

h3 {
    font-size: 24px; /* Kích thước tiêu đề lớn hơn */
    margin-bottom: 15px; /* Thêm khoảng cách dưới tiêu đề */
}

p {
    font-size: 14px; /* Kích thước văn bản mô tả */
    color: #606770; /* Màu văn bản mô tả */
    margin-bottom: 20px; /* Khoảng cách dưới mô tả */
}

input[type="text"] {
    width: 100%;
    padding: 12px; /* Tăng kích thước padding */
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 16px; /* Kích thước văn bản trong input */
}

button {
    width: 100%;
    padding: 12px; /* Tăng kích thước padding */
    background-color: var(--primary-color); /* Màu nền của nút */
    color: white; /* Màu chữ */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px; /* Kích thước văn bản trong nút */
}

button:hover {
    background-color: var(--link-hover-color); /* Màu khi hover */
}

.resend {
    margin-top: 15px; /* Khoảng cách trên của phần gửi lại */
}

.resend a {
    color: var(--primary-color); /* Màu chữ của liên kết gửi lại */
    text-decoration: none; /* Không gạch chân */
    font-size: 14px; /* Kích thước văn bản liên kết */
}

.resend a:hover {
    text-decoration: underline; /* Gạch chân khi hover */
}
    </style>
</head>
<body>
<div class="header">
        <div class="logo">
            <h1>LUX</h1>
        </div>
    </div>
    <div class="container">
        <h3>Nhập mã xác nhận từ tin nhắn văn bản</h3>
        <p>Để đảm bảo đây chính là số di động của bạn, hãy nhập đoạn mã mà chúng tôi đã gửi qua tin nhắn SMS.</p>
        <form method="post" action="">
            <input type="text" name="verification_code" placeholder="L-XXXXXX" required>
            <button type="submit">Tiếp tục</button>
        </form>
        <div class="resend">
            <a href="#">Gửi lại SMS</a>
        </div>
    </div>
</body>
</html>
