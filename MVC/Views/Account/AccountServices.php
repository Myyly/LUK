<?php 
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
require __DIR__ . '/../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
class AccountService {
    public function __construct() {
        // Nếu cần thiết, có thể khởi tạo các giá trị mặc định ở đây.
    }


function generateRandomCode() {
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}
function sendmail($email) {
    $code = $this->generateRandomCode();
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
    $fromName = 'LUX';
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Mã Xác Nhận";
    $mail->Body = "L - $code là mã xác nhận LUX của bạn";
    return $mail->send(); // Trả về true hoặc false
}
}
?>