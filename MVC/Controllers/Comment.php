<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/Comment.php';

class CommentsController
{
    private $comment;

    public function __construct()
    {
        $this->comment = new CommentsData();
    }
    public function getAllCommentOfPost($post_id)
    {
        return $this->comment->getAllCommentOfPost($post_id);
    }
    public function addComment( $user_cmt_id, $post_id,$content)
{
    return $this->comment-> addComment( $user_cmt_id, $post_id,$content);

}
public function deleteComment($commentId)
   {
    return $this->comment-> deleteComment($commentId);
   }
}
