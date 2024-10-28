<?php
if (isset($_GET['name']) && isset($_GET['email'])) {
    $name = htmlspecialchars($_GET['name']);
    $email = htmlspecialchars($_GET['email']);

    echo "<h2>Dữ liệu nhận qua GET:</h2>";
    echo "Tên: " . $name . "<br>";
    echo "Email: " . $email;
} else {
    echo "Không có dữ liệu được gửi qua GET.";
}
?>
