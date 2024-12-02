<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/PostData.php';

class PostController
{
    private $post;

    public function __construct()
    {
        $this->post = new  PostData();
    }
    public function CreatePost($user_id, $content = null, $created_at = null, $emotion_id = null){
        return $this->post->CreatePost($user_id, $content = null, $created_at = null, $emotion_id = null);
    }
    public function getAllPostsOfUser($user_id){
        return $this->post->getAllPostsOfUser($user_id);
        }
        public function getPostById($post_id)
{
    return $this->post->getPostById($post_id);
}
public function increaseLikeCount($post_id) {

    return $this->post->increaseLikeCount($post_id);
}
public function decreaseLikeCount($post_id) {
    return $this->post->decreaseLikeCount($post_id);
}
public function increaseCommentCount($post_id) {
    return $this->post->increaseCommentCount($post_id);
}
public function decreaseCommentCount($post_id) {
    return $this->post->decreaseCommentCount($post_id);
}
public function deletePost($postId){
    return $this->post->deletePost($postId);
}

}
?>
