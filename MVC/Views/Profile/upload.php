<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['images'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        echo '<h3>Kết quả tải lên:</h3><ul>';
        // Kiểm tra và xử lý tất cả ảnh được chọn
        foreach ($_FILES['images']['name'] as $index => $fileName) {
            $fileTmpName = $_FILES['images']['tmp_name'][$index];
            $fileSize = $_FILES['images']['size'][$index];
            $fileError = $_FILES['images']['error'][$index];

            if ($fileError === UPLOAD_ERR_OK) {
                // Kiểm tra xem file có thể di chuyển được không
                $uploadPath = $uploadDir . basename($fileName);
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    echo '<li>' . htmlspecialchars($fileName) . ' đã được tải lên thành công! (' . $fileSize . ' bytes)</li>';
                } else {
                    echo '<li>Không thể tải lên file ' . htmlspecialchars($fileName) . '.</li>';
                }
            } else {
                echo '<li>Lỗi khi tải lên file ' . htmlspecialchars($fileName) . '. Mã lỗi: ' . $fileError . '</li>';
            }
        }
        echo '</ul>';
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Ảnh</title>
    <style>
        /* Các style cho ảnh preview và nút xóa */
        body { font-family: Arial, sans-serif; margin: 20px; }
        .preview-container { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .preview { position: relative; width: 120px; height: 120px; border: 1px solid #ccc; border-radius: 5px; overflow: hidden; }
        .preview img { width: 100%; height: 100%; object-fit: cover; }
        .remove-btn { position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; font-size: 14px; }
        .upload-btn { display: block; margin: 20px auto; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .upload-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Tải lên ảnh</h1>

    <!-- Form Upload -->
    <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
        <input type="file" id="photoInput" name="images[]" accept="image/*" multiple style="display: none;">
        <button type="button" id="addImageButton" class="upload-btn">Thêm Ảnh</button>

        <!-- Khu vực hiển thị ảnh xem trước -->
        <div id="imagePreviewContainer" class="preview-container"></div>

        <button type="submit" class="upload-btn">Tải lên tất cả</button>
    </form>

    <script>
        const photoInput = document.getElementById("photoInput");
        const addImageButton = document.getElementById("addImageButton");
        const imagePreviewContainer = document.getElementById("imagePreviewContainer");
        let selectedImages = [];

        // Khi nhấn nút Thêm Ảnh, mở hộp chọn file
        addImageButton.addEventListener("click", () => {
            photoInput.click();
        });

        // Xử lý khi chọn ảnh
        photoInput.addEventListener("change", function (event) {
            const files = Array.from(event.target.files);

            // Thêm ảnh mới vào danh sách và hiển thị
            files.forEach((file) => {
                selectedImages.push(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    // Tạo vùng preview
                    const previewDiv = document.createElement("div");
                    previewDiv.classList.add("preview");

                    // Tạo thẻ img hiển thị ảnh
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    previewDiv.appendChild(img);

                    // Tạo nút xóa ảnh
                    const removeButton = document.createElement("button");
                    removeButton.innerHTML = "×";
                    removeButton.classList.add("remove-btn");

                    // Xóa ảnh khi nhấn nút xóa
                    removeButton.addEventListener("click", () => {
                        const index = selectedImages.indexOf(file);
                        if (index > -1) {
                            selectedImages.splice(index, 1);
                        }
                        previewDiv.remove();
                    });

                    previewDiv.appendChild(removeButton);
                    imagePreviewContainer.appendChild(previewDiv);
                };

                reader.readAsDataURL(file);
            });

            // Reset giá trị input để có thể chọn lại cùng file
            event.target.value = "";
        });
    </script>
</body>
</html>
