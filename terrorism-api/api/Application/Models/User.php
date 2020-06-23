<?php

use MVC\Model;

class ModelsUser extends Model{
  
    public $details;

    public function init(){
        $keys = array('_id', 'username', 'email', 'user_type', 'password');
        $this->details = array_fill_keys($keys, 0);
    }

    public function setKey($key, $value){
        if(isset($this->details[$key])){
            $this->details[$key] = $value;
        }
    }

    public function setKeys($arr){
        foreach($arr as $key => $val){
            $this->setKey($key, $val);
        }
    }

    public function get(){
        return $this->details;
    }
    
    function read(){
    
        $query = new MongoDB\Driver\Query([]); 
     
        $rows = $this->mng->executeQuery(DBU, $query);

        //print_r($rows);
    
        return $rows;
    }

    function readOne(){
    
        $filters = ["username" => $this->details['username']];
        $query = new MongoDB\Driver\Query($filters);        

        $rows = $this->mng->executeQuery(DBU, $query);      

        foreach($rows as $row){
            $this->setKeys($row);
        }
        
    }

    function find($params){
        
        $bulk = new MongoDB\Driver\BulkWrite;

        while (($key = array_search('all', $params)) !== false) {
            unset($params[$key]);
        }
      
        $query = new MongoDB\Driver\Query($params);  
        
        //$params['username'] = 'a';

        $rows = $this->mng->executeQuery(DBU, $query);  
        
        /*if (isset($rows->database)){
            return null;
        }*/

        return $rows;  
    }

    function create(){

        $bulk = new MongoDB\Driver\BulkWrite;  

        $doc = [
            '_id' => new MongoDB\BSON\ObjectID, 
            'username' => $this->details['username'],
            'email' => $this->details['email'],
            'user_type' => $this->details['user_type'],
            'password' => $this->details['password']
        ];
    
        $bulk->insert($doc);

        // execute query
        if($this->mng->executeBulkWrite(DBU, $bulk)){
            return true;
        }
    
        return false;
        
    }

    function delete(){
    
        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->delete(['username' => $this->details['username']], ['limit' => FALSE]);
        
        if($this->mng->executeBulkWrite(DBU, $bulk)){
            return true;
        }
    
        return false;
    }

    function update($setParam){

        $filters = ["username" => $this->details['username']];
        $query = new MongoDB\Driver\Query($filters);        

        $rows = $this->mng->executeQuery(DBU, $query);  

        if(empty($rows)){
            return false;
        }

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->update(['username' => $this->details['username']], ['$set' => $setParam]);
                
        if($this->mng->executeBulkWrite(DBU, $bulk)){
            return true;
        }
    
        return false;
        
    }
}
?>