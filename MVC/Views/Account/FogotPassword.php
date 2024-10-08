<?php
$errorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $errorMessage = "<strong>Vui lòng điền vào trường dữ liệu</strong><br>Điền vào trường dữ liệu bên dưới để thực hiện tìm kiếm tài khoản của bạn!";
    } else {
        // Xử lý khi có email (nếu cần)
        // $email = $_POST["email"];
    }

    if (isset($_POST['btnCancel'])) {
        header("Location: login.php"); // Chuyển hướng tới trang đăng nhập
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu | Không thể đăng nhập - Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/assets/CSS/variables.css">
</head>
<body>
<div class="header">
        <div class="logo">
            <h1>LUX</h1>
        </div>
        <div class="login-form">
            <input type="text" placeholder="Email hoặc điện thoại">
            <input type="password" placeholder="Mật khẩu">
            <button class="login-btn">Đăng nhập</button>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Tìm tài khoản của bạn</h2>
            <p>Vui lòng nhập email hoặc số di động để tìm kiếm tài khoản của bạn.</p>

            <?php if (!empty($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" id="email-input" name="email" placeholder="Email hoặc số di động">
                <div class="buttons">
                    <button type="submit" class="cancel-btn" name ="btnCancel">Hủy</button>
                    <button type="submit" class="search-btn">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f3f5;
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
    justify-content: space-between;
    align-items: center;
    padding: 0 50px;
}

.header .logo h1 {
    color:  var(--primary-color);
    font-size: 36px;
    font-weight: bold;
}

.header .login-form {
    display: flex;
    gap: 10px;
}

.header input {
    padding: 10px;
    border: 1px solid #dddfe2;
    border-radius: 4px;
    font-size: 14px;
}

.login-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.login-btn:hover {
    opacity: 0.9;
    background-color: var(--link-hover-color);
}

.container {
    width: 400px;
    text-align: center;
    margin-top: 40px;
}

.form-container {
    background-color: white;
    border: 1px solid #dddfe2;
    border-radius: 8px;
    padding: 20px;
    text-align: left;
}

.form-container h2 {
    font-size: 22px;
    margin-bottom: 10px;
    font-weight: normal;
}

.form-container p {
    font-size: 14px;
    color: #606770;
    margin-bottom: 20px;
}

form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #dddfe2;
    border-radius: 4px;
    font-size: 16px;
}

.buttons {
    display: flex;
    justify-content: flex-end;
}

.cancel-btn {
    background-color: #f5f6f7;
    color: #4b4f56;
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    margin-right: 8px;
    cursor: pointer;
}

.search-btn {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.cancel-btn:hover, .search-btn:hover {
    opacity: 0.9;
    background-color: var(--link-hover-color);
}
.error-message {
    background-color: #FBCCDA;
    color: #000000;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #FA3;
    border-radius: 4px;
    font-size: 14px;
}
</style>