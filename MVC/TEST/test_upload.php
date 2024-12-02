<?php
// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadedFiles = [];
    $uploadDirectory = 'upload/';
    $errors = [];
    
    // Kiểm tra nếu có file tải lên
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['images']['name'][$key]);
            $fileSize = $_FILES['images']['size'][$key];
            $fileTmp = $_FILES['images']['tmp_name'][$key];
            $targetFile = $uploadDirectory . $fileName;

            // Kiểm tra định dạng file (chỉ cho phép ảnh)
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "$fileName không phải là ảnh hợp lệ!";
                continue;
            }

            // Kiểm tra kích thước file (giới hạn 5MB)
            if ($fileSize > 5 * 1024 * 1024) {
                $errors[] = "$fileName vượt quá kích thước cho phép!";
                continue;
            }

            // Di chuyển file đến thư mục upload
            if (move_uploaded_file($fileTmp, $targetFile)) {
                $uploadedFiles[] = $fileName;
            } else {
                $errors[] = "Không thể tải lên $fileName.";
            }
        }
    } else {
        $errors[] = "Không có file nào được chọn.";
    }

    // Hiển thị kết quả
    echo "<h3>Kết quả tải lên</h3>";
    if (!empty($uploadedFiles)) {
        echo "Số lượng ảnh đã tải lên: " . count($uploadedFiles) . "<br>";
        echo "Tên các ảnh: <pre>" . print_r($uploadedFiles, true) . "</pre>";
    }

    if (!empty($errors)) {
        echo "<h4>Lỗi:</h4>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tải lên nhiều ảnh</title>
</head>
<body>
    <h2>Chọn nhiều ảnh để tải lên</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple>
        <button type="submit">Tải lên</button>
    </form>
</body>
</html>