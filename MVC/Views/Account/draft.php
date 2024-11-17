<?php

session_start();

require_once '../../Controllers/Account.php';
require_once '../../Controllers/Comment.php';

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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



    <title>Photo View Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .photo-view-page {
            display: flex;
            background-color: #18191a;
            height: 100vh;
            color: #ffffff;
            overflow: hidden;
        }

        .sidebar-section {
            width: 22%;
            padding: 20px;
            background-color: var(--background-color);
            display: flex;
            flex-direction: column;
            gap: 15px;
            overflow-y: auto;
            height: 100vh;
            box-sizing: border-box;
            max-: 500px;
            overflow: hidden;
        }

        .close-btn {
            font-size: 30px;
            color: var(--button-submit-hover);
            text-decoration: none;
            align-self: flex-end;
        }

        .photo-owner-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #000;
        }

        .profile-pic,
        .comment-profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
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

        .main-photo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .nav-btn {
            font-size: 36px;
            color: #000;
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

        .photo-comments {
    margin-top: 20px;
    color: #000;
    max-height: 400px; /* Đặt chiều cao tối đa để phần bình luận có thể cuộn */
    overflow-y: auto; /* Bật tính năng cuộn dọc */
}

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

        .photo-description {
            color: #000;
            margin-top: 20px;
        }

        .comment-input {
            width: 200px;
            max-width: 200px;
            padding: 10px;
            border-radius: 20px;
            border: none;
            outline: none;
            background-color: var(--shadow-color);
            color: black;
            height: 40px;
        }

        .comment {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            color: #000;
            overflow: hidden;
            max-height: 50px;
            
        }

        .comment-user {
            font-weight: bold;
        }

        .post-date {
            color: var(--text-color-secondary);
            margin-top: 7.5px;
        }

        .photo-actions img {
            width: 25px;
            /* Điều chỉnh kích thước ảnh theo chiều rộng */
            margin-right: 5px;
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

        .photo-stats {
            display: flex;
            padding: 10px;
            font-size: 14px;
            color: gray;
            padding: 5px;
        }

        .like-count {
            display: flex;
            align-items: center;
            /* Align image and number vertically */
        }

        .photo-stats img {
            width: 20px;
        }

        .main-photo:first-of-type {
            display: block;
            /* Show the first image initially */
        }
        .user-comment{
            background-color: var( --background-color);
            
            
        }
    </style>
</head>

<body>
    <div class="photo-view-page">
        <!-- Sidebar Section -->
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
                    <span class="likes-count" style=" vertical-align: 5px;">120</span>
                </span>
                <span style="margin-left: 176px;"><i class="fa-solid fa-comment"></i> 456</span>
                <span style="margin-left: 15px;"><i class="fa-solid fa-share"></i> 100</span>
            </div>
            <div class="photo-actions">
     
                <button onclick="toggleLike(this)" type="button"><i class="fa-regular fa-heart fa-lg"></i> Thích</button>
                <button type="button"><i class="fa-regular fa-comment fa-lg"></i> Bình luận</button>
                <button type="button"><i class="fa-solid fa-share fa-lg"></i>Chia sẻ</button>
            </div>


            <div class="photo-comments">
                <!-- Displaying comments -->
                <?php  foreach ($comments as $comment): 
                ?>
                <div class="comment">
                    <?php
                    $userIdComment = $comment->getUser_cmt_id();
                    $userComment = $accountController->findUserbyId($userIdComment);
                    $commentAvatar = $userComment->getProfile_picture_url();
                    if($commentAvatar){
                    $base64CommentAvatar = base64_encode($commentAvatar);
                    $commentAvatarSrc = 'data:image/jpeg;base64,' . $base64CommentAvatar;
                    ?>
                    <img src="<?php echo $commentAvatarSrc; 
                                ?>" alt="User Profile" class="comment-profile-pic">
                    <?php } else { ?>
                            <img src="https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360"alt="User Profile" class="comment-profile-pic">
                    <?php } ?>
                    <p><span class="comment-user"><?php echo $userComment->getFull_name(); 
                                                    ?></span>
                        <?php  echo $comment->getContent(); 
                        ?></p>
                </div>
                <?php endforeach; 
                ?>
            </div>
            <div class ="user-comment" style="margin-top: 20px;width: 250px;border-radius: 3px;height:80px;">
               <?php
                $avatar = $user->getProfile_picture_url();
                $base64Image = base64_encode($avatar);
                $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                ?>
                <img src="<?php echo $avatarSrc; ?>"  class="profile-pic" style="top: 10px;">
                <textarea class="comment-input" id="bio" rows="3" name=""placeholder="Viết bình luận..." ></textarea>
                <!-- <input type="text" placeholder="Viết bình luận..." class="comment-input"> -->
                 <button name="addComment" type="submit" style="border: none">
                 <i class="fa-solid fa-paper-plane fa-2xl" style="color: #e51f1f;margin-left: -30px;"></i>
                 </button>
                </div>
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
                <!-- Navigation buttons (prev/next) -->
                <button class="nav-btn prev-btn"  onclick="changeImage(<?php echo $index; ?>, 'prev', <?php echo $postId; ?>)">❮</button>
                <!-- Image display -->
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
    // JavaScript to handle navigation
    // JavaScript to handle navigation
    function changeImage(currentIndex, direction, postId) {
        // Get all image sections
        const images = document.querySelectorAll('.photo-section');
        const totalImages = images.length;

        // Calculate the new index based on the direction
        let newIndex = currentIndex;
        if (direction === 'next') {
            newIndex = (currentIndex + 1) % totalImages;
        } else if (direction === 'prev') {
            newIndex = (currentIndex - 1 + totalImages) % totalImages;
        }

        // Hide all images and display the selected one
        images.forEach(image => {
            image.style.display = 'none';
        });
        images[newIndex].style.display = 'flex';

        // Get the new image ID for the selected image
        const newImageId = images[newIndex].getAttribute('data-image-id');

        // Update the URL with new postId and imageId
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

    function toggleLike(button) {
        button.classList.toggle('liked');
    }
</script>