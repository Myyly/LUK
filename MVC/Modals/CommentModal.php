<?php 
class CommentModal{
    public $comment_id;
    public $user_cmt_id;
    public $post_id;
    public $content;
    
    
    public function __construct($comment_id,$user_cmt_id,$post_id,$content){
        $this->comment_id = $comment_id;
        $this->user_cmt_id = $user_cmt_id;
        $this->post_id = $post_id;
        $this->content = $content;
    }
    public function getPost_id(){
        return $this->post_id;
    }
    public function setPost_id($post_id){
        $this->post_id = $post_id;
    }
    public function getUser_cmt_id(){
        return $this->user_cmt_id;
    }
    public function setUser_cmt_id($user_cmt_id){
        $this->user_cmt_id = $user_cmt_id;
    }
    public function getContent(){
        return $this->content;
    }
    public function setContent($content){
        $this->content = $content;
    }
    public function getComment_id(){
        return $this->comment_id;
    }
    public function setComment_id($comment_id){
        $this->comment_id = $comment_id;
    }
    }
?>