<?php


class User {

    private $details;

    public function __construct(){

        $keys = array('_id', 'username', 'email', 'user_type', 'password');

        $this->details = array_fill_keys($keys, 0);
    }

    public function set($row){

        $this->details = $row;

    }

    public function get(){

        return $this->details;
    }

    public function toJson(){
        return json_encode($this->details);
    }

}