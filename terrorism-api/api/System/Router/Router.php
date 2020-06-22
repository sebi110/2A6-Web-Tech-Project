<?php

namespace Router;

class Router {

    private $routes = [];

    private $routeMatches = [];

    private $url;

    private $method;

    private $params = [];

    private $response;

    public function __construct(string $url, string $method) {
        $this->url = rtrim($url, '/');
        $this->method = $method;

        $this->response = $GLOBALS['response'];
    }


    public function get($pattern, $callback) {
        $this->addRoute("GET", $pattern, $callback);
    }

    public function post($pattern, $callback) {
        $this->addRoute('POST', $pattern, $callback);
    }

    public function put($pattern, $callback) {
        $this->addRoute('PUT', $pattern, $callback);
    }

    public function delete($pattern, $callback) {
        $this->addRoute('DELETE', $pattern, $callback);
    }

   
    public function addRoute($method, $pattern, $callback) {
        array_push($this->routes, new Route($method, $pattern, $callback));
    }

    private function getRouteMatches(){
        $parts = explode('&', $this->url);

        foreach ($this->routes as $value) {
            if (strtoupper($this->method) == $value->getMethod() && cleanUrl($parts[0]) == $value->getPath() )
                array_push($this->routeMatches, $value);
        }

    }

    public function getRoutes() {
        return $this->routes;
    }

    private function setParams($key, $value) {
        $this->params[$key] = $value;
    }

    /**
     *  run application
     */
    public function run() {

        if (!is_array($this->routes) || empty($this->routes)) 
            throw new Exception('NON-Object Route Set');

        $this->getRouteMatches();

        foreach($_REQUEST as $key => $val) {
            if($val != null){
                $this->setParams($key, urlencode($val));
            }
        }
        
        if(empty($this->routeMatches)){
            $this->sendNotFound();
            die();
        }
        
        if (is_callable($this->routeMatches[0]->getCallback()))
            call_user_func($this->routeMatches[0]->getCallback(), $this->params);
        else
            $this->runController($this->routeMatches[0]->getCallback(), $this->params);
        
    }

    /**
     * run as controller
     */
    private function runController($controller, $params) {

        $parts = explode('@', $controller);
        $file = CONTROLLERS . ucfirst($parts[0]) . '.php';

        if (file_exists($file)) {
            require_once($file);

            // controller class
            $controller = 'Controllers' . ucfirst($parts[0]);

            if (class_exists($controller))
                $controller = new $controller();
            else
				$this->sendNotFound();

            // set function in controller
            if (isset($parts[1])) {
                $method = $parts[1];
				
                if (!method_exists($controller, $method))
                    $this->sendNotFound();
				
            } else {
                $method = 'index';
            }

            // call to controller
            if (is_callable([$controller, $method]))
                return call_user_func([$controller, $method], $params);
            else
				$this->sendNotFound();
        }
    }
	
	private function sendNotFound() {
		$this->response->sendStatus(404);
        $this->response->setContent(['error' => 'Sorry This Route Not Found !', 'status_code' => 404]);
        $this->response->render();
	}
}