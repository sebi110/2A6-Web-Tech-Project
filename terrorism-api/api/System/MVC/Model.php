<?php

namespace MVC;

class Model {

    public $mng;

    public function __construct() {

        $database = new \Database\Database();
    
        $this->mng = $database->getConnection();
    }
}