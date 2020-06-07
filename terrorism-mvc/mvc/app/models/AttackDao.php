<?php


class AttackDao {

    public function __construct(){

    }

    function cleanup(){
        include 'database.php';

        $bulk = new MongoDB\Driver\BulkWrite;
        for($i=0; $i<=12; $i++){
            $bulk->delete(['imonth' => "$i"], ['limit' => FALSE]);
        }
    
        $mng->executeBulkWrite('Terrorism.terror', $bulk);
       
    }

    function setup(){

        include 'database.php';
        
        $bulk = new MongoDB\Driver\BulkWrite;        

        $row = 1;
        if (($handle = fopen(__DIR__ . '/../misc/resources/globalterrorismdb.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

                $num = count($data);

                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;                

               
                
                if($row == 2){
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
                    'attacktype1' => 0,
                    'targtype1' => 0,
                    'targtype1_txt' => 0,
                    'gname' => 0,
                    'motive' => 0,
                    'weaptype1' => 0,
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

            }
            $mng->executeBulkWrite('Terrorism.terror', $bulk);
            fclose($handle);
        }

    }

    function findByYearAndTarget($year, $target, $count = 1){

        include 'database.php';
        require_once 'Attack.php';

        // security
        $year = (string)$year;
        $count = (string)$count;
        $target = (string)$target;

        $filter = [];
        $keys = array('iyear', 'targtype1_txt');

        $numargs = func_num_args();
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs - 1; $i++) {

            if($arg_list[$i] != 'all'){
                $filter[$keys[$i]] = $arg_list[$i];
            }
        }

        //$filter = [ 'iyear' => $year, 'targtype1_txt' => $target ]; 
        $query = new MongoDB\Driver\Query($filter);     
    
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
            //echo "$row->iyear : $row->city : $row->weaptype1<br>";
            $i++;
        }       

        return $attacks;

    }

    //function update($user);

    function delete($attack){
        include 'database.php';
        require_once 'Attack.php';

        $bulk = new MongoDB\Driver\BulkWrite;
    
        $bulk->delete(['_id' => $attack->_id]);
    
        $mng->executeBulkWrite('Terrorism.terror', $bulk);
        
    }

    function getAll($count = 10){
        include 'database.php';
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
            //echo "$row->iyear : $row->city : $row->weaptype1<br>";
            $i++;
        }   

        return $attacks;
    }

    function getAllTargets(){
        include 'database.php';

        $cmd = new MongoDB\Driver\Command([
            'distinct' => 'terror',
            'key' => 'targtype1_txt'
        ]);
        $cursor = $mng->executeCommand('Terrorism', $cmd);
        $targets = current($cursor->toArray())->values;

        return $targets;
    }
}