<?php


class AttackDao {

    public function __construct(){

    }

    function cleanup(){

        global $mng;
        $bulk = new MongoDB\Driver\BulkWrite;
        for($i=0; $i<=12; $i++){
            $bulk->delete(['imonth' => "$i"], ['limit' => FALSE]);
        }
    
        $mng->executeBulkWrite('Terrorism.terror', $bulk);
       
    }

    function setup(){

        // ~MYSTERY~ x2

        $this->cleanup();

        global $mng;

        $bulk = new MongoDB\Driver\BulkWrite;        

        $row = 0;
        if (($handle = fopen(__DIR__ . '/../misc/resources/globalterrorismdb.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

                $num = count($data);
                $row++;             
                if($row == 1){
                    continue;
                }

                $doc = [
                    '_id' => new MongoDB\BSON\ObjectID, 
                    'iyear' => 0,
                    'imonth' => 0,
                    'iday' => 0,
                    'country' => 0,
                    'region' => 0,
                    'provstate' => 0,
                    'city' => 0,
                    'latitude' => 0,
                    'longitude' => 0,
                    'success' => 0,
                    'attacktype' => 0,
                    'targtype' => 0,
                    'gname' => 0,
                    'motive' => 0,
                    'weaptype' => 0,
                    'weapdetail' => 0,
                    'nkill' => 0
                ];

                

                $c=0;
                $array_keys = array_keys($doc);
                foreach ($array_keys as $array_key) {
                    if($array_key != '_id'){
                    
                        $doc[$array_key] = $data[$c];
                        $c++;
                    }
                }
    
                $bulk->insert($doc);

                echo '<br>';
                echo $row;
                //echo '<br>';
                //print_r($doc);

            }
            $mng->executeBulkWrite('Terrorism.terror', $bulk);
            fclose($handle);
        }

    }

    function find($params){

        require_once 'Attack.php';

        global $mng;
        // security
        
        foreach($params as $key => $value){
            $params[$key] = (string)$value;
        }

        while (($key = array_search('all', $params)) !== false) {
            unset($params[$key]);
        }
        if(isset($params['count'])){
            $count = $params['count'];
            unset($params['count']);
        }
        else $count = 1000;
        $query = new MongoDB\Driver\Query($params);     

        $rows = $mng->executeQuery("Terrorism.terror", $query);

        $attacks = [];
        $i=0;
        foreach ($rows as $row) {
            if($i==$count){
                break;
            }
            $a = new Attack();
            $a->setKeys($row);
            $attacks[] = $a;
            $i++;
        }           
        return $attacks;

    }

    function delete($attack){
        
        global $mng;
        require_once 'Attack.php';

        $bulk = new MongoDB\Driver\BulkWrite;
    
        $bulk->delete(['_id' => $attack->_id]);
    
        $mng->executeBulkWrite('Terrorism.terror', $bulk);
        
    }

    function getAll($count = 10){
        global $mng;
        require_once 'Attack.php';

        //security
        $count = (string)$count;

        $query = new MongoDB\Driver\Query([]); 
     
        $rows = $mng->executeQuery("Terrorism.terror", $query);
        
        $attacks = [];
        $i=0;
        foreach ($rows as $row) {
            if($i==$count){
                break;
            }
            $a = new Attack();
            $a->set($row);
            $attacks[] = $a;
            $i++;
        }   

        return $attacks;
    }

    function getAllTargets(){

        global $mng;
        $cmd = new MongoDB\Driver\Command([
            'distinct' => 'terror',
            'key' => 'targtype'
        ]);
        $cursor = $mng->executeCommand('Terrorism', $cmd);
        $targets = current($cursor->toArray())->values;

        return $targets;
    }
}
