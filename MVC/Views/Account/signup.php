<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
require_once '../../Views/Account/AccountServices.php';

$accountController = new AccountController();
$accountService = new AccountService();
$passwordError = "";
$email_err = ""; 
$confirmPasswordError = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registerAccount'])) {
        $pass = $_POST['password'];
        $confpass = $_POST['confirmPassword'];
        $contact = $_POST['contact']; 
        if ($pass !== $confpass) {
            $confirmPasswordError = "Mật khẩu không khớp.";
        } else {
            if ($contact==null) {
                $email_err = "Email hoặc số điện thoại không hợp lệ.";
            } elseif (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                $email = $contact; 
                if ($accountController->checkEmailExist($email)) {
                    $email_err = "Email đã tồn tại, hãy thử lại bằng email khác hoặc số điện thoại.";
                } else {
                    $_SESSION['email'] = $email; 
                    $_SESSION['password'] = $pass;
                    $_SESSION['fullname'] = $_POST['firstName'];
                    $_SESSION['gender'] = $_POST['gender'];
                    $_SESSION['dayofbirth'] = $_POST['dob'];
                    $accountService->sendmail($email);
                    header("Location: confirm_email.php"); 
                    exit();
                }
            } elseif (preg_match('/^[0-9]{10,15}$/', $contact)) {
                $phone_number = $contact; 
                $email = NULL; 
                header("Location: confirm_phone.php"); 
                exit();          
            } else {
                $email_err = "Email hoặc số điện thoại không hợp lệ.";
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
    <title>Lux - Đăng ký tài khoản</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
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
            color: var(--primary-color);
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
        .form-control {
            width: 100%; 
            max-width: 500px; 
            margin: auto; 
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px;
            border-radius: 4px;
            width: 100%; 
        }

        .btn-primary:hover {
            opacity: 0.9;
            background-color: var(--link-hover-color);
        }

        /* Container cho các trường nhập */
        .form-container {
            border: 1px solid #ddd; /* Đường viền cho container */
            border-radius: 8px; /* Bo góc */
            padding: 20px; /* Padding bên trong */
            margin: auto; /* Căn giữa */
            max-width: 600px; /* Đặt chiều rộng tối đa cho container */
            background-color: #f9f9f9; /* Màu nền nhẹ */
        }
    </style>
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

    <div class="login-container">
        <h4 class="text-center">Đăng ký tài khoản</h4>
        <p class="text-muted text-center">Nhanh chóng và dễ dàng</p>
        <div class="form-container">
        <form id="registerForm" action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="firstName">Họ tên:</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" required>
        <div class="invalid-feedback">
            Vui lòng nhập họ của bạn.
        </div>
    </div>
    <div class="form-group">
        <label for="dob">Ngày sinh:</label>
        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required>
        <div class="invalid-feedback">
            Vui lòng chọn ngày sinh.
        </div>
    </div>
    <div class="form-group">
        <label for="gender">Giới tính:</label>
        <select class="form-control" id="gender" name="gender" required>
            <option value="">Chọn giới tính</option>
            <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'selected' : ''; ?>>Nam</option>
            <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'selected' : ''; ?>>Nữ</option>
            <option value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'selected' : ''; ?>>Khác</option>
        </select>
        <div class="invalid-feedback">
            Vui lòng chọn giới tính.
        </div>
    </div>
    <div class="form-group">
        <label for="contact">Số điện thoại hoặc Email:</label>
        <input type="text" class="form-control <?php echo !empty($email_err) ? 'is-invalid' : ''; ?>" id="contact" name="contact" value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
        <div class="invalid-feedback">
            <?php echo $email_err; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" class="form-control" id="password" name="password" minlength="6" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
        <div class="invalid-feedback">
            Vui lòng nhập mật khẩu ít nhất 6 ký tự.
        </div>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Xác nhận mật khẩu:</label>
        <input type="password" class="form-control <?php echo !empty($confirmPasswordError) ? 'is-invalid' : ''; ?>" id="confirmPassword" name="confirmPassword" value="<?php echo isset($_POST['confirmPassword']) ? htmlspecialchars($_POST['confirmPassword']) : ''; ?>" required>
        <div class="invalid-feedback">
            <?php 
            if (!empty($confirmPasswordError)) {
                echo $confirmPasswordError; 
            }
            ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="registerAccount">Đăng ký</button>
</form>
            <a href="login.php" class="forgot-password d-block text-center my-2">
                <strong>Bạn đã có tài khoản?</strong>
            </a>
        </div>
    </div>
    <script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            var passwordField = form.password;
            var confirmPasswordField = form.confirmPassword;

            // Lắng nghe sự kiện nhập liệu trên trường mật khẩu và xác nhận mật khẩu
            passwordField.addEventListener('input', function() {
                if (passwordField.value === confirmPasswordField.value) {
                    confirmPasswordField.classList.remove('is-invalid');
                    confirmPasswordField.classList.add('is-valid');
                    confirmPasswordField.nextElementSibling.textContent = ''; // Xóa thông báo lỗi
                }
            });

            confirmPasswordField.addEventListener('input', function() {
                if (passwordField.value === confirmPasswordField.value) {
                    confirmPasswordField.classList.remove('is-invalid');
                    confirmPasswordField.classList.add('is-valid');
                    confirmPasswordField.nextElementSibling.textContent = ''; // Xóa thông báo lỗi
                } else {
                    confirmPasswordField.classList.remove('is-valid');
                    confirmPasswordField.classList.add('is-invalid');
                    confirmPasswordField.nextElementSibling.textContent = 'Mật khẩu không khớp.'; // Hiển thị thông báo lỗi
                }
            });
            form.addEventListener('submit', function(event) {
                if (passwordField.value !== confirmPasswordField.value) {
                    event.preventDefault(); // Ngăn form gửi
                    event.stopPropagation();
                    confirmPasswordField.classList.add('is-invalid'); // Đánh dấu trường xác nhận mật khẩu không hợp lệ
                    confirmPasswordField.nextElementSibling.textContent = 'Mật khẩu không khớp.'; // Thêm thông báo lỗi tùy chỉnh
                }
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
    </script>
</body>

</html>
