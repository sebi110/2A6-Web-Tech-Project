<?php

use MVC\Controller;

class ControllersHome extends Controller {

    public function hi() {

        $name = ($this->request->get('name') != null) ? $this->request->get('name') : 'pyro';
        $mood = ($this->request->get('mood') != null) ? $this->request->get('mood') : 'cynical';

        $this->response->sendStatus(200);
        $this->response->setContent(array($name, $mood));
        $this->view('home', array('name' => $name, 'mood' => $mood));
    }

    public function register() {

        $this->response->sendStatus(200);
        $this->view('register');
    }    

    public function index() {
        
        $this->response->sendStatus(200);
        $this->view('index');
    }  

    public function login() {

        
        $this->response->sendStatus(200);
        $this->view('login');
    }  

    public function admin() {

        
        $this->response->sendStatus(200);
        $this->view('admin', [
            'meth' => array('GET','POST','DELETE','PUT'),
            'keys' => array('username', 'email', 'user_type', 'password')
        ]);
    } 

    public function form() {

        $this->response->sendStatus(200);
        
        $this->view('form', [
            'mode' => array('map','PieChart','BarChart','LineChart'),
            'frequency' => array('year', 'month', 'day', 'country', 'region', 
                                'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
                                'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill'
            ),
            'countable' => array(
                'iyear'   => array('Year',1970,2017),
                'imonth'  => array('Month',0,12),
                'iday'    => array('Day',0,31),
                'count'   => array('Count',1,1000),
                'success' => array('Was it a succes?(0=false,1=true)',0,1)
            ),
            'attacktypes' => $this->model('attack')->getAllAttacktypes(),
            'targets' => $this->model('attack')->getAllTargets()
        ]);
    }
    
    // I don't even know what I'm doing at this point
    public function map(){
        require_once SERVICES . "map.php";
    }
    
}