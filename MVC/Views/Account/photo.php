<?php

session_start();

require_once '../../Controllers/Account.php';
require_once '../../Controllers/Comment.php';
require_once '../../Controllers/Likes.php';

$accountController = new AccountController();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$lpid = isset($_GET['lpid']) ? $_GET['lpid'] : '';
$set = isset($_GET['set']) ? $_GET['set'] : '';
$postId_set = $set;
$idUser = $_SESSION['idUser'];
$postId = str_replace("pcb.", "", $postId_set);
$images = $accountController->getAllImagesOfPost($postId);
$image = $accountController->getImagesById($lpid);
$user = $accountController->findUserbyId($idUser);
$post = $accountController->getPostById($postId);
$commentController = new CommentsController();
$comments = $commentController->getAllCommentOfPost($postId);
$likeController = new LikesController();

function increaseLikeCount($postId)
{
    $accountController = new AccountController();
    $accountController->increaseLikeCount($postId);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/assets/CSS/variables.css">

    <title>LUK</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .photo-view-page {
            display: flex;
            height: 100vh;
        }

        /* .sidebar-section */
        .sidebar-section {
            width: 35%;
            padding: 20px;
            background-color: var(--background-color);
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: calc(100vh - 40px);
            overflow-y: auto;
            /* position: fixed; */
            top: 20px;
            box-sizing: border-box;
        }

        .photo-owner-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
        }

        .photo-section {
            width: 78%;
            padding: 20px;
            overflow-y: auto;
        }

        .photo-description {
            color: #000;
            margin-top: 20px;
        }

        .photo-actions img {
            width: 25px;
            /* Điều chỉnh kích thước ảnh theo chiều rộng */
            margin-right: 10px;
            /* Thêm khoảng cách giữa ảnh và số */

        }

        .photo-actions {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            border-top: 1px solid #ddd;
            color: var(--text-color-secondary);
            border-bottom: 1px solid #ddd;
        }

        .photo-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: gray;
        }

        .photo-actions button:active,
        .photo-actions button.liked {
            color: var(--primary-color);
            /* Màu khi nhấn */
        }

        .photo-actions button i {
            margin-right: 5px;
        }

        .photo-actions button:hover {
            color: var(--primary-color);
        }

        .like-count {
            display: flex;
            align-items: center;
        }

        .photo-comments {
            margin-top: 20px;

        }

        /* .comment-input {
            width: 250px;
            padding: 10px;
            border-radius: 20px;
            border: none;
            outline: none;
            background-color: var(--shadow-color);
            color: black;
            margin-left: 50px;
        } */
        .comment {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            color: #000;
        }

        .comment-user {
            font-weight: bold;
        }

        .user-comment {
            display: flex;
            align-items: center;
            background-color: #f0f2f5;
            border-radius: 30px;
            padding: 8px 16px;
            position: relative;
            margin-top: 10px;
        }

        .user-comment img.profile-pic {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-input {
            flex-grow: 1;
            background-color: transparent;
            border: none;
            outline: none;
            padding: 10px;
            font-size: 14px;
            color: #333;
            resize: none;
            width: 100%;
            box-sizing: border-box;
        }

        .comment-input::placeholder {
            color: #888;
        }

        .user-comment button[type="submit"] {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            margin-left: 8px;
            display: flex;
            align-items: center;
        }

        .user-comment button[type="submit"] i {
            font-size: 18px;
            color: #65676b;
            margin-left: 8px;
        }

        .user-comment .icons {
            display: flex;
            gap: 15px;
            margin-right: 3px;
        }

        .user-comment .icon {
            font-size: 20px;
            color: #65676b;
            cursor: pointer;
            transition: color 0.2s;
        }

        .user-comment .icon:hover {
            color: #007bff;
        }

        /* .user-comment {
            bottom: 10px;
            margin-left: -5px;
            width: 320px;
            height: 130px;
            border-radius: 3px;
            background-color: white;
            z-index: 1000;
            position: fixed;
        }
        .user-comment button{
            background-color: white;
            border: none;
            margin-left: 70px;
        } */
        .post-date {
            color: var(--text-color-secondary);
            margin-top: 7.5px;
        }

        .photo-stats {
            display: flex;
            padding: 10px;
            font-size: 14px;
            color: gray;
            padding: 5px;
        }

        .photo-stats img {
            width: 20px;
        }

        .profile-pic,
        .comment-profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .photo-comments {
            margin-top: 20px;

            color: #000;
            max-height: 700px;
            overflow-y: auto;
        }

        .photo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        /* //mainphoto */
        .btnClosed {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 10px;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 35px;
            color: #a8a8a8;

            transition: color 0.3s ease;
        }

        .nav-btn {
            font-size: 36px;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            cursor: pointer;
            padding: 10px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            transition: background 0.3s;
        }

        .nav-btn:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        .main-photo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .main-photo:first-of-type {
            display: block;
            /* Show the first image initially */
        }
        .delete-comment{
            border: none;
            background-color: white;
        }
        .delete-comment i{
            color: var(--icon-color);
            }
        .delete-comment i:hover{
            color: red;
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
        .modal-footer-custom button[type="button"]:hover {
    background-color: var(--button-submit);
}
.modal-footer-custom button[type="button"]{
    color: var(--primary-color);
}

.modal-footer-custom {
    display: flex; 
    justify-content: flex-end; /* Căn góc bên phải */
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 20px; /* Khoảng cách giữa các nút */
    height: 55px; /* Chiều cao footer */
    margin-left: 280px; /* Khoảng cách lề trái nếu cần */
    padding: 0 20px; /* Thêm khoảng trống hai bên nếu cần */
}
      
    </style>
</head>
<body>
    <div class="photo-view-page">
        <div class="sidebar-section">
            <div class="photo-owner-info">
                <?php
                $avatar = $user->getProfile_picture_url();
                $base64Image = base64_encode($avatar);
                $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                ?>
                <img src="<?php echo $avatarSrc; ?>" alt="Owner Profile" class="profile-pic">
                <div class="owner-details">
                    <p class="owner-name"><strong><?php echo $user->getFull_name(); ?></strong></p>
                    <p class="post-date"><time><?php echo $post->getCreate_at(); ?></time></p>
                </div>
            </div>
            <div class="photo-description">
                <p><?php echo $post->getContent(); ?></p>
            </div>
            <div class="photo-stats">
                <span>
                    <img src="/assets/emotions/heart.png" alt="" style="margin-left: -7px;">
                    <span class="likes-count" style=" vertical-align: 5px;" id="likes-count-detail-photo-<?php echo $postId; ?>"><?php echo $post->getLike_count(); ?></span>
                </span>
                <span style="margin-left: 150px;position: fixed; margin-top:25px;"><i class="fa-solid fa-comment"></i> <?php echo $post->getComment_count(); ?></span>
                <span style="margin-left: 230px;position: fixed; margin-top:25px;"><i class="fa-solid fa-share"></i> <?php echo $post->getShare_count() ?></span>
            </div>
            <?php
            $isLiked = $likeController->isPostLikedByUser($idUser, $post->getPost_id());
            ?>
            <div class="photo-actions">
                <button onclick="toggleLikeDetailPhoto(this, <?php echo $postId; ?>)" type="button" class="<?php echo $isLiked ? 'liked' : ''; ?>">
                    <i class="fa-solid fa-heart fa-lg"></i> Thích
                </button>
                <button type="button"><i class="fa-regular fa-comment fa-lg"></i> Bình luận</button>
                <button type="button"><i class="fa-solid fa-share fa-lg"></i>Chia sẻ</button>
            </div>
            <div class="photo-comments">
                <?php foreach ($comments as $comment):
                ?>
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
                        $profileLink = ($idUser == $userIdComment)
                            ? "profile.php?id=$idUser"
                            : "profile_friend.php?idFriend=$userIdComment"; ?>
                        <a href="<?php echo $profileLink; ?>">
                            <img src="<?php echo $commentAvatarSrc; ?>" alt="User Profile" class="comment-profile-pic" style="width: 40px; height: 40px; border-radius: 50%;">
                        </a>
                        <p><span class="comment-user"><?php echo $userComment->getFull_name();
                                                        ?></span>
                            <?php echo $comment->getContent();
                            ?></p>
                        <?php if ($userIdComment == $idUser): ?>
                               <input type="hidden" name="comment_id" value="<?php echo $comment->getComment_id(); ?>">
                               <button class="delete-comment" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteComment_<?php echo $comment->getComment_id(); ?>">
                                <i class="fa-solid fa-circle-minus"></i>
                            </button>
                        <?php  endif; ?>
                       <div class="modal fade custom-modal" id="deleteComment_<?php  echo $comment->getComment_id(); ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel"><strong>Xóa bình luận</strong></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="height: 100px;">
                                        Bạn có chắc chắn muốn xóa bình luận này không?
                                    </div>
                                    <div class="modal-footer-custom">
                                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Hủy</button>
                                        <form action="../../Process/photo_process.php" method="post">
                                            <button type="submit" class="btn btn-danger" name="btnDeleteComment">Xóa</button>
                                            <input type="hidden" name="comment_id" value="<?php echo $comment->getComment_id(); ?>">
                                            <input type="hidden" name="post_id" value="<?php echo  $postId; ?>">
                                            <input type="hidden" name="lpid" value="<?php echo $lpid; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    
                    </div>
                    
                <?php endforeach;
                ?>
            </div>
            <form action="../../Process/photo_process.php" method="POST">
                <div class="user-comment">
                    <img src="<?php echo $avatarSrc; ?>" alt="User Profile" class="profile-pic">
                    <textarea class="comment-input" placeholder="Viết bình luận..." name="textComment"></textarea>
                    <div class="icons">
                        <i class="icon fa-regular fa-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <button name="addComment_photo" type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <input type="hidden" name="post_id_photo" value="<?php echo $postId; ?>">
                        <input type="hidden" name="lpid" value="<?php echo $lpid; ?>">
                    </button>
                </div>
            </form>

        </div>
        <?php
        $images = $accountController->getAllImagesOfPost($postId);
        $totalImages = count($images);
        foreach ($images as $index => $image) {
            $image_select = $image->getImage_data();
            $base64Image = base64_encode($image_select);
            $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
            $imageId = $image->getImage_id();
        ?>
            <div class="photo-section" data-index="<?php echo $index; ?>" data-image-id="<?php echo $imageId; ?>" style="<?php echo $index === 0 ? 'display: flex;' : 'display: none;'; ?>">
                <form action="../../Process/photo_process.php" method="POST">
                    <button type="submit" class="btnClosed" name="btnClosed">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </form>
                <button class="nav-btn prev-btn" onclick="changeImage(<?php echo $index; ?>, 'prev', <?php echo $postId; ?>)">❮</button>
                <img src="<?php echo $avatarSrc; ?>" alt="Main Photo" class="main-photo">
                <button class="nav-btn next-btn" onclick="changeImage(<?php echo $index; ?>, 'next', <?php echo $postId; ?>)">❯</button>
            </div>
        <?php
        }
        ?>

    </div>
    
</body>

</html>
<script>
    function changeImage(currentIndex, direction, postId) {
        const images = document.querySelectorAll('.photo-section');
        const totalImages = images.length;
        let newIndex = currentIndex;
        if (direction === 'next') {
            newIndex = (currentIndex + 1) % totalImages;
        } else if (direction === 'prev') {
            newIndex = (currentIndex - 1 + totalImages) % totalImages;
        }
        images.forEach(image => {
            image.style.display = 'none';
        });
        images[newIndex].style.display = 'flex';
        const newImageId = images[newIndex].getAttribute('data-image-id');
        const newUrl = `/MVC/Views/Account/photo.php?lpid=${newImageId}&set=pcb.${postId}`;
        history.pushState(null, '', newUrl);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.photo-section');
        images.forEach((image, index) => {
            if (index !== 0) {
                image.style.display = 'none';
            }
        });
    });

    function toggleLikeDetailPhoto(button, postId) {
        button.classList.toggle('liked');
        var isLiked = button.classList.contains('liked');
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../../Process/photo_process.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("likes-count-detail-photo-" + postId).innerText = xhr.responseText;
            }
        };
        xhr.send("postId=" + postId + "&isLiked=" + isLiked);
    }
</script>