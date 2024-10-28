<?php
if (isset($_POST['name']) && isset($_POST['email'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    echo "<h2>Dữ liệu nhận qua POST:</h2>";
    echo "Tên: " . $name . "<br>";
    echo "Email: " . $email;
} else {
    echo "Không có dữ liệu được gửi qua POST.";
}
?>
