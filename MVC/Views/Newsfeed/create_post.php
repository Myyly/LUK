
<div class="create-post-section">
    <div class="create-post">
        <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" class="user-avatar">
        <input type="text" placeholder="Bạn đang nghĩ gì?" class="post-input" data-bs-toggle="modal" data-bs-target="#createPostModal">
    </div>
</div>
                                                            <!-- TẠO BÀI BIẾT -->

<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center position-relative">
                <h5 class="modal-title mx-auto" id="createPostModalLabel">Tạo bài viết</h5>
                <form action="MVC/Process/newsfeed_process.php" method="post" class="position-absolute end-0">
                    <button type="submit" class="btn-close" name="btnClosePost" style="margin-left: -50px;"></button>
                </form>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3" style="max-width: 500px;">
                    <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" style="width: 50px; height: 50px; border-radius: 50%; margin-left: 10px;">
                    <div class="ms-3">
                        <h6 id="user-name" style="display: flex; align-items: center;">
                            <strong><?php echo $user->getFull_name() ?></strong>
                            <span id="user-emotion" style="color: black;"></span>
                        </h6>
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Công khai
                        </button>
                    </div>
                    <div id="selected-emotion" class="ms-3" style="display: none;">
                        <img id="emotion-icon" src="" alt="">
                    </div>
                </div>
                <textarea class="form-control" rows="2" placeholder="Bạn đang nghĩ gì?" name="PostContent"></textarea>
                <div>
                    <div id="imagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; position: relative;">
                        <img id="imagePreview" class="image-preview">
                        <button class="delete-icon" onclick="removeImage()" style="display: none;">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <div>
                        <button class="btn btn-light add-image-button" onclick="document.getElementById('photoInput').click()" type="button">
                            <i class="fas fa-photo-video"></i> Thêm ảnh
                        </button>
                        <button class="btn btn-light add-image-button" onclick="openEditDetailsModal()" type="button">
                            <i class="fa-solid fa-pen"></i> Chỉnh sửa chi tiết
                        </button>
                        <button class="btn btn-light add-image-button" style="margin-left: 400px;" onclick="toggleEmojiPicker()" type="button">
                            <i class="fa-regular fa-face-smile"></i>
                        </button>
                        <div class="emoji-picker" type="button" id="emojiPicker" style="display: none; position: absolute; bottom: 60px; left: 480px; max-height: 230px; overflow-y: auto;">
                            <?php include 'MVC/Views/icon.php'; ?>
                        </div>
                    </div>
                </div>
                <input type="file" id="photoInput" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFileUpload(event)">
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <button class="btn btn-light" onclick="document.getElementById('photoInput').click()" id="add-image" type="button">
                            <i class="fa-solid fa-image fa-xl" style="color: #56c85d;"></i>
                            </s>
                            <button class="btn btn-light" id="add-emotion" onclick="openEmotionModal()" type="button">
                                <i class="fa-regular fa-face-smile fa-xl" style="color: #ffcb3d;"></i>
                            </button>
                            <button class="btn btn-light" id="add-location" type="button">
                                <i class="fa-solid fa-location-dot fa-xl" style="color: #f94f24;"></i>
                            </button>
                    </div>
                    <form action="/MVC/Process/photo_process.php" method="POST" enctype="multipart/form-data">
                        <button class="btn btn-primary" type="submit" name="btnCreatePost">Đăng</button>
                        <input type="hidden" name="id_icon" id="id_icon">
                        <input type="file" id="photoInput" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFileUpload(event)">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->
</form>
                                                                    <!-- CHI TIẾT ẢNH -->
<form method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="button-back" id="btnBack" type="button" onclick="closeEditDetailModal()"">
                        <i class=" fa-solid fa-arrow-left fa-lg" style="color: #7c8492;"></i>
                    </button>
                    <h5 class="modal-title">Chỉnh sửa chi tiết</h5>
                </div>
                <div class="modal-body">
                    <div id="detailsImagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                    <button class="btn btn-light" onclick="document.getElementById('detailsPhotoInput').click()" type="button">
                        <i class="fas fa-photo-video"></i> Thêm ảnh
                    </button>
                    <input type="file" id="detailsPhotoInput" accept="image/*" style="display: none;" onchange="handleFileUploadDetail(event)">
                </div>
            </div>
        </div>
    </div>
</form>
<!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

                                                    <!-- MODAL EMOTIONS -->
<form method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="emotionsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="button-back" id="btnBack_E" type="button" onclick="closeEmotionModal()">
                        <i class="fa-solid fa-arrow-left fa-lg" style="color: #7c8492;"></i>
                    </button>
                    <h5 class="modal-title">Bạn đang cảm thấy thế nào?</h5>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Tìm kiếm" class="search-bar">
                    <div class="emotions-list">
                        <?php foreach ($emotions as $emotion) { ?>
                            <div class="emotion-item" onclick="selectEmotion('<?php echo $emotion->getName(); ?>', '<?php echo $emotion->getImage(); ?>', '<?php echo $emotion->getId(); ?>')">
                                <img src="/assets/emotions/<?php echo $emotion->getImage() ?>" alt="<?php echo $emotion->getName() ?>" class="emotion-icon">
                                <span><?php echo $emotion->getName() ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- -------------------------------------------------------------------------------------------------------------------------------------------------- -->

<script>
    document.getElementById('createPostModal').addEventListener('click', hideEmojiPickerIfClickedOutside);
    let selectedImages = [];
    const createPostModalInstance = new bootstrap.Modal(document.getElementById('createPostModal'));
    const editDetailsModalInstance = new bootstrap.Modal(document.getElementById('editDetailsModal'));
    const emotionModalInstance = new bootstrap.Modal(document.getElementById('emotionsModal'));

    // function handleFileUpload(event) {
    //     const files = Array.from(event.target.files);
    //     const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    //     selectedImages = selectedImages.concat(files);
    //     imagePreviewContainer.innerHTML = '';

    //     // Display up to 4 selected images
    //     selectedImages.slice(0, 4).forEach((file, index) => {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const imageContainer = document.createElement('div');
    //             imageContainer.className = 'image-preview-container';
    //             imageContainer.style.position = 'relative';
    //             imageContainer.style.width = '48%';

    //             const img = document.createElement('img');
    //             img.src = e.target.result;
    //             img.className = 'image-preview';
    //             img.style.width = '100%';
    //             imageContainer.appendChild(img);

    //             // Delete button for each image
    //             const deleteIcon = document.createElement('button');
    //             deleteIcon.className = 'delete-icon';
    //             deleteIcon.innerHTML = '<i class="fa-solid fa-x"></i>';
    //             deleteIcon.onclick = function() {
    //                 // Remove image from selectedImages and update previews
    //                 selectedImages.splice(index, 1);
    //                 updatePreviews(); // Re-run preview update
    //             };
    //             imageContainer.appendChild(deleteIcon);

    //             imagePreviewContainer.appendChild(imageContainer);
    //         };
    //         reader.readAsDataURL(file);
    //     });

    //     // Display overlay if more than 4 images
    //     if (selectedImages.length > 4) {
    //         const overlay = document.createElement('div');
    //         overlay.className = 'overlay';
    //         overlay.innerText = `+${selectedImages.length - 4}`;
    //         overlay.style = `
    //         position: absolute;
    //         left: 73%;
    //         top: 90%;
    //         transform: translate(-50%, -50%);
    //         background: rgba(0, 0, 0, 0.6);
    //         color: white;
    //         padding: 10px;
    //         width: 100px;
    //         height: 100px;
    //         text-align: center;
    //         line-height: 80px;
    //         font-size: 36px;
    //         z-index: 3;
    //         border-radius: 10px;
    //     `;

    //         imagePreviewContainer.appendChild(overlay);
    //     }

    //     // Reset the input to allow re-selection of the same files if needed
    //     event.target.value = '';
    // }
    function handleFileUpload(event) {
    const files = Array.from(event.target.files);
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    selectedImages = selectedImages.concat(files);
    imagePreviewContainer.innerHTML = '';

    // Display up to 4 selected images
    selectedImages.slice(0, 4).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-preview-container';
            imageContainer.style.position = 'relative';
            imageContainer.style.width = '48%';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview';
            img.style.width = '100%';
            imageContainer.appendChild(img);

            // Delete button for each image
            const deleteIcon = document.createElement('button');
            deleteIcon.className = 'delete-icon';
            deleteIcon.innerHTML = '<i class="fa-solid fa-x"></i>';
            deleteIcon.onclick = function() {
                // Remove image from selectedImages and update previews
                selectedImages.splice(index, 1);
                updatePreviews(); // Re-run preview update
            };
            imageContainer.appendChild(deleteIcon);

            imagePreviewContainer.appendChild(imageContainer);

            // If it's the 4th image and there are more than 4 images, add overlay
            if (index === 3 && selectedImages.length > 4) {
                const overlay = document.createElement('div');
                overlay.className = 'overlay';
                overlay.innerText = `+${selectedImages.length - 4}`;
                overlay.style = `
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.6);
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 36px;
                    z-index: 3;
                    border-radius: 10px;
                `;
                imageContainer.appendChild(overlay);
            }
        };
        reader.readAsDataURL(file);
    });

    // Reset the input to allow re-selection of the same files if needed
    event.target.value = '';
}


    function updatePreviews() {
        const event = new Event('change');
        document.getElementById('photoInput').dispatchEvent(event);
    }

    function openEditDetailsModal() {
        updateEditDetailsPreview(); // Cập nhật ảnh trong modal "Chỉnh sửa chi tiết"
        editDetailsModalInstance.show(); // Mở modal "Chỉnh sửa chi tiết"
        createPostModalInstance.hide(); // Đóng modal "Tạo bài viết"
    }



    function openEmotionModal() {
        emotionModalInstance.show(); // Mở modal "Chỉnh sửa chi tiết"
        createPostModalInstance.hide();
    }

    function updateEditDetailsPreview() {
        const detailsImagePreviewContainer = document.getElementById('detailsImagePreviewContainer');
        detailsImagePreviewContainer.innerHTML = ''; // Xóa nội dung cũ

        selectedImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageContainer = document.createElement('div');
                imageContainer.className = 'image-preview-container';
                imageContainer.style.position = 'relative';
                imageContainer.style.width = '32%'; // Mỗi ảnh chiếm 32% chiều rộng để tạo 3 ảnh mỗi hàng

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';
                img.style.width = '100%'; // Để ảnh phù hợp với bố cục
                imageContainer.appendChild(img);

                // Nút xóa cho từng ảnh
                const deleteIcon = document.createElement('button');
                deleteIcon.className = 'delete-icon';
                deleteIcon.innerHTML = '<i class="fa-solid fa-x"></i>';
                deleteIcon.onclick = function() {
                    selectedImages.splice(index, 1);
                    updateEditDetailsPreview(); // Cập nhật lại hiển thị sau khi xóa ảnh
                };
                imageContainer.appendChild(deleteIcon);

                detailsImagePreviewContainer.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    function updatePreviews() {
        handleFileUpload({
            target: {
                files: []
            }
        }); // Cập nhật modal "Tạo bài viết"
        updateEditDetailsPreview(); // Cập nhật modal "Chỉnh sửa chi tiết"
    }

    function handleFileUploadDetail(event) {
        const files = Array.from(event.target.files);
        const imagePreviewContainer = document.getElementById('detailsImagePreviewContainer');

        // Thêm ảnh mới vào mảng selectedImages
        selectedImages = selectedImages.concat(files);

        // Xóa nội dung hiện tại để cập nhật lại danh sách ảnh đã chọn
        imagePreviewContainer.innerHTML = '';

        // Duyệt qua selectedImages và hiển thị chúng
        selectedImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageContainer = document.createElement('div');
                imageContainer.className = 'image-preview-container';
                imageContainer.style.position = 'relative';
                imageContainer.style.width = '32%'; // Mỗi ảnh chiếm 32% chiều rộng để tạo 3 ảnh mỗi hàng

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';
                img.style.width = '100%'; // Để ảnh phù hợp với bố cục
                imageContainer.appendChild(img);

                // Nút xóa cho từng ảnh
                const deleteIcon = document.createElement('button');
                deleteIcon.className = 'delete-icon';
                deleteIcon.innerHTML = '<i class="fa-solid fa-x"></i>';
                deleteIcon.onclick = function() {
                    // Xóa ảnh khỏi mảng selectedImages khi bấm x
                    selectedImages.splice(index, 1);
                    updatePreviews(); // Cập nhật hiển thị sau khi xóa ảnh
                };
                imageContainer.appendChild(deleteIcon);

                imagePreviewContainer.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });

        // Reset input file để cho phép chọn lại cùng file
        event.target.value = '';
    }

    function toggleEmotionModal() {
        const modal = document.getElementById("emotionModal");
        modal.style.display = modal.style.display === "none" ? "block" : "none";
    }

    function selectEmotion(name, image, emotionId) {
        var emotionDisplay = document.getElementById('selected-emotion');
        var emotionText = document.getElementById('user-emotion');
        document.getElementById("id_icon").value = emotionId;
        emotionText.innerHTML = '<span style="white-space: nowrap;">đang <img src="/assets/emotions/' + image + '" alt="' + name + '" style="width: 20px; height: 20px; vertical-align: middle; margin: 0 5px; max-width: 200px;"> cảm thấy&nbsp;<strong>' + name + '</strong></span>';
        emotionDisplay.style.display = 'flex'; // Hiển thị cảm xúc đã chọn
        createPostModalInstance.show(); // Hiển thị modal tạo bài viết
        emotionModalInstance.hide(); // Ẩn modal chọn cảm xúc
    }


    // Function to collect image files from the preview container and send them as base64
    function getImageFiles() {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imageFiles = [];
        const images = imagePreviewContainer.getElementsByTagName('img');

        for (let img of images) {
            // Chỉ lấy đường dẫn tệp ảnh từ thẻ <img> và đẩy vào mảng imageFiles
            // Thay vì img.src, bạn có thể tải tệp ảnh từ <input type="file"> nếu bạn đang sử dụng để chọn ảnh
            const fileInput = document.getElementById('photoInput'); // Giả sử bạn có một input để chọn ảnh
            if (fileInput && fileInput.files.length > 0) {
                for (let file of fileInput.files) {
                    imageFiles.push(file);
                }
            }
        }
        return imageFiles;
    }
    function closeEditDetailModal() {
        editDetailsModalInstance.hide(); // Đóng modal "Chỉnh sửa chi tiết"
        createPostModalInstance.show();
        updatePreviews(); // Mở modal "Tạo bài viết"
    }

    function closeEmotionModal() {
        emotionModalInstance.hide(); // Đóng modal "Chỉnh sửa chi tiết"
        createPostModalInstance.show(); // Mở modal "Tạo bài viết"
    }
</script>