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

    public function read_one() {

        if($this->request->get('username') == null){
            $this->send(400, array("message" => "Unable to find user. Data is incomplete, pls specify the username."));
            die();
        }

        $user = $this->model('user');
        $user->init();
        $user->setKey('username', $this->request->get('username'));
            
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
        $form = false;
        $_SESSION['errors'] = array();

        if($this->request->getMethod() == 'POST'){
            $form = true;
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
            }

            if($form == true && empty($user_info)){
                array_push($_SESSION['errors'], "Wrong username/password!");
                $this->response->redirect('/terrorism-api/api/home/login');
                die();
            }

            $form == true ? $this->response->redirect('/terrorism-api/api/home/index') : $this->send(200, $users_arr);
            //$this->send(200, $users_arr);           
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

        $user = $this->model('user');
        $user->init();
        $form = false;
        $_SESSION['errors'] = array();

        // from a form
        if($this->request->postBody() == null){
            $form = true;
            foreach($user->details as $key => $val){

                if($key == 'user_type'){
                    if($this->request->post($key) == null){
                        $user->setKey($key, 'user');
                    }
                    else{
                        // to do
                    }
                    continue;
                }

                if($key == 'password'){
                    if($this->request->post('password_1') != $this->request->post('password_2')){
                        /*$this->response->setHeader(sprintf('HTTP/1.1 ' . $status . ' %s' , $this->response->getStatusCodeText($status)));
                        $this->response->setContent($msg);
                        $this->response->render();*/
                        //$this->send(400, array("message" => "Unable to create user. Passwords don't match."));
                        //$this->response->setHeader(sprintf('HTTP/1.1 ' . '400' . ' %s' , $this->response->getStatusCodeText(400)));
                        array_push($_SESSION['errors'], "The passwords do not match!");
                        $this->response->redirect('/terrorism-api/api/home/register');
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

        $rows = $user->find(['username' => $user->details['username']]);

        echo gettype($rows);

        if(!empty($rows)){
            array_push($_SESSION['errors'], "Username already taken!" .  gettype($rows));
            $this->response->redirect('/terrorism-api/api/home/register');
            die();
        }
        
        $user->details['password'] = md5($user->details['password']);
        if($user->create()){

            if (session_status() == PHP_SESSION_ACTIVE) {
                $_SESSION['user'] = $user->details;
            }

            $form == true ? $this->response->redirect('/terrorism-api/api/home/index') : $this->send(201, array("message" => "User was created."));
        }
        else{
        
            $this->send(503, array("message" => "Unable to create user."));        
        }     
    }

    public function delete() {

        /*
        {
            "username" : "panda"
        }*/

        $user = $this->model('user');
        $user->init();

        if($this->request->get('username') != null){
            $user->setKey('username', $this->request->get('username'));

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

        if($this->request->get('username') == null){
            $this->send(400, array("message" => "Unable to find user. Data is incomplete, pls specify the username."));
            die();
        }

        $user = $this->model('user');
        $user->init();
        $user->setKey('username', $this->request->get('username'));

        if($user->update($this->request->postBody())){
            $this->send(200, array("message" => "User was updated.")); 
        }
        
        else{
            $this->send(503, array("message" => "Unable to update user.")); 
        }
    }

    
}