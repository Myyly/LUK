<?php
require_once './MVC/Controllers/Account.php';
$acoountController = new AccountController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registerAccount'])) {
        $email = $_POST['update_name']; ;
        $phone_number = $_POST['update_name'];;
        $password_hash = $_POST['update_name'];;
        $full_name = $_POST['update_name'];;
        $img = $_POST['update_name'];;
        $bio = $_POST['update_name'];;
        $date_of_birth = $_POST['update_name'];;
        $gender = $_POST['update_name'];;
        $create_at = $_POST['update_name'];;
        $update_at = $_POST['update_name'];;
        $last_active = $_POST['update_name'];;
        $status = $_POST['update_name'];;
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

        /* Thay đổi kích thước các input trong phần đăng ký */
        .form-control {
            width: 100%; /* Đặt chiều rộng là 100% của phần tử cha */
            max-width: 500px; /* Tối đa chiều rộng là 500px */
            margin: auto; /* Căn giữa các trường nhập */
        }

        /* Nút đăng ký */
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px;
            border-radius: 4px;
            width: 100%; /* Đặt chiều rộng 100% */
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
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập họ của bạn.
                    </div>
                </div>
                <div class="form-group">
                    <label for="dob">Ngày sinh:</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                    <div class="invalid-feedback">
                        Vui lòng chọn ngày sinh.
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                    <div class="invalid-feedback">
                        Vui lòng chọn giới tính.
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact">Số điện thoại hoặc Email:</label>
                    <input type="text" class="form-control" id="contact" name="contact" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập email hoặc số điện thoại hợp lệ.
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                    <div class="invalid-feedback">
                        Vui lòng nhập mật khẩu ít nhất 6 ký tự.
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Xác nhận mật khẩu:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" minlength="6" required>
                    <div class="invalid-feedback">
                        Mật khẩu xác nhận không khớp.
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
                // Lấy tất cả các form cần xác thực
                var forms = document.getElementsByClassName('needs-validation');
                // Duyệt qua các form và ngăn chặn gửi nếu không hợp lệ
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        // Kiểm tra form hợp lệ
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        // Thêm lớp was-validated để hiển thị trạng thái xác thực
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>
