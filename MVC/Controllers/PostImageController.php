<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/PostImageData.php';

class PostImageController
{
    private $postImage;

    public function __construct()
    {
        $this->postImage = new  PostImageData();
    }
    public function AddPostImage($post_id, $image_path)
    {
        return $this->postImage->AddPostImage($post_id, $image_path);
    }
    public function getAllImagesOfPost($post_id)
    {
        return $this->postImage->getAllImagesOfPost($post_id);
    }
    public function getImagesById($image_id)
    {
        return $this->postImage->getImagesById($image_id);
    }   
}
