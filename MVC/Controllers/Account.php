<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/Account.php';

class AccountController {
    private $account;

    public function __construct() {
        $this->account = new AccountData();
    }
    public function SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status){
        return $this->account->SignUp($email, $phone_number, $password_hash, $full_name, $date_of_birth, $gender, $profile_picture_url, $bio, $status);
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


}
?>