<?php
// MVC/Controllers/Account.php

require_once __DIR__ . '/../DAO/Emotions.php';

class EmotionsController
{
    private $emotion;

    public function __construct()
    {
        $this->emotion = new EmotionsData();
    }
    public function getAllEmotions()
    {
        return $this->emotion->getAllEmotions();
    }
    public function getEmotionById($id){
        return $this->emotion->getEmotionById($id);
    }
}
