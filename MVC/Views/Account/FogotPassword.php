<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
require_once '../../Views/Account/AccountServices.php';
$accountController=new AccountController();
$accountService = new AccountService();

$errorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['btnSearch'])){
            if($_POST["email"]==null){
                $errorMessage = "<strong>Vui lòng điền vào trường dữ liệu</strong><br>Điền vào trường dữ liệu bên dưới để thực hiện tìm kiếm tài khoản của bạn!";
            }else {
                $contact = $_POST['email'];
                $user = null;
                if($contact == null  ){
                    $errorMessage = "<strong>Không tìm thấy tài khoản</strong><br> $contact không kết nối với tài khoản nào,Vui lòng kiểm tra lại!";
                }else{
                if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                    $user = $accountController->LoginByEmail($contact); 
                }
                elseif (preg_match('/^[0-9]{10,15}$/', $contact)) {
                    $user = $accountController->LoginByPhoneNumber($contact); 
                } else {
                    $errorMessage = "<strong>Không tìm thấy tài khoản</strong><br> $contact không kết nối với tài khoản nào,Vui lòng kiểm tra lại!";
                   
                }
                if ($user != null) {
                    if (($user->getEmail() == $contact)) {
                        $accountService->sendmail($user->getEmail());
                        $_SESSION['resetpassword'] = true; 
                        $_SESSION['email'] = $user->getEmail();
                        header("Location: confirm_email.php"); 
                        exit();
                    } else if (($user->getPhone_numberl() == $contact)) {

                        header("Location: confirm_phone.php"); 
                        exit();
                    }
                } else {
                    $errorMessage = "<strong>Không tìm thấy tài khoản</strong><br> $contact không kết nối với tài khoản nào,Vui lòng kiểm tra lại!";
                }
            }
            }
        }
        if (isset($_POST['btnCancel'])) {
        header("Location: login.php"); // Chuyển hướng tới trang đăng nhập
        exit();
    }

        if(isset($_POST['btnLogin'])){
        $contact = $_POST['contact'];
        $pass = $_POST['password'];
        if($contact == null && $pass == null){
            $_SESSION['err'] = "Email hoặc số di động bạn nhập không kết nối với tài khoản nào.";
            header("Location: login.php"); 
            exit();
        }else{
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $user = $accountController->LoginByEmail($contact); 
        }
        elseif (preg_match('/^[0-9]{10,15}$/', $contact)) {
            $user = $accountController->LoginByPhoneNumber($contact); 
        } else {
            $errorMessage = "Dữ liệu không hợp lệ. Vui lòng nhập email hoặc số điện thoại.";
            exit();
        }
        if ($user != null) {
            if (($user->getEmail() == $contact || $user->getPhone_numberl() == $contact) && password_verify($pass, $user->getPassword_hash())) {
                header("Location: profile.php"); 
                exit();
            } else {
                $_SESSION['err']= " Mật khẩu không đúng.";
                header("Location: login.php"); 
                exit();
            }
        } else {
            $_SESSION['err']= "Email hoặc số di động bạn nhập không kết nối với tài khoản nào.";
            header("Location: login.php"); 
                exit();
        }
    }
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
        <form action="" method ="POST">
        <div class="login-form">
            <input type="text" placeholder="Email hoặc điện thoại" name ="contact">
            <input type="password" placeholder="Mật khẩu" name = "password">
            <button type= "submit" class="login-btn" name="btnLogin">Đăng nhập</button>
        </div>
        </form>
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
                    <button type="submit" class="search-btn" name ="btnSearch">Tìm kiếm</button>
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
    min-height: 100vh;
}
.header {
    width: 100%;
    background-color: white;
    padding: 15px 50px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Logo Styling */
.header .logo h1 {
    color: var(--primary-color);
    font-size: 36px;
    font-weight: bold;
}

/* Login Form Styling */
.login-form {
    display: flex;
    align-items: center;
    gap: 10px;
}

.login-form input {
    padding: 8px 10px;
    border: 1px solid #dddfe2;
    border-radius: 4px;
    font-size: 14px;
    min-width: 150px;
}

.login-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.login-btn:hover {
    background-color: var(--link-hover-color);
}

/* Container Styling */
.container {
    width: 100%;
    max-width: 400px;
    text-align: center;
    margin-top: 40px;
    padding: 0 20px; /* Added padding for smaller screens */
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

.form-container form input {
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
    gap: 10px;
}

.cancel-btn {
    background-color: #f5f6f7;
    color: #4b4f56;
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-btn {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.cancel-btn:hover {
    background-color: #e4e6eb;
}

.search-btn:hover {
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

/* Responsive Design */
@media (max-width: 768px) {
    .header {
        padding: 15px 20px;
    }

    .login-form {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
        width: 100%;
    }

    .login-form input {
        min-width: 100%;
    }

    .login-btn {
        width: 100%;
    }

    .container {
        margin-top: 30px;
    }
}

@media (max-width: 480px) {
    .header .logo h1 {
        font-size: 28px;
    }

    .login-form input {
        padding: 6px 8px;
        font-size: 12px;
    }

    .login-btn {
        padding: 6px 12px;
        font-size: 12px;
    }
}

</style>