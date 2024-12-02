<?php 
class LikeModal{
    public $like_id;
    public $user_like_id;
    public $post_id;
 
    
    
    public function __construct($like_id,$user_like_id,$post_id){
        $this->like_id = $like_id;
        $this->user_like_id = $user_like_id;
        $this->post_id = $post_id;
    }
    public function getPost_id(){
        return $this->post_id;
    }
    public function setPost_id($post_id){
        $this->post_id = $post_id;
    }
    public function getUser_like_id(){
        return $this->user_like_id;
    }
    public function setUser_like_id($user_like_id){
        $this->user_like_id = $user_like_id;
    }
    public function getLike_id(){
        return $this->like_id;
    }
    public function setLike_id($like_id){
        $this->like_id = $like_id;
    }

    }
?>