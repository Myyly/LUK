<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/AccountData.php';
// require_once __DIR__ . '/../DAO/Profile.php';


class AccountController {
    private $account;
    // private $profile;

    public function __construct() {
        $this->account = new AccountData();
        // $this->profile = new ProfileData();
    }
    public function SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url,$signup_type){
        return $this->account->SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status,$cover_photo_url,$signup_type);
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
                            ///information about profile page
public function updateUserInfo($userId, $bio, $phoneNumber, $email, $gender, $dateOfBirth) {
    return $this->account->updateUserInfo($userId, $bio, $phoneNumber, $email, $gender, $dateOfBirth);
}
      /////////////////////////////////////////////////search/////////////////////////////
      public function searchAllUsersByKeyword($keyword) {
        return $this->account->searchAllUsersByKeyword($keyword);
}
public function searchFriendsByKeyword($idUser, $keyword) {
    return $this->account->searchFriendsByKeyword($idUser, $keyword);
}



// public function CreatePost($user_id, $content, $created_at, $emotion_id) {
//     return $this->profile->CreatePost($user_id, $content, $created_at, $emotion_id);
// }
// public function getAllPostsOfUser($user_id){
//     return $this->profile->getAllPostsOfUser($user_id);
// }
// public function AddPostImage($post_id, $image_data)
// {
//     return $this->profile->AddPostImage($post_id, $image_data);
// }
// public function getAllImagesOfPost($post_id){
//     return $this->profile->getAllImagesOfPost($post_id);
// }
// public function getImagesById($image_id){
//     return $this->profile->getImagesById($image_id);
// }
// public function getPostById($post_id){
//     return $this->profile->getPostById($post_id);
// }
// public function increaseLikeCount($post_id) {
//     return $this->profile->increaseLikeCount($post_id);
// }
// public function decreaseLikeCount($post_id) {
//     return $this->profile->decreaseLikeCount($post_id);
// }
// public function increaseCommentCount($post_id) {
//     return $this->profile->increaseCommentCount($post_id);
//     }
// public function deletePost($postId){
//     return $this->profile-> deletePost($postId);
// }
// public function decreaseCommentCount($post_id) {
//     return $this->profile->decreaseCommentCount($post_id);
// }
}
?>