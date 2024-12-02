<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/FriendData.php';

class FriendController
{
    private $friend;    

    public function __construct()
    {
        $this->friend = new  FriendData();
    }
    public function getTotalFriends($userId) {
        return $this->friend->getTotalFriends($userId);
}
public function getFriendsList($userId) {
    return $this->friend->getFriendsList($userId);
}
public function unfriend($userId, $friendId) {
    return $this->friend->unfriend($userId, $friendId);
}
public function getMutualFriendsCount($userId1, $userId2) {
    return $this->friend->getMutualFriendsCount($userId1, $userId2);
}
public function checkFriendshipStatus($userId1, $userId2){
    return $this->friend->checkFriendshipStatus($userId1, $userId2);
}
public function acceptFriendRequest($userId, $friendId){
    return $this->friend->acceptFriendRequest($userId, $friendId);
}
public function addFriend($userId, $friendId){
    return $this->friend->addFriend($userId, $friendId);
}
public function searchFriendsByFullName($idUser, $fullName){
    return $this->friend->searchFriendsByFullName($idUser, $fullName);
}
}
