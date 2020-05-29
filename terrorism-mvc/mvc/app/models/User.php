<?php

class User{

    private $name;
    private $mood;

    public function __construct($name, $mood){
        $this->name = $name;
        $this->mood = $mood;
    }

    public function getName(){
        return $this->name;
    }

    public function getMood(){
        return $this->mood;
    }
}