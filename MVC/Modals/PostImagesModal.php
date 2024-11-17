<?php 
class PostsImagesModal{
    public $image_id;
    public $post_id;
    public $image_data;

    public function __construct($image_id,$post_id,$image_data){
        $this->image_id = $image_id;
        $this->post_id = $post_id;
        $this->image_data = $image_data;
        
    }
    public function getImage_id(){
        return $this->image_id;
    }
    public function setImage_id($image_id){
        $this->image_id = $image_id;
    }
    public function getPost_id(){
        return $this->post_id;
    }
    public function setPost_id($post_id){
        $this->post_id = $post_id;
    }
    public function getImage_data(){
        return $this->image_data;
    }
    public function setImage_data($image_data){
        $this->image_data = $image_data;
    }
    }
?>