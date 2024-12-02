<?php 
class FriendModal{
    public $user_id;
    public $friend_id;
    public $status;
    public $requested_at;

    public function __construct($user_id,$friend_id,$status,$requested_at){
        $this->user_id = $user_id;
        $this->friend_id = $friend_id;
        $this->status = $status;
        $this->requested_at = $requested_at;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function getFriend_id(){
        return $this->friend_id;
    }
    public function setFriend_id($friend_id){
        $this->friend_id = $friend_id;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getRequested_at(){
        return $this->requested_at;
    }
    public function setRequested_at($requested_at){
        $this->status = $requested_at;
    }

    }

?>