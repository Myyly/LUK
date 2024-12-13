<?php
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../Controllers/EmotionController.php';
$idUser = $_SESSION['idUser'];
$emotionController = new EmotionController();
$emotions = $emotionController->getAllEmotions();
$user = $accountController->findUserbyId($idUser);
?>
<style>
    .d-flex.mb-3 {
        margin-right: 600px;
    }

    .add-image-button {
        margin-top: 10px;
    }

    .form-control {
        border: none;
    }

    .image-preview-container {
        position: relative;
        width: 48%;
        margin-bottom: 10px;
    }

    .image-preview {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
    }

    .delete-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: white;
        color: black;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        padding: 0;
        box-shadow: none;
    }

    .delete-icon:hover {
        color: black;
        background-color: #dddddd39;
    }

    /* .overlay {
        position: absolute;
        left: 50%;
        top: 10%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px 10px;
        border-radius: 50%;
        font-size: 16px;
    } */

    .button-back {
        margin-left: 10px;
        border: none;
        background-color: white;
    }

    #detailsImagePreviewContainer {
        display: flex;
        flex-wrap: wrap;
        position: relative;
        max-height: 500px;
        overflow-y: auto;
    }

    /* #imagePreviewContainer {
        display: flex;
        flex-wrap: wrap;
        position: relative;
        max-height: 400px;
        overflow-y: auto;
    } */

    #add-image,
    #add-emotion,
    #add-location {
        background-color: white;
        border: none;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        /* Ensure a perfect circle */
        transition: box-shadow 0.3s ease;
    }

    #add-image:hover,
    #add-emotion:hover,
    #add-location:hover {
        background-color: var(--button-submit);
        box-shadow: 0 0 0 3px white, 0 0 0 5px var(--button-submit);
    }

    .search-bar {
        width: 100%;
    }

    /* Set width and style of the modal */
    #emotionsModal .modal-dialog {
        max-width: 600px;
        /* Set modal width to 500px */
    }

    #emotionsModal .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: none;
    }

    #emotionsModal .modal-header .modal-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    #emotionsModal .button-back {
        background: none;
        border: none;
        cursor: pointer;
    }

    #emotionsModal .modal-body {
        padding: 1rem;
    }

    #emotionsModal .search-bar {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    /* Style for the emotion list container */
    #emotionsModal .emotions-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        /* Space between items */
        position: relative;
        max-height: 300px;
        overflow-y: auto;
    }

    /* Style for each emotion item */
    #emotionsModal .emotion-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
        width: 270px;
        /* Make each item take full available width */
        box-sizing: border-box;
    }

    #emotionsModal .emotion-item:hover {
        background-color: var(--button-icon-submit-hover);
        /* Change background on hover */
    }

    #emotionsModal .emotion-icon {
        width: 30px;
        /* Increase size of the circle */
        height: 30px;
        background-color: #e0e0e0;
        /* Gray background for the circle */
        border-radius: 50%;
        /* Circle shape */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        overflow: hidden;
        /* Prevent image from exceeding circle boundaries */
    }

    #emotionsModal .emotion-icon img {
        width: 24px;
        /* Fixed size for the image */
        height: 24px;
        object-fit: contain;
    }

    .button-back {
        display: inline-flex;
        /* Hiển thị dưới dạng inline-flex để căn chỉnh tốt hơn */
        justify-content: center;
        /* Canh giữa nội dung */
        align-items: center;
        /* Canh giữa nội dung theo chiều dọc */
        width: 35px;
        /* Kích thước vòng tròn */
        height: 35px;
        /* Kích thước vòng tròn */
        border-radius: 50%;
        /* Để tạo thành hình tròn */
        background-color: var(--button-submit);
        /* Màu nền, có thể thay đổi */
    }

    .button-back i {
        font-size: 20px;
        /* Kích thước icon */
        color: #7c8492;
        /* Màu sắc của icon */
    }

    .emoji-picker {
        width: 300px;
        background-color: white;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .emoji-category {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .emoji {
        font-size: 24px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .emoji:hover {
        transform: scale(1.2);
    }

    .btn btn-light add-emoji-button {
        margin-right: 200px;
    }

    .post {
        width: 560px;
        height: auto;
    }

    #imagePreviewContainer {
        display: flex;
        flex-wrap: wrap;
        /* Cho phép hình ảnh hiển thị theo nhiều dòng */
        gap: 10px;
        /* Khoảng cách giữa các ảnh */
    }

    .image-preview-container {
        position: relative;
        width: 48%;
        /* Mỗi ảnh chiếm 48% chiều rộng của container */
        overflow: hidden;
        /* Đảm bảo ảnh không bị tràn ra ngoài */
    }

    .image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Đảm bảo ảnh không bị méo và lấp đầy toàn bộ container */
        border-radius: 10px;
        /* Tùy chọn: Thêm bo góc cho ảnh */
    }

    .delete-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }

    .overlay {
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
    }
</style>

<div class="container mt-3">
    <div class="create-post-section">
        <div class="create-post">
            <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" class="user-avatar">
            <input type="text" placeholder="Bạn đang nghĩ gì?" class="post-input" data-bs-toggle="modal" data-bs-target="#createPostModal">
        </div>
    </div>
</div>
<form action="/MVC/Process/profile_process.php" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Tạo bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-3" style="width: 800px;margin-left: 300px;">
                        <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" style="width:50px; height:50px; border-radius:50%;margin-left: 165px !important;">
                        <div class="ms-3">
                            <h6 id="user-name"><strong><?php echo $user->getFull_name() ?></strong>
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
                                <?php include '../icon.php'; ?>
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
                                </>
                                <button class="btn btn-light" id="add-emotion" onclick="openEmotionModal()" type="button">
                                    <i class="fa-regular fa-face-smile fa-xl" style="color: #ffcb3d;"></i>
                                </button>
                                <button class="btn btn-light" id="add-location" type="button">
                                    <i class="fa-solid fa-location-dot fa-xl" style="color: #f94f24;"></i>
                                </button>
                        </div>
                        <button class="btn btn-primary" type="submit" name="btnCreatePost">Đăng</button>
                        <input type="hidden" name="id_icon" id="id_icon">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="post">
    <?php include 'post_content.php'; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="button-back" id="btnBack" type="button">
                            <i class="fa-solid fa-arrow-left fa-lg" style="color: #7c8492;"></i>
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
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="emotionsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="button-back" id="btnBack_E" type="button">
                            <i class="fa-solid fa-arrow-left fa-lg" style="color: #7c8492;"></i>
                        </button>
                        <h5 class="modal-title">Bạn đang cảm thấy thế nào?</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" placeholder="Tìm kiếm" class="search-bar">
                        <!-- <input type="hidden" name="id_icon" id="id_icon"> -->
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
</div>
<!-- </div>
</div>
</div> -->
<script>
    document.getElementById('createPostModal').addEventListener('click', hideEmojiPickerIfClickedOutside);
    let selectedImages = [];
    const createPostModalInstance = new bootstrap.Modal(document.getElementById('createPostModal'));
    const editDetailsModalInstance = new bootstrap.Modal(document.getElementById('editDetailsModal'));
    const emotionModalInstance = new bootstrap.Modal(document.getElementById('emotionsModal'));
    function handleFileUpload(event) {
    const files = Array.from(event.target.files);
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
   // selectedImages = [...selectedImages, ...files];
    // Thêm tệp mới vào `selectedImages`
    selectedImages = selectedImages.concat(files);

    // Làm sạch container hiển thị
    imagePreviewContainer.innerHTML = '';

    // Hiển thị tối đa 4 ảnh
    selectedImages.slice(0, 4).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-preview-container';
            imageContainer.style.position = 'relative';
            imageContainer.style.width = '48%';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview';
            img.style.width = '100%';
            img.style.borderRadius = '8px';
            imageContainer.appendChild(img);

            // Nút xoá ảnh
            const deleteIcon = document.createElement('button');
            deleteIcon.className = 'delete-icon';
            deleteIcon.innerHTML = '<i class="fa-solid fa-x"></i>';
            deleteIcon.style.position = 'absolute';
            deleteIcon.style.top = '5px';
            deleteIcon.style.right = '5px';
            deleteIcon.style.background = 'rgba(255, 255, 255, 0.7)';
            deleteIcon.style.border = 'none';
            deleteIcon.style.borderRadius = '50%';
            deleteIcon.style.cursor = 'pointer';
            deleteIcon.onclick = function () {
                // Xoá ảnh khỏi danh sách và cập nhật
                selectedImages.splice(index, 1);
                updatePreviews();
            };
            imageContainer.appendChild(deleteIcon);

            imagePreviewContainer.appendChild(imageContainer);

            // Overlay nếu có nhiều hơn 4 ảnh
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

    // Cập nhật lại trường input để gửi tệp
    updateInputField();

    // Reset input để có thể chọn lại tệp cũ
    event.target.value = '';
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
    document.getElementById('btnBack').addEventListener('click', function() {
        editDetailsModalInstance.hide();
        createPostModalInstance.show();
        updatePreviews();
    });
    document.getElementById('btnBack_E').addEventListener('click', function() {
        emotionModalInstance.hide(); // Đóng modal "Chỉnh sửa chi tiết"
        createPostModalInstance.show(); // Mở lại modal "Tạo bài viết"
        updatePreviews(); // Cập nhật lại hình ảnh trong modal "Tạo bài viết"
    });
    // Toggle modal visibility
    function toggleEmotionModal() {
        const modal = document.getElementById("emotionModal");
        modal.style.display = modal.style.display === "none" ? "block" : "none";
    }
    // Hàm để chọn cảm xúc
    function selectEmotion(name, image, emotionId) {
        var emotionDisplay = document.getElementById('selected-emotion');
        var emotionText = document.getElementById('user-emotion');
        document.getElementById("id_icon").value = emotionId;
        emotionText.innerHTML = 'đang <img src="/assets/emotions/' + image + '" alt="' + name + '" style="width: 20px; height: 20px; vertical-align: middle; margin: 0 5px;"> cảm thấy <strong>' + name + '</strong>';
        emotionDisplay.style.display = 'flex';
        createPostModalInstance.show();
        emotionModalInstance.hide();
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
</script>