<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/Account.php';
require_once BASE_DIR . '/Controllers/Likes.php';
require_once BASE_DIR . '/Controllers/Comment.php';


$accountController = new AccountController();
$likeController = new LikesController();
$commentController = new CommentsController();

$idUser = $_SESSION['idUser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnClosed"])) {
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Account/profile.php?id=' . $idUser . '";';
        echo '</script>';
    }
    if (isset($_POST['postId'])) {
        $postId = intval($_POST['postId']);
        $isLiked = filter_var($_POST['isLiked'], FILTER_VALIDATE_BOOLEAN);
        $accountController = new AccountController();
        try {
            if ($isLiked) {
                $accountController->increaseLikeCount($postId);
                $likeController->addLike($idUser, $postId);
            } else {
                $accountController->decreaseLikeCount($postId);
                $likeController->removeLike($idUser, $postId);
            }
            $post = $accountController->getPostById($postId);
            echo $post->getLike_count();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if (isset($_POST['addComment_photo'])) {
        $post_id = $_POST["post_id_photo"];
        $text = $_POST["textComment"];
        $lpid = $_POST["lpid"];
        $error_message=false;
             $commentController->addComment($idUser, $post_id, $text);
            $accountController->increaseCommentCount($post_id);
            echo '<script>';
            echo '    window.location.href = "/MVC/Views/Account/photo.php?lpid=' . $lpid . '&set=pcb.'.$post_id.'";';
            echo '</script>';
}       

if (isset($_POST['btnDeleteComment'])) {
    $comment_id = $_POST["comment_id"];
    $lpid = $_POST["lpid"];
    $post_id = $_POST["post_id"];
        $commentController->deleteComment($comment_id);
        $accountController->decreaseCommentCount($post_id);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Account/photo.php?lpid=' . $lpid . '&set=pcb.'.$post_id.'";';
        echo '</script>';
}  
        }

