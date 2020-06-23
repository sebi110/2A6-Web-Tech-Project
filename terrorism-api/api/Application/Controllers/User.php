<?php

use MVC\Controller;

class ControllersUser extends Controller {

    public function read() {

        $user = $this->model('user');

        $rows = $user->read();
        
        if(!empty($rows)){

            $users_arr=array();
            $users_arr["records"]=array();

            foreach ($rows as $row) {

                $user_info=array();

                foreach($row as $key => $val){
                    $user_info[$key] = $val;
                }

                array_push($users_arr["records"], $user_info);
                
            }
            
            $this->send(200, $users_arr);            
        }
        else{

            $this->send(400, array("message" => "No users found."));
        }
    }

    public function read_one($val1 = null) {

        if($this->request->get('username') == null && $val1 == null){
            $this->send(400, array("message" => "Unable to find user. Data is incomplete, pls specify the username."));
            die();
        }

        $user = $this->model('user');
        $user->init();
        $user->setKey('username', 
            ($val1 == null) ? $this->request->get('username') : $val1
        );
            
        $user->readOne();
        
        if($user->details['password'] != null){

            $this->send(200, $user->details);
        }
        
        else{
            $this->send(400, array("message" => "User does not exist."));
        }
    }

    public function find() {

        // from a form => post
        // else a get

        $user = $this->model('user');
        $user->init();
        $params = array();
        $form = ($this->request->post('form') != null) ? true : false;
        $_SESSION['errors'] = array();

        //POST
        if($form == true){
            foreach($user->details as $key => $val){
                $params[$key] = ($this->request->post($key) != null) ? $this->request->post($key) : 'all';
            }
        }
        // GET
        else{
            foreach($user->details as $key => $val){
                $params[$key] = ($this->request->get($key) != null) ? $this->request->get($key) : 'all';
            }
        }

        $params['password'] = md5($params['password']);
        $rows = $user->find($params);
       
        if(!empty($rows)){

            $users_arr=array();
            $users_arr["records"]=array();

            foreach ($rows as $row) {

                $user_info=array();

                foreach($row as $key => $val){
                    $user_info[$key] = $val;
                }

                array_push($users_arr["records"], $user_info);
                
            }

            if (session_status() == PHP_SESSION_ACTIVE) {
                $_SESSION['user'] = $user_info;
                $_SESSION['form'] = $this->request->post('form');
            }

            if($form == true && empty($user_info)){
                array_push($_SESSION['errors'], "Wrong username/password!");
                $this->response->redirect('/terrorism-api/api/home/login');
                die();
            }

            //$form == true ? $this->response->redirect('/terrorism-api/api/home/index') : $this->send(200, $users_arr);

            $form == true ? ($_SESSION['user']['user_type'] == 'admin' ? $this->response->redirect('/terrorism-api/api/home/admin')
                    : $this->response->redirect('/terrorism-api/api/home/index'))
                    : $this->send(200, $users_arr);
        }
        
        else{
            // issue
            $this->send(404, array("message" => "No users found."));
            
        }
    }

    public function create() {

        // check if username already exists
        // 2 cases : from form or postman

        /*
        {
            "username" : "panda",
            "email" : "panda@eyes.com",
            "user_type" : "user",
            "password" : "sirens"
        }*/

        $method = $this->request->post('REQUEST_METHOD');
        $user = $this->model('user');
        $user->init();
        $form = ($this->request->post('form') != null || $method != null) ? true : false;
        $_SESSION['errors'] = array();

        // from a form
        if($form == true){
            
            foreach($user->details as $key => $val){

                if($key == 'user_type'){
                    if($this->request->post($key) == null){
                        $user->setKey($key, 'user');
                    }
                    else{
                        // to do
                        $user->setKey($key, ($this->request->post($key) == 'Admin') ? 'admin' : 'user');
                    }
                    continue;
                }

                if($key == 'password'){
                    if($this->request->post('password_1') != $this->request->post('password_2')){
                        
                        array_push($_SESSION['errors'], "The passwords do not match!");
                        $method == null ? $this->response->redirect('/terrorism-api/api/home/register') 
                            : $this->send(400, array("message" => "Unable to create user. Passwords dont match."));
                        die();
                    }
                    $user->setKey($key, $this->request->post('password_1'));
                    continue;
                }

                if($key != '_id' && $this->request->post($key) == null){
                    $this->send(400, array("message" => "Unable to create user. Data is incomplete."));
                    die();
                }
                $user->setKey($key, $this->request->post($key));
            }
        }

        // from post body
        else{
            foreach($user->details as $key => $val){

                if($key != '_id' && $this->request->input($key) == null){
                    $this->send(400, array("message" => "Unable to create user. Data is incomplete."));
                    die();
                }
                $user->setKey($key, $this->request->input($key));
            }
        }
        
        // check for another guy with the same username

        $rows = null;//$user->find(['username' => $user->details['username']]);

        if(!empty($rows)){
            array_push($_SESSION['errors'], "Username already taken!");
            if($method == true || $form == false){
            $this->send(400, array("message" => "Username already taken."));
            } 
            else{
                $this->response->redirect('/terrorism-api/api/home/register');
            }
            //$form == true ? $this->response->redirect('/terrorism-api/api/home/register') : $this->send(400, array("message" => "Username already taken."));
            die();
        }
        
        $user->details['password'] = md5($user->details['password']);
        if($user->create()){

            if (session_status() == PHP_SESSION_ACTIVE && $method == false) {
                $_SESSION['user'] = $user->details;
            }

            if($method == true || $form == false){
            $this->send(201, array("message" => "User was created."));
            } 
            else{
                $this->response->redirect('/terrorism-api/api/home/index');
            }

            //$form == true ? $this->response->redirect('/terrorism-api/api/home/index') : $this->send(201, array("message" => "User was created."));
        }
        else{
        
            $this->send(503, array("message" => "Unable to create user."));        
        }     
    }

    public function delete($val1 = null) {

        /*
        {
            "username" : "panda"
        }*/

        $user = $this->model('user');
        $user->init();

        if($this->request->get('username') != null){
            $user->setKey('username', $this->request->get('username'));

        }
        else if($val1 != null){
            $user->setKey('username', $val1);

        }
        else {
            $user->setKey('username', $this->request->input('username'));
        }
        
        if($user->delete()){
            $this->send(200, array("message" => "User was deleted.")); 
        }
        
        else{
            $this->send(503, array("message" => "Unable to delete user.")); 
        }
    }

    public function update() {

        /*
        {
            "email" : "panda@eyes.com",
            "user_type" : "user",
            "password" : "chime"
        }*/

        $form = !$this->request->post('REQUEST_METHOD') ? false : true; 

        if($this->request->get('username') == null && $form == false){
            $this->send(400, array("message" => "Unable to find user. Data is incomplete, pls specify the username."));
            die();
        }

        $user = $this->model('user');
        $user->init();
        $user->setKey('username', $form == false ? $this->request->get('username') : $this->request->post('val1'));

        if($form){

            $params = array(
                'email' => $this->request->post('email'),
                'user_type' => $this->request->post('user_type') == 'Admin' ? 'admin' : 'user',
                'password' => $this->request->post('password')
            );

            if($user->update($params)){
                $this->send(200, array("message" => "User was updated.")); 
                die();
            }
        }
        else if($user->update($this->request->postBody())){
            $this->send(200, array("message" => "User was updated.")); 
            die();
        }
        
        $this->send(503, array("message" => "Unable to update user."));
        
    }

    public function form(){
        // treat case when null

        $method = $this->request->post('REQUEST_METHOD');

        switch( $method ) {
            case "GET":
                //$this->read();
                ($this->request->post('key1') == null) ? $this->read() 
                : $this->read_one($this->request->post('val1'));
                break;
        
            case "POST":
                $this->create(); 
                break;        
        
            case "DELETE":
                ($this->request->post('key1') == null) ? $this->delete() 
                : $this->delete($this->request->post('val1'));
                break;
        
            case "PUT":
                $this->update();
                break;
        
            default:
                $this->response->redirect('/terrorism-api/api/home/login');
                //$this->send(501, array("message" => "Cannot use this method.")); 
                die();
        }
    }

    
}