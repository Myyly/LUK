<?php 

class MessageModal{
    public $message_id;
    public $sender_id;
    public $receiver_id;
    public $message_content;
    public $sent_at;
    

    public function __construct($message_id,$sender_id,$receiver_id,$message_content,$sent_at){
        $this->message_id = $message_id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->message_content = $message_content;
        $this->sent_at= $sent_at;
    }
    public function getMessage_id(){
        return $this->message_id;
    }
    public function setMessage_id($message_id){
        $this->message_id = $message_id;
    }
    public function getSender_id(){
        return $this->sender_id;
    }
    public function setSender_id($sender_id){
        $this->sender_id = $sender_id;
    }
    public function getReceiver_id(){
        return $this->receiver_id;
    }
    public function setReceiver_id($receiver_id){
        $this->receiver_id = $receiver_id;
    }
    public function getMessage_content(){
        return $this->message_content;
    }
    public function setMessage_content($message_content){
        $this->message_content = $message_content;
    }
    public function getSent_at(){
        return $this->sent_at;
    }
    public function setSent_at($sent_at){
        $this->sent_at = $sent_at;
    }

    
    }
?>