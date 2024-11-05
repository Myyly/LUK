<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/Account.php';

class AccountController {
    private $account;

    public function __construct() {
        $this->account = new AccountData();
    }
    public function SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url){
        return $this->account->SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url);
    }
    public function checkEmailExist($email){
        return $this->account->checkEmailExist($email);
    }
    public function LoginByEmail($email){
        return $this->account->LoginByEmail($email);
    }
    public function LoginByPhoneNumber($email){
        return $this->account->LoginByPhoneNumber($email);
    }
    public function resetPassword($email,$newpass){
        return $this->account->resetPassword($email,$newpass);
    }  
    public function findUserbyId($id){
        return $this->account->findUserbyId($id);
    }
    public function updateAvatar($id, $imageData) {
        return $this->account->updateAvatar($id,$imageData);
}
public function updateCover($id, $imageData) {
    return $this->account->updateCover($id,$imageData);
}
public function updateUserProfile($id, $profile_picture_url, $cover_photo_url, $bio) {
    return $this->account->updateUserProfile($id,$profile_picture_url,$cover_photo_url,$bio);
}
public function getTotalFriends($userId) {
    return $this->account->getTotalFriends($userId);
}
public function getFriendsList($userId) {
    return $this->account->getFriendsList($userId);
}
public function unfriend($userId, $friendId) {
        return $this->account->unfriend($userId,$friendId);
}
public function getMutualFriendsCount($userId1, $userId2) {
    return $this->account->getMutualFriendsCount($userId1,$userId2);
}
public function checkFriendshipStatus($userId1, $userId2) {
    return $this->account->checkFriendshipStatus($userId1, $userId2);
}
public function acceptFriendRequest($userId, $friendId) {
    return $this->account->acceptFriendRequest($userId, $friendId);
}
public function addFriend($userId, $friendId) {
    return $this->account->addFriend($userId, $friendId);
}
public function searchFriendsByFullName($idUser, $fullName) {
    return $this->account->searchFriendsByFullName($idUser, $fullName);
}
}

?>