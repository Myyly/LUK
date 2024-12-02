<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../Controllers/EmotionController.php';
require_once '../../Controllers/AccountController.php';
require_once '../../Controllers/CommentController.php';
require_once '../../Controllers/LikeController.php';
require_once '../../Controllers/PostController.php';
require_once '../../Controllers/PostImageController.php';
require_once '../../Process/time_process.php';

$emotionController = new EmotionController();
$accountController = new AccountController();
$likeController = new LikeController();
$commentController = new CommentController();
$postController = new PostController();
$postImageController = new PostImageController();


$idUser = $_SESSION['idUser'];
$idFriend = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';




$emotions = $emotionController->getAllEmotions();
$user = $accountController->findUserbyId($idUser);
$userAvatar = $user->getProfile_picture_url();
// $posts = $postController->getAllPostsOfUser($idUserOfPost);
if (!empty($idFriend)) {
    $posts = $postController->getAllPostsOfUser($idFriend);
} else {
    $posts = $postController->getAllPostsOfUser($idUser);
}

?>

<style>
    .post-container {
        width: 800px;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        font-family: Arial, sans-serif;
        margin-left: 10px;
    }

    .post-header {
        display: flex;
        align-items: center;
        /* padding: 10px; */
        background-color: #f5f5f5;
        position: relative;
        /* Add this */
    }

    .avatar-post {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        margin-right: 10px;
        margin-top: -5px;
    }

    .post-user-info {
        display: flex;
        flex-direction: column;
        /* gap: 5px; */
        margin-top: 25px;

    }

    .post-user-info strong {
        font-size: 14px;
    }

    .post-user-info time {
        font-size: 12px;
        color: gray;
    }

    .post-content {
        padding: 10px;
        font-size: 14px;
    }


    /* .post-image-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    } */

    .post-image {
        width: 100%;
        object-fit: cover;
    }

    /* Thêm phần tử cho số lượt like, bình luận, chia sẻ */
    .post-stats {
        display: flex;
        /* justify-content: space-between; */
        padding: 10px;
        font-size: 14px;
        color: gray;
        border-top: 1px solid #ddd;
    }

    .post-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* Giữ tỷ lệ của ảnh mà không bị cắt bớt */
    }

    .post-stats img {
        width: 25px;
        /* Điều chỉnh kích thước ảnh theo chiều rộng */
        margin-right: 5px;
        /* Thêm khoảng cách giữa ảnh và số */
    }

    .post-footer {
        display: flex;
        justify-content: space-around;
        padding: 10px;
        border-top: 1px solid #ddd;
    }

    .post-footer button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: gray;
    }

    .post-footer button:active,
    .post-footer button.liked {
        color: var(--primary-color);
        /* Màu khi nhấn */
    }

    .post-footer button i {
        margin-right: 5px;
    }

    .post-footer button:hover {
        color: var(--primary-color);
    }

    .btn-more-post {
        position: absolute;
        right: 10px;
        /* Adjust as needed */
        top: 15px;
        /* Adjust as needed to move it higher */
        border: none;
        background-color: #f5f5f5;
        color: #9b9b9d;
    }


    .btn-more-post button:hover {
        color: var(--primary-color);
    }

    .post-image-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Set grid to 2 columns */
        gap: 10px;
        /* max-width: 600px; */
        width: 100%;
        /* height: 100%; */
        overflow: hidden;
    }

    .emotion-text {
        font-size: 14px;
        color: black;
        display: flex;
        align-items: center;
        margin-top: -21px;
        margin-left: 50px;
    }

    .emotion-text img {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        margin: 0 5px;
    }

    #imageModal img {
        display: block;
        max-width: 100%;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    #imageModal {
        display: none;
        justify-content: center;
        align-items: center;
    }

    .custom-link {
        color: var(--text-color-secondary);
        text-decoration: none;
    }

    .custom-link:hover {
        text-decoration: underline;
    }

    .custom-modal .modal-dialog {
        max-width: 500px;
    }

    .custom-modal .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-footer-custom button[type="button"]:hover {
        background-color: var(--button-submit);
    }

    .modal-footer-custom button[type="button"] {
        color: var(--primary-color);
    }

    .modal-footer-custom {
        display: flex;
        justify-content: flex-end;
        /* Căn góc bên phải */
        align-items: center;
        /* Căn giữa theo chiều dọc */
        gap: 20px;
        /* Khoảng cách giữa các nút */
        height: 55px;
        /* Chiều cao footer */
        margin-left: 280px;
        /* Khoảng cách lề trái nếu cần */
        padding: 0 20px;
        /* Thêm khoảng trống hai bên nếu cần */
    }

    /* //modal  */
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="/assets/CSS/variables.css">


<?php
foreach ($posts as $post):
    $comments = $commentController->getAllCommentOfPost($post->getPost_id());
    $time = formatTimeAgo($post->getCreate_at());

?>
    <div class="post-container">
        <div class="post-header">
            <?php
            $userOfPost = $accountController->findUserbyId($post->getUser_id());
            $img = $userOfPost->getProfile_picture_url();
            $id=$post->getUser_id();
            $profileLink = ($id == $idUser)
                ? "profile.php?id=$idUser"
                : "profile_friend.php?idFriend=$id";
            if ($img) {
                $avatarSrc = 'data:image/jpeg;base64,' . base64_encode($img);
            } else {
                $avatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
            }
            ?>
             <a href="<?php echo $profileLink; ?>">
            <img src="<?php echo $avatarSrc; ?>" class="avatar-post" alt="User Avatar" style="margin-left: 10px;"></a>
            <div class="post-user-info">
                <strong><?php echo $userOfPost->getFull_name(); ?></strong>
                <?php
                $emotion = $emotionController->getEmotionById($post->getEmotion_id());
                if ($emotion) {
                    $emotionName = $emotion->getName();
                    $emotionImage = $emotion->getImage();
                ?>
                    <span class="emotion-text">
                        đang
                        <img src="/assets/emotions/<?php echo $emotionImage ?>" alt="<?php echo $emotionName  ?>" style="width: 20px; height: 20px; vertical-align: middle; margin: 0 5px;">
                        cảm thấy <strong style="margin-left: 5px;"><?php echo $emotionName; ?></strong>
                    </span>
                <?php } ?>
                <time><?php echo $time; ?></time>
                <?php if (empty($idFriend)): ?>
                    <button class="btn-more-post" type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#deletePost_<?php echo $post->getPost_id(); ?>">
                        <i class="fa-solid fa-trash fa-lg"></i>
                    </button>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="post-content">
            <?php echo $post->getContent(); ?>
        </div>
        <div class="post-image-container">
            <?php
            $images = $postImageController->getAllImagesOfPost($post->getPost_id());
            $totalImages = count($images);
            $allImagesBase64 = [];
            foreach ($images as $index => $image):
                if ($index >= 4) break;
                $imgBlob = $image->getImage_data();
                if ($imgBlob) {
                    $base64Image = base64_encode($imgBlob);
                    $imgSrc = 'data:image/jpeg;base64,' . $base64Image;
                    $allImagesBase64[] = $base64Image;
                }
            ?>

                <div class="post-image-wrapper" style="position: relative; width: 100%; padding-top: 100%; overflow: hidden;">
                    <img class="post-image" src="<?php echo $imgSrc ?>" alt="Post Image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" onclick="openImageOverlay('<?php echo $image->getImage_id(); ?>', '<?php echo $post->getPost_id(); ?>')">
                    <?php if ($index === 3 && $totalImages > 4): ?>
                        <div class="image-overlay" data-url="photo.php?lpid=<?php echo $image->getImage_id(); ?>&set=pcb.<?php echo $post->getPost_id(); ?>"
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer;"
                            onclick="openImageOverlay('<?php echo $image->getImage_id(); ?>', '<?php echo $post->getPost_id(); ?>')">
                            +<?php echo $totalImages - 4; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            document.querySelectorAll('.image-overlay').forEach(overlay => {
                overlay.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        </script>
        <div class="post-stats">
            <span>
                <img src="/assets/emotions/heart.png" alt="" style="margin-left: 7px;">
                <span class="likes-count" id="likes-count-<?php echo $post->getPost_id(); ?>"><?php echo $post->getLike_count(); ?></span>
            </span>
            <span style="margin-left: 490px;">
                
                <?php include 'detail_comment_of_post.php'; ?>
            </span>
            <span style="margin-left: 37px;"> <?php echo $post->getShare_count() ?> lượt chia sẻ</span>
        </div>
        <?php
        $isLiked = $likeController->isPostLikedByUser($idUser, $post->getPost_id());
        ?>
        <div class="post-footer">
            <button id="like-button-<?php echo $post->getPost_id(); ?>"
                class="<?php echo $isLiked ? 'liked' : ''; ?>"
                onclick="toggleLike(this, <?php echo $post->getPost_id(); ?>)"
                type="button">
                <i class="fa-solid fa-heart fa-lg"></i> Thích
            </button>
            <button data-bs-toggle="modal"
                data-bs-target="#detailCommentModal_<?php echo $post->getPost_id(); ?>"><i class="fas fa-comment fa-lg" type="button"></i> Bình luận</button>
            <button><i class="fas fa-share fa-lg" type="button"></i> Chia sẻ</button>
        </div>
    </div>
    <div class="modal fade custom-modal" id="deletePost_<?php echo $post->getPost_id(); ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel"><strong>Xóa bài viết</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 100px;">
                    Bạn có chắc chắn muốn xóa bài viết này không?
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Hủy</button>
                    <form action="/MVC/Process/profile_process.php" method="post">
                        <button type="submit" class="btn btn-danger" name="btnDeletePost">Xóa</button>
                        <input type="hidden" name="post_id" value="<?php echo $post->getPost_id(); ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>








<?php endforeach; ?>
<script>
    function toggleLike(button, postId) {
        button.classList.toggle('liked');
        var isLiked = button.classList.contains('liked');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/MVC/Process/photo_process.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("likes-count-" + postId).innerText = xhr.responseText;
            }
        };
        xhr.send("postId=" + postId + "&isLiked=" + isLiked);
    }

    function openImageOverlay(imageId, postId) {
        const url = `photo.php?lpid=${imageId}&set=pcb.${postId}`;
       window.location.href = url; 
    }
</script>