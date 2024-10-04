<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux - Đăng nhập hoặc đăng ký</title>
    <link rel="icon" href="/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-GmPkdT/zrYr4b6o/nBHSY7n8r8S0w/tH2Gkq5CZL/0lE/0hQg4RlDm8cg09wxglg" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-Cueo4u5zQxWx2e6r7SmM1dXMBMbRkPFDLZSyD+fl/zMXsPTxtMheRP8dGKe5zC4x" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/variables.css">
    <link rel="stylesheet" href="/CSS/account.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <div class="lux-header text-center py-3">
        LUX
    </div>
    <div class="login-container">
        <form action="login.php" method="POST" class="needs-validation" novalidate>
            <input type="email" name="email" placeholder="Email hoặc số điện thoại" required class="form-control mb-3">
            <input type="password" name="password" placeholder="Password" required class="form-control mb-3">
            <button type="submit" class="login-btn btn btn-primary btn-block">Đăng nhập</button>
        </form>
        <a href="#" class="forgot-password d-block text-center my-2">
            <strong> Quên mật khẩu? </strong>
        </a>
        <div class="divider my-3"></div>
    <!-- ///////////////////////////////////////////                           CREATE NEW ACCOUNT                /////////////////////////////////////////// //////////////////////////////////////// -->
        <button class="create-btn btn btn-secondary btn-block" data-toggle="modal" data-target="#registerModal">Tạo tài khoản mới</button>
                <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="registerModalLabel">Đăng ký tài khoản</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="registerForm" action="register.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <p class="text-muted">Nhanh chóng và dễ dàng</p>
                            <div class="form-group">
                                <label for="firstName">Họ:</label>
                                <input type="text" class="form-control <?php echo isset($errors['firstName']) ? 'is-invalid' : ''; ?>" id="firstName" name="firstName" value="<?php echo isset($form_data['firstName']) ? htmlspecialchars($form_data['firstName']) : ''; ?>" required>
                                <?php if (isset($errors['firstName'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['firstName']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập họ của bạn.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Tên:</label>
                                <input type="text" class="form-control <?php echo isset($errors['lastName']) ? 'is-invalid' : ''; ?>" id="lastName" name="lastName" value="<?php echo isset($form_data['lastName']) ? htmlspecialchars($form_data['lastName']) : ''; ?>" required>
                                <?php if (isset($errors['lastName'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['lastName']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập tên của bạn.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="dob">Ngày sinh:</label>
                                <input type="date" class="form-control <?php echo isset($errors['dob']) ? 'is-invalid' : ''; ?>" id="dob" name="dob" value="<?php echo isset($form_data['dob']) ? htmlspecialchars($form_data['dob']) : ''; ?>" required>
                                <?php if (isset($errors['dob'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['dob']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn ngày sinh.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="gender">Giới tính:</label>
                                <select class="form-control <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" id="gender" name="gender" required>
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                    <option value="Nữ" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="Khác" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                </select>
                                <?php if (isset($errors['gender'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['gender']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn giới tính.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="contact">Số điện thoại hoặc Email:</label>
                                <input type="email" class="form-control <?php echo isset($errors['contact']) ? 'is-invalid' : ''; ?>" id="contact" name="contact" value="<?php echo isset($form_data['contact']) ? htmlspecialchars($form_data['contact']) : ''; ?>" required>
                                <?php if (isset($errors['contact'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['contact']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập email hoặc số điện thoại hợp lệ.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" id="password" name="password" minlength="6" required>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['password']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập mật khẩu ít nhất 6 ký tự.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Xác nhận mật khẩu:</label>
                                <input type="password" class="form-control <?php echo isset($errors['confirmPassword']) ? 'is-invalid' : ''; ?>" id="confirmPassword" name="confirmPassword" minlength="6" required>
                                <?php if (isset($errors['confirmPassword'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['confirmPassword']; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="invalid-feedback">
                                        Mật khẩu xác nhận không khớp.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="registerAccount">Đăng ký</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        </div>
                        <a href="#" class="forgot-password d-block text-center my-2">
    <strong>Bạn đã có tài khoản?</strong>
</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer text-center my-4">
        <p><a href="#">Tạo trang</a> dành cho người nổi tiếng, thương hiệu hoặc doanh nghiệp.</p>
    </div>
    <?php if (!empty($errors)): ?>
    <script>
        $(document).ready(function(){
            $('#registerModal').modal('show');
        });
    </script>
    <?php endif; ?>
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
