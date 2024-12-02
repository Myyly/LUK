<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/AccountController.php';
$accountController = new AccountController();
$errorMessage = "";
$email = $_SESSION['email'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnResetPassword"])) {
        $newPass = $_POST['password'];
        if (empty($newPass)) {
            $errorMessage = "Vui lòng nhập mật khẩu mới để tiến hành tạo lại mật khẩu.";
        } elseif (strlen( $_POST['password']< 6)) {
            $errorMessage = "Mật khẩu phải có tối thiểu 6 ký tự.";
        } elseif ($newPass != $_POST['confirm_password']) {
            $errorMessage = "Xác nhận mật khẩu không chính xác. Vui lòng kiểm tra lại.";
        } else {
            $accountController->resetPassword($email,$newPass);
            header("Location: ressetpass_succsess.php"); 
            exit();
        }
    } elseif (isset($_POST["btnCancel"])) {
        header("Location: login.php"); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <title>Email Verification</title>
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
    width: 500px; /* Đặt chiều rộng cố định */
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
input[type="password"] {
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
    background-color: var(--link-hover-color);
}

.resend {
    margin-top: 15px; /* Khoảng cách trên của phần gửi lại */
}

.resend a {
    color: var(--primary-color); /* Màu chữ của liên kết gửi lại */
    text-decoration: none; /* Không gạch chân */
    font-size: 14px; /* Kích thước văn bản liên kết */
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
        <h3>Tạo mật khẩu mới</h3>
        <p>Tạo mật khẩu mới có tối thiểu 6 ký tự.Mật khẩu mạnh là mật khẩu được kết hợp từ các ký tự,số và dấu câu</p>
        <?php if (!empty($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
        <form method="post" action="">
            <input type="password" name="password" placeholder="Nhập mật khẩu mới" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            <input type="text"name="confirm_password" placeholder="Xác nhận mật khẩu mới">
            <button type="submit" name = "btnResetPassword">Tiếp tục</button>
        </form>
        <div class="resend">
    <form action="" method="post">
        <button type="submit" class="btn btn-link" name = "btnCancel">Huỷ</button>
    </form>
</div>
    </div>
</body>
</html>
