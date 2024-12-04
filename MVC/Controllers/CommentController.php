<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/CommentData.php';

class CommentController
{
    private $comment;

    public function __construct()
    {
        $this->comment = new CommentData();
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
   public function getAllComments()
{
    return $this->comment->getAllComments();
}
}
