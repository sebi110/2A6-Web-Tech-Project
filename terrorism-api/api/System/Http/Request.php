<?php

namespace Http;

class Request {

    public $cookie;

    public $request;

    public $files;

    public function __construct() {       
        $this->request = ($_REQUEST);

        // dont know how to use these yet, will delete later
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
    }

    // $_GET
    public function get(String $key = '') {
        if ($key != '')
            return isset($_GET[$key]) ? $this->clean($_GET[$key]) : null;

        return  $this->clean($_GET);
    }

    // $_POST
    public function post(String $key = '') {
        if ($key != '')
            return isset($_POST[$key]) ? $this->clean($_POST[$key]) : null;

        return  $this->clean($_POST);
    }

    // POST parameter(Body-raw)
    public function input(String $key = '') {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($key != '') {
            return isset($request[$key]) ? $this->clean($request[$key]) : null;
        } 

        return ($request);
    }

    public function postBody() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if(empty($request)){
            return null;
        }

        foreach($request as $key => $val){
            $request[$key] = isset($request[$key]) ? $this->clean($request[$key]) : null;
        }

        return ($request);
    }

    public function server(String $key = '') {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }

    public function getMethod() {
        return strtoupper($this->server('REQUEST_METHOD'));
    }

    public function getClientIp() {
        return $this->server('REMOTE_ADDR');
    }

    public function getUrl() {
        return $this->server('QUERY_STRING');
    }

    private function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            // an easy fix, for now its enough
            if($data != 'Airports & Aircraft' && $data != 'Private Citizens & Property' && $data != 'Journalists & Media')
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}