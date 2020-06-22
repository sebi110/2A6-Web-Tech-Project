<?php

namespace Router;

final class Route {
    
    private $method;

    private $path;

    private $callback;

    private $list_method = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];


    public function __construct(String $method, String $path, $callback) {
        $this->method = $this->validateMethod(strtoupper($method));
        $this->path = cleanUrl($path);
        $this->callback = $callback;
    }

    private function validateMethod(string $method) {
        if (in_array(strtoupper($method), $this->list_method)) 
            return $method;
        
        throw new Exception('Invalid Method Name');
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPath() {
        return $this->path;
    }

    public function getCallback() {
        return $this->callback;
    }
}