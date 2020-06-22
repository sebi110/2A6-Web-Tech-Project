<?php

use MVC\Controller;

class ControllersAttack extends Controller {

    public function read() {

        $count = ($this->request->get('count') != null) ? $this->request->get('count') : 10;

        $attack = $this->model('attack');

        $rows = $attack->read();
        
        if(!empty($rows)){

            $attacks_arr=array();
            $attacks_arr["records"]=array();

            foreach ($rows as $row) {

                $attack_info=array();

                foreach($row as $key => $val){
                    $attack_info[$key] = $val;
                }

                array_push($attacks_arr["records"], $attack_info);

                if(count($attacks_arr['records']) == $count){
                    break;
                }
                
            }
            
            $this->send(200, $attacks_arr);            
        }
        else{

            $this->send(400, array("message" => "No attacks found."));
        }
    }

    public function find() {

        // POST from form        

        $attack = $this->model('attack');
        $attack->init();
        $params = array();
        $form = ($this->request->post('form') != null) ? true : false;
        $_SESSION['errors'] = array();
        $_SESSION['attacks'] = array();

        if($form == true){
            $count = ($this->request->post('count') != null) ? $this->request->post('count') : 10;
            foreach($attack->details as $key => $val){
                $params[$key] = ($this->request->post($key) != null) ? $this->request->post($key) : 'all';
            }
        }
        else{
            $count = ($this->request->get('count') != null) ? $this->request->get('count') : 10;
            foreach($attack->details as $key => $val){
                $params[$key] = ($this->request->get($key) != null) ? $this->request->get($key) : 'all';
            }
        }
        
        $rows = $attack->find($params);
       
        if(!empty($rows)){

            $attacks_arr=array();
            $attacks_arr["records"]=array();

            foreach ($rows as $row) {

                $attack_info=array();

                foreach($row as $key => $val){
                    $attack_info[$key] = $val;
                }

                array_push($attacks_arr["records"], $attack_info);

                if(count($attacks_arr['records']) == $count){
                    break;
                }
                
            }

            if (session_status() == PHP_SESSION_ACTIVE) {
                $_SESSION['attacks'] = $attacks_arr['records'];
            }

            $form == true ? $this->response->redirect('/terrorism-api/api/home/form') : $this->send(200, $attacks_arr);
        }
        
        else{
            $this->send(404, array("message" => "No attacks found."));
            
        }
    }
    
}