<style>
    .modal-body-comment {
        padding: 15px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .post-images {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-height: 400px;
        overflow-y: auto;
    }

    .post-image-wrapper {
        position: relative;
        flex: 1 1 calc(25% - 5px);
        height: 100%;
        margin-right: 5px;
        overflow: hidden;
    }

    .post-image {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .image-overlay {
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
        font-size: 24px;
        cursor: pointer;
    }

    .post-header-modal {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        /* Ensure no additional margin */
        padding: 0;
        /* Remove padding for tighter fit */
        margin-top: 5px;
    }

    .post-info-modal {
        margin-left: 10px;
        font-size: 14px;
        color: #555;
        line-height: 1.4;

    }

    .post-status-modal {
        padding: 2px;
        /* Reduced padding for compact spacing */
        font-size: 16px;
        color: #333;
        background-color: #ffff;
        border-radius: 8px;
        margin-top: 5px;
        /* Small space between header and content */
        /* line-height: 1.6; */
        /* box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); */
        overflow-wrap: break-word;
        max-width: 100%;
        max-height: 100%;
    }

    .photo-stats-modal {
        display: flex;
        /* Sử dụng flex để căn chỉnh các phần tử ngang hàng */
        align-items: center;
        /* Căn giữa dọc */
        margin: 10px 20px;
        /* Thêm khoảng cách bên ngoài */
        gap: 30px;
        /* Khoảng cách giữa các icon */

    }

    .photo-stats-modal span {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .photo-stats-modal img {
        margin-right: 5px;
    }

    .photo-actions-modal {
        display: flex;
        justify-content: space-around;
        /* Phân bố đều các nút */
        /* margin: 10px 20px; */
        /* gap: 20px; */
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        height: 40px;
    }

    .photo-actions-modal button {
        display: flex;
        align-items: center;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: #555;
        transition: color 0.2s ease;
    }

    .photo-actions-modal button:hover {
        color: #000;
        /* Đổi màu khi hover */
    }

    .photo-actions-modal i {
        margin-right: 10px;
        /* Khoảng cách giữa icon và chữ */
    }

    .modal-footer {
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Khoảng cách giữa các phần tử bình luận */
        padding: 10px;
        /* Thêm khoảng cách nội dung bên trong footer */
        width: 100%;
        /* Trải dài toàn bộ modal */
        box-sizing: border-box;
        /* Đảm bảo padding không ảnh hưởng đến kích thước */
        border-top: 1px solid #ddd;
        /* Đường kẻ phân cách với nội dung bên trên */
    }

    .comment {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        /* Khoảng cách giữa avatar và nội dung */
        margin: 10px;
        /* Thêm khoảng cách giữa bình luận và viền modal */
        padding: 5px 0;
        /* Thêm không gian bên trong bình luận */
    }


    .comment-user {
        font-weight: bold;
        margin-right: 5px;
    }

    .comment p {
        margin: 0;
        color: #333;
        word-break: break-word;
    }

    .comment-section-modal {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 10px;
        width: 100%;
        /* Trải dài theo modal */
    }

    .comment-input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 14px;
        resize: none;
        outline: none;
        background-color: #f5f5f5;
        /* Để input bình luận trải dài toàn bộ */
        width: 100%;
        box-sizing: border-box;

        /* Đảm bảo padding không ảnh hưởng đến kích thước */
    }

    .comment-input::placeholder {
        color: #aaa;
    }

    .icons {
        display: flex;
        gap: 8px;
        color: #888;
    }

    .icons i {
        cursor: pointer;
        transition: color 0.3s ease;
    }

    /* .icons i:hover {
        color: #555;
    } */

    button[name="addComment"] {
        background: none;
        border: none;
        color: #555;
        font-size: 20px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    button[name="addComment"]:hover {
        color: #000;
    }

    .photo-actions-modal button:active,
    .photo-actions-modal button.liked {
        color: var(--primary-color);
        /* Màu khi nhấn */
    }

    .photo-actions-modal button i {
        margin-right: 5px;
    }

    .photo-actions-modal button:hover {
        color: var(--primary-color);
    }

    .delete-comment {
        border: none;
        background-color: white;
    }

    .delete-comment i {
        color: var(--icon-color);
    }

    .delete-comment i:hover {
        color: red;
    }

    /* Đặt z-index cho nested modals */
    .modal-header-detail-comment {
        /* margin-left: 200px; */
        text-align: center;
        margin-top: 10px;
    }

    .btn-close {
        margin-left: 730px;
        margin-top: 5px;
    }

    /* Tùy chỉnh chung cho modal */


    .custom-modal .modal-header {
        text-align: center !important;
        color: #f5f5f5;
        background-color: #dc3545;
        /* Màu nền nhẹ cho tiêu đề */
        border-bottom: 1px solid #ddd;
        /* Đường kẻ dưới tiêu đề */
    }

    .custom-modal .modal-title {
        text-align: center !important;
        font-size: 18px;
        font-weight: bold;
    }

    .custom-modal .modal-body {
        text-align: center !important;
        font-size: 16px;
        color: #333;
        /* padding: 20px 15px; */
    }

    /* Căn chỉnh hàng ngang cho nút */
    .custom-modal .modal-body form {
        display: flex;
        /* Sử dụng flexbox */
        justify-content: space-between;
        /* Khoảng cách đều giữa các nút */
        align-items: center;
        /* Căn giữa dọc */
        gap: 10px;
        /* Khoảng cách giữa các nút */
    }

    /* Tùy chỉnh nút */
    .custom-modal .modal-body button {
        flex: 1;
        /* Đảm bảo các nút chia đều không gian */
        padding: 10px 15px;
        /* Tăng kích thước nút */
        font-size: 14px;
        border-radius: 5px;
    }

    /* Màu cho nút Xóa */
    .custom-modal .btn-danger {
        background-color: #dc3545;
        border: none;
        color: white;
    }

    .custom-modal .btn-danger:hover {
        background-color: #c82333;
    }

    /* Màu cho nút Hủy */
    .custom-modal .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
    }

    .custom-modal .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
<script>
    var postId = localStorage.getItem("open_modal");
    if (postId) {
        var detailCommentModal = new bootstrap.Modal(document.getElementById('detailCommentModal_' + postId));
        detailCommentModal.show();
        localStorage.removeItem("open_modal");
    }
</script>
<a href="javascript:void(0);"
    data-bs-toggle="modal"
    data-bs-target="#detailCommentModal_<?php echo $post->getPost_id(); ?>" class="custom-link">
    <?php echo $post->getComment_count(); ?> bình luận
</a>

<div class="modal fade" id="detailCommentModal_<?php echo $post->getPost_id(); ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header-detail-comment" style="border-bottom: 1px solid #ddd;">
                <form action="/MVC/Process/photo_process.php" method="POST">
                    <?php $id = $post->getUser_id(); ?>
                    <button type="submit" class="btn-close" name="btnClosed">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </button>
                </form>
                <?php
                $name = $accountController->findUserbyId($post->getUser_id())->getFull_name();
                $img = $accountController->findUserbyId($post->getUser_id())->getProfile_picture_url();
                $profileLink = ($id == $idUser)
                    ? "profile.php?id=$idUser"
                    : "profile_friend.php?idFriend=$id";
                if ($img) {
                    $commentAvatarSrc = 'data:image/jpeg;base64,' . base64_encode($img);
                } else {
                    $commentAvatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
                }
                ?>
                <h5 class="modal-title" id="modalLabel" style="color: #000;margin-top: -10px;">Bài viết của <?php echo $name; ?></h5>
            </div>
            <div class="modal-body-comment">
                <div class="post-content-modal">
                    <div class="post-header-modal">

                        <a href="<?php echo $profileLink; ?>">
                            <img src="<?php echo $commentAvatarSrc; ?>" alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px;">
                        </a>
                        <div class="post-info-modal">
                            <strong><?php echo $name ?></strong>
                            <p><?php echo $time; ?></p>
                        </div>
                    </div>
                    <div class="post-status-modal">
                        <p><?php echo $post->getContent(); ?></p>
                    </div>
                    <div class="post-images d-flex">
                        <?php
                        $images = $postImageController->getAllImagesOfPost($post->getPost_id());
                        $totalImages = count($images);
                        foreach ($images as $index => $image):
                            if ($index >= 4) break;
                            $imgBlob = $image->getImage_data();
                            if ($imgBlob):
                                $base64Image = base64_encode($imgBlob);
                                $imgSrc = 'data:image/jpeg;base64,' . $base64Image;
                        ?>
                                <div class="post-image-wrapper" style="position: relative; flex: 1 1 calc(25% - 5px); height: 100%; margin-right: 5px; overflow: hidden;">
                                    <img class="post-image" src="<?php echo $imgSrc ?>" alt="Post Image"
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                        onclick="openImageOverlay('<?php echo $image->getImage_id(); ?>', '<?php echo $post->getPost_id(); ?>')">

                                    <?php if ($index === 3 && $totalImages > 4): ?>
                                        <div class="image-overlay" data-url="photo.php?lpid=<?php echo $image->getImage_id(); ?>&set=pcb.<?php echo $post->getPost_id(); ?>"
                                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); color: white; 
                                        display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer;">
                                            +<?php echo $totalImages - 4; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
            <div class="photo-stats-modal">
                <span>
                    <img src="/assets/emotions/heart.png" alt="like">
                    <span class="likes-count" id="likes-count-comment<?php echo $post->getPost_id(); ?>">
                        <?php echo $post->getLike_count(); ?>
                    </span>
                </span>
                <span style="margin-left: 520px;">
                    <i class="fa-solid fa-comment" style=" margin-right: 5px;"></i>
                    <?php echo $post->getComment_count(); ?>
                </span>
                <span style="margin-left: 30px;">
                    <i class="fa-solid fa-share" style=" margin-right: 5px;"></i>
                    <?php echo $post->getShare_count(); ?>
                </span>
            </div>
            <?php
            $isLiked = $likeController->isPostLikedByUser($idUser, $post->getPost_id());
            ?>
            <div class="photo-actions-modal">
                <button onclick="toggleLikeComment(this, <?php echo $post->getPost_id(); ?>)" type="button" class="<?php echo $isLiked ? 'liked' : ''; ?>">
                    <i class="fa-solid fa-heart fa-lg"></i> Thích
                </button>
                <button type="button">
                    <i class="fa-regular fa-comment fa-lg"></i> Bình luận
                </button>
                <button type="button">
                    <i class="fa-solid fa-share fa-lg"></i> Chia sẻ
                </button>
            </div>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <?php
                    $userIdComment = $comment->getUser_cmt_id();
                    $userComment = $accountController->findUserbyId($userIdComment);
                    $commentAvatar = $userComment->getProfile_picture_url();
                    if ($commentAvatar) {
                        $commentAvatarSrc = 'data:image/jpeg;base64,' . base64_encode($commentAvatar);
                    } else {
                        $commentAvatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
                    }
                    $profileLink = ($userIdComment == $idUser)
                        ? "profile.php?id=$idUser"
                        : "profile_friend.php?idFriend=$userIdComment";
                    ?>
                    <a href="<?php echo $profileLink; ?>">
                        <img src="<?php echo $commentAvatarSrc; ?>"
                            alt="User Profile"
                            class="comment-profile-pic"
                            style="width: 40px; height: 40px; border-radius: 50%;">
                    </a>
                    <p>
                        <span class="comment-user"><?php echo $userComment->getFull_name(); ?></span>
                        <?php echo $comment->getContent(); ?>
                    </p>

                    <?php if ($userIdComment == $idUser): ?>
                        <input type="hidden" name="comment_id" value="<?php echo $comment->getComment_id(); ?>">
                        <button class="delete-comment" type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteComment_<?php echo $comment->getComment_id(); ?>">
                            <i class="fa-solid fa-circle-minus"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <form action="/MVC/Process/photo_process.php" method="POST">
                <div class="modal-footer">
                    <div class="comment-section-modal">
                        <?php
                        $base64Image = base64_encode($userAvatar);
                        $userAvatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                        ?>
                        <img src="<?php echo $userAvatarSrc; ?>" alt="User Profile" class="profile-pic" style="width: 40px; height: 40px;  border-radius: 50%;">
                        <textarea class="comment-input" id="commentInput_<?php echo $post->getPost_id(); ?>" placeholder="Viết bình luận..." name="commentText"></textarea>
                        <div class="icons">
                            <i class="icon fa-regular fa-smile"></i>
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <button name="addComment" type="submit">
                            <i class="fa-solid fa-paper-plane"></i>
                            <input type="hidden" name="post_id" value="<?php echo $post->getPost_id(); ?>">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($comments as $comment): ?>
    <div class="modal fade custom-modal" id="deleteComment_<?php echo $comment->getComment_id(); ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"><strong>Xóa bình luận</strong></h5>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa bình luận này?</p>
                    <form action="/MVC/Process/photo_process.php" method="POST">
                        <button type="submit" class="btn btn-danger" name="delete_comment">Xóa</button>
                        <input type="hidden" name="comment_id" value="<?php echo $comment->getComment_id(); ?>">
                        <input type="hidden" name="post_id" value="<?php echo $comment->getPost_id(); ?>">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="openDetailModal(<?php echo $post->getPost_id(); ?>)">Hủy</button>
                    </form>
                    <script>
                        function openDetailModal(postId) {
                            var myModal = new bootstrap.Modal(document.getElementById('detailCommentModal_' + postId));
                            myModal.show();
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- </form> -->
<script>
    function addComment(postId) {
        var commentInput = document.getElementById("commentInput_" + postId);
        var commentText = commentInput.value.trim();

        if (commentText === "") {
            alert("Vui lòng nhập bình luận!");
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/MVC/Process/profile_process.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response); // In ra phản hồi để kiểm tra

                if (response.status === "success") {
                    commentInput.value = "";
                } else {
                    alert("Đã có lỗi xảy ra. Vui lòng thử lại!");
                }
            }
        };
        xhr.send("addComment=true&postId=" + postId + "&commentText=" + encodeURIComponent(commentText));
        const data = {
        id_user: senderId,
        content: "đã bình luận vào bài viết của bạn", // Nội dung thông báo
        type: "comment", 
        post_id: postId, 
        sent_at: new Date().toISOString(), 
        };
        socket.emit('send_comment', data); // Gửi tin nhắn qua socket
    }

    function toggleLikeComment(button, postId) {
        button.classList.toggle('liked');
        var isLiked = button.classList.contains('liked');
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/MVC/Process/photo_process.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Response from server:", xhr.responseText);
                document.getElementById("likes-count-comment" + postId).innerText = xhr.responseText;
            }
        };

        xhr.send("postId=" + postId + "&isLiked=" + isLiked);
        const data = {
        id_user: senderId,
        content: isLiked ? "đã yêu thích bài viết của bạn" : "đã bỏ yêu thích bài viết của bạn", // Nội dung thông báo
        type: isLiked ? "like" : "unlike", 
        post_id: postId, 
        sent_at: new Date().toISOString(), 
    };
    if (isLiked) {
        socket.emit('send_like', data); // Sự kiện like
    } else {
        socket.emit('send_unlike', data); // Sự kiện thả like
    }
}
</script>