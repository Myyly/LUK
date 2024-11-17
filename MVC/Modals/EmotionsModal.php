<?php 
class EmotionsModal{
    public $id;
    public $name;
    public $image;
    public function __construct($id,$name,$image){
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getImage(){
        return $this->image;
    }
    public function setImage($image){
        $this->image = $image;
    }
    }
?>