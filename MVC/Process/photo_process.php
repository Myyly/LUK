<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/AccountController.php';
require_once BASE_DIR . '/Controllers/CommentController.php';
require_once BASE_DIR . '/Controllers/LikeController.php';
require_once BASE_DIR . '/Controllers/PostController.php';
require_once BASE_DIR . '/Controllers/PostImageController.php';
require_once BASE_DIR . '/Controllers/NotificationController.php';

$accountController = new AccountController();
$likeController = new LikeController();
$commentController = new CommentController();
$postController = new PostController();
$postImageController = new PostImageController();
$notificationController = new NotificationController();

$idUser = $_SESSION['idUser'];
$idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
$data = json_decode(file_get_contents(filename: "php://input"), true);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["btnClosed"])) {
        $currentUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (strpos($currentUrl, '/MVC/Views/Newsfeed/home.php') !== false) {
            echo '<script>';
            echo '    window.location.href = "/MVC/Views/Newsfeed/home.php";';
            echo '</script>';
        } else {
                $id = $_POST["id"];
                if ($id == $idUser) {
                    echo '<script>';
                    echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $id . '";';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo '    window.location.href = "/MVC/Views/Profile/profile_friend.php?idFriend=' . $id . '";';
                    echo '</script>';
                }
            } 
        }
        if (isset($_POST["btnClosed_photo"])) {
            $previousUrl = isset($_SESSION['home_page']) ? $_SESSION['home_page'] : '';
            if ($previousUrl === '/MVC/Views/Newsfeed/home.php') {
                echo '<script>';
                echo '    window.location.href = "/MVC/Views/Newsfeed/home.php";';
                echo '</script>';
                exit;
            }
                    if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($id == $idUser) {
                    echo '<script>';
                    echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $id . '";';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo '    window.location.href = "/MVC/Views/Profile/profile_friend.php?idFriend=' . $id . '";';
                    echo '</script>';
                }
            }
        }
    if (isset($_POST['postId'])) {
        $postId = intval($_POST['postId']);
        $isLiked = filter_var($_POST['isLiked'], FILTER_VALIDATE_BOOLEAN);
        $type = "like";
        $content = "đã yêu thích bài viết của bạn";
        $accountController = new AccountController();
        try {
            if ($isLiked) {
                $postController->increaseLikeCount($postId);
                $likeController->addLike($idUser, $postId);
                $post_notification = $postController->getPostById($postId);
                $id_user_notification = $post_notification->getUser_id();
                $notificationController->addNotification($id_user_notification,$type,$content,$postId);
            } else {
                $postController->decreaseLikeCount($postId);
                $likeController->removeLike($idUser, $postId);
                $post_notification = $postController->getPostById($postId);
                $id_user_notification = $post_notification->getUser_id();
                $id_notification = $notificationController->getNotificationByPostAndUser($id_user_notification,$postId,"like");
                if ($id_notification) {
                    $notificationController->deleteNotification($id_notification);
                }
            }
            $post = $postController->getPostById($postId);
            echo $post->getLike_count();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if (isset($_POST['addComment_photo'])) {
        $post_id = $_POST["post_id_photo"];
        $text = $_POST["textComment"];
        $lpid = $_POST["lpid"];
        $error_message = false;
        $commentController->addComment($idUser, $post_id, $text);
        $postController->increaseCommentCount($post_id);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views//Profile/photo.php?lpid=' . $lpid . '&set=pcb.' . $post_id . '";';
        echo '</script>';
    }

    if (isset($_POST['btnDeleteComment'])) {
        $comment_id = $_POST["comment_id"];
        $lpid = $_POST["lpid"];
        $post_id = $_POST["post_id"];
        $commentController->deleteComment($comment_id);
        $postController->decreaseCommentCount($post_id);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/photo.php?lpid=' . $lpid . '&set=pcb.' . $post_id . '";';
        echo '</script>';
    }
   // Sau khi xóa bình luận
if (isset($_POST['delete_comment'])) {
    $comment_id = $_POST["comment_id"];
    $post_id = $_POST["post_id"];
    $commentController->deleteComment($comment_id);
    $postController->decreaseCommentCount($post_id);
    echo '<script>';
    echo '    localStorage.setItem("open_modal", ' . $post_id . ');';  // Lưu post_id vào localStorage
    echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
    echo '</script>';
}
if (isset($data['postId'], $data['commentText'])) {
    $type="comment";
    $content = "đã bình luận vào bài viết của bạn";
    $postId = $data['postId'];
    $commentText = $data['commentText'];
    $commentId = $commentController->addComment($idUser, $postId, $commentText);
    $postController->increaseCommentCount($postId);
    $cout_comment = $postController->getPostById($postId)->getComment_count();
    $userComment = $accountController->findUserbyId($idUser);
    $commentAvatar = $userComment->getProfile_picture_url();
    $post_notification = $postController->getPostById($postId);
                $id_user_notification = $post_notification->getUser_id();
                $notificationController->addNotification($id_user_notification,$type,$content,$postId);
    if ($commentAvatar) {
        $commentAvatarSrc = 'data:image/jpeg;base64,' . base64_encode($commentAvatar);
    } else {
        $commentAvatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
    }

    $response = [
        'success' => true,
        'commentId' => $commentId,
        'postId' => $postId,
        'commentText' => $commentText,
        'fullName' => $userComment->getFull_name(),
        'profilePicture' => $commentAvatarSrc,
        'profileLink' => ($idUser == $userComment->getUser_id()) ? "profile.php?id=$idUser" : "profile_friend.php?idFriend={$userComment->getUser_id()}",
        'commentCount'=>$cout_comment
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
if (isset($data['id_user']) ){
    $id_user = $data['id_user'];
    $user_info = $accountController->findUserbyId($id_user);
    $name_user = $user_info->getFull_name();
    $avatar_user = $user_info->getProfile_picture_url();
    if ($avatar_user) {
        $AvatarSrc = 'data:image/jpeg;base64,' . base64_encode($avatar_user);
    } else {
        $AvatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
    }
    $response = [
        'success' => true,
        'fullName' => $name_user,
        'profilePicture' => $AvatarSrc
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
    }


    // if (isset($_POST["addComment"])) {
    //     $post_id = $_POST["post_id"];
    //     $commentText = $_POST["commentText"];
    //     $commentController->addComment($idUser, $post_id, $commentText);
    //     $postController->increaseCommentCount($post_id);
    //     $currentUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    //     if (strpos($currentUrl, '/index.php') !== false) {
    //         echo '<script>';
    //         echo '    localStorage.setItem("open_modal", ' . $post_id . ');';  // Lưu post_id vào localStorage
    //         echo '    window.location.href = "/index.php";';
    //         echo '</script>';
    //         }
    //     else {
    //     echo '<script>';
    //     echo '    localStorage.setItem("open_modal", ' . $post_id . ');';  // Lưu post_id vào localStorage
    //     echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
    //     echo '</script>';
    //     }
    // }

}


