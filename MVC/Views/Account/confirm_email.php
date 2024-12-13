<?php
session_start();
$errorMessage = "";
require_once '../../Views/Account/AccountServices.php';
require_once '../../Controllers/AccountController.php';
$accountController = new AccountController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btnConfirm'])) {
      //  $code = $_SESSION['otp_code'] ?? null; 
       $code = $_SESSION['otp_code'] ?? null; 
    //     if ($code == $_POST['verification_code']) {
    //         $email = $_SESSION['email'];
    //         $phone_number = $_SESSION[''];
    //         $password_hash = password_hash($_SESSION['password'], PASSWORD_BCRYPT);
    //         $full_name = $_SESSION['fullname'];
    //         $date_of_birth =  $_SESSION['dayofbirth'];
    //         $gender = $_SESSION['gender'];
    //         $profile_picture_url = 'user_default.png';
    //         $bio =" "; 
    //         $status="active";
    //         $accountController->SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status);
    //         header("Location: signup_success.php"); 
    //         exit();
    //     } elseif (empty($_POST["verification_code"])) {
    //         $errorMessage = "<strong>Vui lòng điền vào trường dữ liệu</strong><br>Điền vào trường dữ liệu bên dưới để thực hiện xác nhận Email của bạn!";
    //     } elseif ($code != $_POST['verification_code']) {
    //         $errorMessage = "<strong>Mã OTP không đúng</strong><br>Vui lòng kiểm tra lại!";
    //     }
       if(empty($_POST["verification_code"])) {
         $errorMessage = "<strong>Vui lòng điền vào trường dữ liệu</strong><br>Điền vào trường dữ liệu bên dưới để thực hiện xác nhận Email của bạn!";
       }else if($code == $_POST['verification_code']){
            if(isset($_SESSION['resetpassword']) && $_SESSION['resetpassword']==true){
                $email = $_SESSION['email'] ?? null;
                if($email){
                    header("Location: resetpassword.php"); 
                    exit();
                } else {
                    $errorMessage = "Không tìm thấy thông tin email trong phiên. Vui lòng thử lại.";
                }
                }else {
                    $email = $_SESSION['email'] ?? null;
                    $phone_number = $_SESSION['phone_number'] ?? null;
                    $password = $_SESSION['password'] ?? null;
                    $full_name = $_SESSION['fullname'] ?? '';
                    $date_of_birth = $_SESSION['dayofbirth'] ?? null;
                    $gender = $_SESSION['gender'] ?? '';
                    
                    if ($email && $password) {
                        $password_hash = password_hash($password, PASSWORD_BCRYPT);
                        $profile_picture_url = " ";
                        $bio = " "; 
                        $status = "active";
                        $cover_photo ="";
                        $signup_type="email";
                        $accountController->SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo,$signup_type);
                        header("Location: signup_success.php"); 
                        exit();
                    } else {
                        $errorMessage = "Dữ liệu không đầy đủ để đăng ký. Vui lòng thử lại.";
                    }
                }
            } else {
                $errorMessage = "<strong>Mã OTP không đúng</strong><br>Vui lòng kiểm tra lại!";
            }
                }

    elseif (isset($_POST['btnResend'])) {
        $accountService = new AccountService();
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $accountService->sendmail($email); 
        } else {
            $errorMessage = "Không tìm thấy email trong phiên. Vui lòng xác nhận email trước!";
        }
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
        <h3>Nhập mã xác nhận từ email của bạn</h3>
        <p>Để đảm bảo đây chính là email của bạn, hãy nhập đoạn mã mà chúng tôi đã gửi qua tin nhắn SMS.</p>
        <?php if (!empty($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="verification_code" placeholder="L-XXXXXX">
            <button type="submit" name="btnConfirm">Tiếp tục</button>
        </form>
        <div class="resend">
    <form action="" method="post">
        <input type="hidden" name="resendEmail" value="true">
        <button type="submit" class="btn btn-link" name = "btnResend">Gửi lại email</button>
    </form>
</div>
    </div>
</body>
</html>
