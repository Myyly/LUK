<?php
// signup_success.php
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=login.php"> <!-- Tự động chuyển hướng sau 5 giây -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Thành Công | Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .header {
            width: 100%;
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 50px;
        }

        .header .logo h1 {
            color: var(--primary-color);
            font-size: 36px;
            font-weight: bold;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
            border: 1px solid #e0e0e0;
            margin-top: 20px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        p {
            font-size: 16px;
            color: #606770;
            margin-bottom: 20px;
        }

        button {
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: var(--link-hover-color);
        }

        .resend {
            margin-top: 15px;
        }

        .resend a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
        }

        .resend a:hover {
            text-decoration: underline;
        }

        .timer {
            margin-top: 10px;
            font-size: 14px;
            color: #606770;
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
        <h3>Đăng Ký Thành Công</h3>
        <p>Cảm ơn bạn đã đăng ký! Bạn có thể đăng nhập vào tài khoản của mình ngay bây giờ.</p>
        <button onclick="window.location.href='login.php'">Đăng Nhập</button>
        <div class="timer">
            Bạn sẽ được chuyển hướng tới trang đăng nhập trong <span id="countdown">5</span> giây...
        </div>
    </div>

    <script>
        // JavaScript để cập nhật đếm ngược thời gian và chuyển hướng
        let timeLeft = 5;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>
</body>

</html>
