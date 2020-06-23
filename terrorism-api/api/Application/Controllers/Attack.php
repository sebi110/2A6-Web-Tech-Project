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

        $form = ($this->request->post('form') != null) ? true : false;

        // find with GET from query, tu nu ai absolut nicio treaba cu asta
        if($form == false){

            $attack = $this->model('attack');
            $attack->init();
            $params = array();
            $form = ($this->request->post('form') != null) ? true : false;
            //$_SESSION['errors'] = array();
            //$_SESSION['attacks'] = array();            
        
            $count = ($this->request->get('count') != null) ? $this->request->get('count') : 10;
            foreach($attack->details as $key => $val){
                $params[$key] = ($this->request->get($key) != null) ? $this->request->get($key) : 'all';
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

                $this->send(200, $attacks_arr);
            }
        
            else{
                $this->send(404, array("message" => "No attacks found."));
            }
        }
        else{
            $attack = $this->model('attack');
            $attack->init();
            $params = array();
            $_SESSION['errors'] = array();
            $_SESSION['attacks'] = array();
            if($this->request->post('mode')!=null)
                $_SESSION['details']['mode']=$this->request->post('mode');
            if($this->request->post('frequency')!=null)
                $_SESSION['details']['frequency']=$this->request->post('frequency');

            $nr_sets = 1;
            
            $count = ($this->request->post('count') != null) ? $this->request->post('count') : 10;
            foreach($attack->details as $key => $val){
                $string = ($this->request->post($key) != null) ? $this->request->post($key) : 'all';
                if($string=='all') 
                {
                    $params[0][$key]='all';
                    continue;
                }
                $id = 0;
                $string_arr = explode (';',$string);
                foreach($string_arr as $string_set)
                {
                    $string_arr_el = explode(',',$string_set);
                    $actual = array();
                    foreach($string_arr_el as $string_el)
                    {
                        if(isset(COUNTABLE[$key]))
                        {
                            $str_int = explode('-',$string_el);
                            $first=-1;$last=-1;
                            foreach($str_int as $val_str)
                            {
                                $val_int=(int) $val_str;
                                if($first==-1)$first=$val_int;
                                $last=$val_int;
                            }
                            for($ind1=$first;$ind1<=$last;$ind1++)
                            {
                                $actual[]=(string)$ind1;
                            }
                        }
                        else
                            $actual[]=$string_el;
                    }
                    $params[$id][$key] = array( '$in' => $actual);
                    $id = $id + 1;
                }
                if($id > $nr_sets) $nr_set = $id;
            }
        
            $found_something = 0;
    
    
            foreach($params as $param)
            {
                $rows = $attack->find($param);
    
                if(!empty($rows)){
                    $found_something = 1;
    
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
                        $_SESSION['attacks'][] = $attacks_arr['records'];
                    }   
    
                }
                else
                    $_SESSION['attacks'][] = array();
            }
            
            $this->response->redirect('/terrorism-api/api/home/form');
        }
    }
}