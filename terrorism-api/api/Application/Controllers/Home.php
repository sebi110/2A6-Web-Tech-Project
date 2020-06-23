<?php

use MVC\Controller;

class ControllersHome extends Controller {

    public function register() {
        $this->view('register');
    }    

    public function index() {
        $this->view('index');
    }  

    public function login() {
        $this->view('login');
    }  

    public function admin() {
        
        $this->view('admin', [
            'meth' => array('GET','POST','DELETE','PUT'),
            'keys' => array('username', 'email', 'user_type', 'password')
        ]);
    } 

    public function form() {
        
        $this->view('form', [
            'mode' => array('map','PieChart','BarChart','LineChart'),
            'frequency' => array('year', 'month', 'day', 'country', 'region', 
                                'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
                                'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill'
            ),
            'countable' => COUNTABLE,
            'attacktypes' => $this->model('attack')->getAllAttacktypes(),
            'targets' => $this->model('attack')->getAllTargets()
        ]);
    }
    
    public function map(){
        require_once SERVICES . "map.php";
    }

    public function graph(){
        require_once SERVICES . "graph.php";
    }
    
}