<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

function generateRandomCode() {
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}

function sendmail($email) {
    $code = generateRandomCode();
    $_SESSION['otp_code'] = $code;
    $mail = new PHPMailer(true); 
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'myylyymecafe@gmail.com';
    $mail->Password = "lokuwdebqammhmnv"; // Mật khẩu ứng dụng Gmail
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $fromEmail = 'myylyymecafe@gmail.com'; 
    $fromName = 'RAP CHIEU PHIM';
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Mã Xác Nhận";
    $mail->Body = "Mã xác nhận của bạn là: $code";

    return $mail->send(); // Trả về true hoặc false
}

if (isset($_POST["Signup"])) {
    $email = $_POST["email"];
    
    // Gửi email xác nhận
    if (sendmail($email)) {
        echo '<div style="color: green;">Gửi email thành công! Kiểm tra hộp thư của bạn.</div>';
    } else {
        echo '<div style="color: red;">Gửi email không thành công. Lỗi: ' . $mail->ErrorInfo . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signupBox {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .inputBox {
            margin-bottom: 15px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="signupBox">
        <h3>Đăng Ký</h3>
        <form action="" method="post">
            <div class="inputBox">
                <input type="text" name="name" placeholder="Tên" required>
            </div>
            <div class="inputBox">
                <input type="tel" name="phone" placeholder="Số điện thoại" required pattern="[0-9]{10}" title="Số điện thoại phải có 10 chữ số">
            </div>
            <div class="inputBox">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="inputBox">
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="inputBox">
                <input type="date" name="birthday" required>
            </div>
            <input type="submit" value="Signup" name="Signup">
        </form>
    </div>
</body>
</html>
