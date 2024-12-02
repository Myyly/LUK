<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/AccountController.php';
$accountController=new AccountController();
$errorMessage = isset($_SESSION['err']) ? $_SESSION['err'] : '';
unset($_SESSION['err']); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btnSignUp'])) {
        header("Location: signup.php"); 
        exit();
    } elseif (isset($_POST['btnLogin'])) {
        $contact = $_POST['email'];
        $pass = $_POST['password'];
        if($contact == null && $pass == null){
            $errorMessage= "Email hoặc số di động bạn nhập không kết nối với tài khoản nào.";
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
                $_SESSION['idUser'] = $user->getUser_id();
                // echo "Đăng nhập thành công!";
                header("Location: /index.php"); 
                exit();
            } else {
                $errorMessage= " Mật khẩu không đúng.";
            }
        } else {
            $errorMessage= "Email hoặc số di động bạn nhập không kết nối với tài khoản nào.";
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
    <title>Lux - Đăng nhập hoặc đăng ký</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-GmPkdT/zrYr4b6o/nBHSY7n8r8S0w/tH2Gkq5CZL/0lE/0hQg4RlDm8cg09wxglg" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-Cueo4u5zQxWx2e6r7SmM1dXMBMbRkPFDLZSyD+fl/zMXsPTxtMheRP8dGKe5zC4x" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="/assets/CSS/account.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="lux-header text-center py-3">LUX</div>
    <div class="login-container">
        <form action="" method="POST" class="needs-validation" novalidate>
            <input type="email" name="email" placeholder="Email hoặc số điện thoại" required class="form-control mb-3" value="<?php echo isset($contact) ? htmlspecialchars($contact) : ''; ?>">
            <input type="password" name="password" placeholder="Password" required class="form-control mb-3">
            <div class="text-danger mb-3"><?php echo $errorMessage; ?></div> <!-- Hiển thị thông báo lỗi cho mật khẩu -->

            <button type="submit" class="login-btn btn btn-primary btn-block" name="btnLogin">Đăng nhập</button>
        
            <a href="FogotPassword.php" class="forgot-password d-block text-center my-2">
                <strong> Quên mật khẩu? </strong>
            </a>
            <button type="submit" class="create-btn" name="btnSignUp">Tạo tài khoản mới</button>
        </form>
    </div>
    <div class="footer text-center my-4">
        <p><a href="#">Tạo trang</a> dành cho người nổi tiếng, thương hiệu hoặc doanh nghiệp.</p>
    </div>
</body>
</html>