<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/EmotionData.php';

class EmotionController
{
    private $emotion;

    public function __construct()
    {
        $this->emotion = new EmotionData();
    }
    public function getAllEmotions()
    {
        return $this->emotion->getAllEmotions();
    }
    public function getEmotionById($id){
        return $this->emotion->getEmotionById($id);
    }
}
