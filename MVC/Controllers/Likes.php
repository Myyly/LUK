<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/Likes.php';

class LikesController
{
    private $like;

    public function __construct()
    {
        $this->like = new  LikesData();
    }
    public function isPostLikedByUser($userId, $postId)
    {
        return $this->like->isPostLikedByUser($userId, $postId);
    }
    public function addLike($userId, $postId){
        return $this->like->addLike($userId, $postId);
    }
    public function removeLike($userId, $postId){
        return $this->like->removeLike($userId, $postId);
    }

}
