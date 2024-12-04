<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/NotificationData.php';

class NotificationController
{
    private $notification;

    public function __construct()
    {
        $this->notification= new  NotificationData();
    }
    public function getNotifications($id_user) 
{
    return $this->notification->getNotifications($id_user);
}
public function addNotification($id_user, $type, $content, $post_id)
{
    return $this->notification->addNotification($id_user, $type, $content, $post_id);

}
public function getNotificationByPostAndUser($id_user, $post_id, $type)
{
    return $this->notification->getNotificationByPostAndUser($id_user, $post_id, $type);
}
public function deleteNotification($id_notification)
{
    return $this->notification->deleteNotification($id_notification);

}
}
