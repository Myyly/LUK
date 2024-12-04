<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/LikeData.php';

class LikeController
{
    private $like;

    public function __construct()
    {
        $this->like = new  LikeData();
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
    public function getAllLikes()
{
    return $this->like->getAllLikes();

}

}
