<?php

use MVC\Model;

class ModelsAttack extends Model{
  
    public $details;

    public function init(){
        $keys = array('_id', 'iyear', 'imonth', 'iday', 'country', 'region', 
            'provstate', 'city', 'latitude', 'longitude', 'success', 'attacktype',
            'targtype', 'gname', 'motive', 'weaptype', 'weapdetail', 'nkill'
            );

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

    public function toJson(){
        return json_encode($this->details);
    }

    function getAllTargets(){

        $cmd = new MongoDB\Driver\Command([
            'distinct' => 'terror',
            'key' => 'targtype'
        ]);
        $cursor = $this->mng->executeCommand('Terrorism', $cmd);
        $targets = current($cursor->toArray())->values;

        return $targets;
    }

    function getAllAttacktypes(){

        $cmd = new MongoDB\Driver\Command([
            'distinct' => 'terror',
            'key' => 'attacktype'
        ]);
        $cursor = $this->mng->executeCommand('Terrorism', $cmd);
        $attacktypes = current($cursor->toArray())->values;

        return $attacktypes;
    }
    
    function read(){
    
        $query = new MongoDB\Driver\Query([]); 
     
        $rows = $this->mng->executeQuery(DBA, $query);

        //print_r($rows);
    
        return $rows;
    }

    function find($params){
        
        $bulk = new MongoDB\Driver\BulkWrite;

        while (($key = array_search('all', $params)) !== false) {
            unset($params[$key]);
        }

        
        /*htmlspecialchars_decode(htmlspecialchars($params['targtype']));
        var_dump("Airports & Aircraft");
        var_dump($params['targtype']);*/

        $query = new MongoDB\Driver\Query($params);        

        $rows = $this->mng->executeQuery(DBA, $query);   
        
        if (isset($rows->database)){
            return null;
        }

        return $rows;                     
        
    }

    
}
?>