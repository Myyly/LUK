<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/MessageData.php';

class MessageController
{
    private $message;

    public function __construct()
    {
        $this->message = new  MessageData();
    }
    public function getConversations($user_id)
    {
        return $this->message->getConversations($user_id);
    }
    public function getChatDetails($user_id, $other_user_id)
{
    return $this->message->getChatDetails($user_id, $other_user_id);
}
public function addMessage($sender_id, $receiver_id, $message_content)
{
    return $this->message->addMessage($sender_id, $receiver_id, $message_content);
}

}
