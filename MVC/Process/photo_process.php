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

$accountController = new AccountController();
$likeController = new LikeController();
$commentController = new CommentController();
$postController = new PostController();
$postImageController = new PostImageController();
$idUser = $_SESSION['idUser'];
$idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnClosed"])) {
        $currentUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (strpos($currentUrl, '/index.php') !== false) {
            echo '<script>';
            echo '    window.location.href = "/index.php";';
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
            $previousUrl = isset($_SESSION['index_page']) ? $_SESSION['index_page'] : '';
            if ($previousUrl === '/index.php') {
                echo '<script>';
                echo '    window.location.href = "/index.php";';
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
        $accountController = new AccountController();
        try {
            if ($isLiked) {
                $postController->increaseLikeCount($postId);
                $likeController->addLike($idUser, $postId);
            } else {
                $postController->decreaseLikeCount($postId);
                $likeController->removeLike($idUser, $postId);
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
    if (isset($_POST["addComment"])) {
        $post_id = $_POST["post_id"];
        $commentText = $_POST["commentText"];
        $commentController->addComment($idUser, $post_id, $commentText);
        $postController->increaseCommentCount($post_id);
        $currentUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if (strpos($currentUrl, '/index.php') !== false) {
            echo '<script>';
            echo '    localStorage.setItem("open_modal", ' . $post_id . ');';  // Lưu post_id vào localStorage
            echo '    window.location.href = "/index.php";';
            echo '</script>';
            }
        else {
        echo '<script>';
        echo '    localStorage.setItem("open_modal", ' . $post_id . ');';  // Lưu post_id vào localStorage
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
        echo '</script>';
        }

    }
}


