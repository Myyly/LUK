<?php 
class PostModal{
    public $post_id;
    public $user_id;
    public $content;
    public $created_at;
    public $emotion_id;
    public $like_count;
    public $comment_count;
    public $share_count;
    public function __construct($post_id,$user_id,$content,$created_at,$emotion_id,$like_count,$comment_count,$share_count){
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->emotion_id =$emotion_id;
        $this->like_count = $like_count;
        $this->comment_count = $comment_count;
        $this->share_count =$share_count;
     
    }
    public function getPost_id(){
        return $this->post_id;
    }
    public function setPost_id($post_id){
        $this->post_id = $post_id;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }
    public function getContent(){
        return $this->content;
    }
    public function setContent($content){
        $this->content = $content;
    }
    public function getCreate_at(){
        return $this->created_at;
    }
    public function setCreate_at($created_at){
        $this->created_at = $created_at;
    }
    public function getEmotion_id(){
        return $this->emotion_id;
    }
    public function setEmotion_id($emotion_id){
        $this->emotion_id = $emotion_id;
    }
    public function getLike_count(){
        return $this->like_count;
    }
    public function setLike_count($like_count){
        $this->like_count = $like_count;
    }
    public function getComment_count(){
        return $this->comment_count;
    }
    public function setComment_count($comment_count){
        $this->comment_count = $comment_count;
    }
    public function getShare_count(){
        return $this->share_count;
    }
    public function setShare_count($share_count){
        $this->share_count = $share_count;
    }
    
    }
?>