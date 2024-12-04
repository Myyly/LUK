<?php 

class NotificationModal{
    public $id_notification;
    public $id_user;
    public $type;
    public $content;
    public $is_read;
    public $created_at;
    public $post_id;
    

    public function __construct($id_notification,$id_user,$type,$content,$is_read,$created_at,$post_id){
        $this->id_notification = $id_notification;
        $this->id_user = $id_user;
        $this->type = $type;
        $this->content = $content;
        $this->is_read= $is_read;
        $this->created_at= $created_at;
        $this->post_id= $post_id;
    }
    public function getId_notification (){
        return $this->id_notification ;
    }
    public function setId_notification($id_notification){
        $this->id_notification= $id_notification;
    }
    public function getId_user (){
        return $this->id_user ;
    }
    public function setId_user($id_user){
        $this->id_user= $id_user;
    }
    public function getType  (){
        return $this->type  ;
    }
    public function setType ($type ){
        $this->type= $type ;
    }
    public function getContent  (){
        return $this->content  ;
    }
    public function setContent ($content ){
        $this->content= $content ;
    }
    public function getIs_read  (){
        return $this->is_read  ;
    }
    public function setIs_read ($is_read ){
        $this->is_read= $is_read ;
    }
    public function getCreated_at  (){
        return $this->created_at ;
    }
    public function setCreated_at ($created_at ){
        $this->created_at= $created_at ;
    }
    public function getPost_id  (){
        return $this->post_id ;
    }
    public function setPost_id($post_id){
        $this->post_id= $post_id ;
    }
    
   
    }
?>