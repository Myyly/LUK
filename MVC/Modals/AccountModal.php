<?php 

class AccountModal{
    public $user_id;
    public $email;
    public $phone_number;
    public $password_hash;
    public $full_name;
    public $profile_picture_url;
    public $bio;
    public $date_of_birth;
    public $gender;
    public $create_at;
    public $update_at;
    public $last_active;
    public $status;

    public function __construct($user_id,$email,$phone_number,$password_hash,$full_name,$profile_picture_url,$bio,$date_of_birth,$gender,$create_at,$update_at,$last_active,$status){
        $this->user_id = $user_id;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->password_hash = $password_hash;
        $this->full_name= $full_name;
        $this->profile_picture_url = $profile_picture_url;
        $this->bio=$bio;
        $this->date_of_birth=$date_of_birth;
        $this->gender = $gender;
        $this->create_at = $create_at;
        $this->update_at=$update_at;
        $this->last_active=$last_active;
        $this->status=$status;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPhone_numberl(){
        return $this->phone_number;
    }
    public function setPhone_number($phone_number){
        $this->phone_number = $phone_number;
    }
    public function getPassword_hash(){
        return $this->password_hash;
    }
    public function setPasseord_hash($password_hash){
        $this->password_hash = $password_hash;
    }
    public function getFull_name(){
        return $this->full_name;
    }
    public function setFull_name($full_name){
        $this->full_name = $full_name;
    }
    public function getProfile_picture_url(){
        return $this->profile_picture_url;
    }
    public function setProfile_picture_url($profile_picture_url){
        $this->email = $profile_picture_url;
    }
    public function getBio(){
        return $this->bio;
    }
    public function setBio($bio){
        $this->bio = $bio;
    }
    public function getDate_of_birth(){
        return $this->date_of_birth;
    }
    public function setDate_of_birth($date_of_birth){
        $this->date_of_birth = $date_of_birth;
    }
    public function getGender(){
        return $this->gender;
    }
    public function setGender($gender){
        $this->gender = $gender;
    }
    public function getCreate_at(){
        return $this->create_at;
    }
    public function setCreate_at($create_at){
        $this->create_at = $create_at;
    }
    public function getUpdate_at(){
        return $this->update_at;
    }
    public function setUpdate_at($update_at){
        $this->update_at = $update_at;
    }
    public function getLast_active(){
        return $this->last_active;
    }
    public function setLast_active($last_active){
        $this->last_active = $last_active;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    }
?>