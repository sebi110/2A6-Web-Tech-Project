<?php


class App{

    protected $controller = 'home';

    protected $method = 'index';

    protected $params = [];

    public function __construct(){

        $url = $this->parseUrl();

        /*echo '<br><br>';
        print_r($url);
        echo '<br><br>';*/


        if(file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')){
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        //echo $this->controller;
        //echo '<br><br>';


        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        //echo $this->method;
        //echo '<br><br>';

        $this->params = [];

        foreach($_GET as $key => $val) {
            if ($key == 'url') {
                continue;
            }
            
            $this->params[$key] = $val;
        }

        call_user_func_array([$this->controller, $this->method], array($this->params));

    }

    public function parseUrl(){
        print_r($_GET);
        if(isset($_GET['url'])){
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }        
        
    }
}
