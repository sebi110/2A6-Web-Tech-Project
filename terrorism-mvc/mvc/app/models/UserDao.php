<?php


class UserDao {

    public function __construct(){

    }

    function cleanup(){
        global $mng;

        $bulk = new MongoDB\Driver\BulkWrite;
        
        $bulk->delete(['user_type' => 'user'], ['limit' => FALSE]);
            
        $mng->executeBulkWrite('Terrorism.users', $bulk);
       
    }

    function insert($user){

        global $mng;
        require_once 'User.php';
        
        $bulk = new MongoDB\Driver\BulkWrite;
        
        $details = $user->get();

        $doc = [
            '_id' => new MongoDB\BSON\ObjectID, 
            'username' => $details['username'],
            'email' => $details['email'],
            'user_type' => $details['user_type'],
            'password' => $details['password']
        ]; 

        $user->set($doc);
        
        $bulk->insert($doc);
        $mng->executeBulkWrite('Terrorism.users', $bulk);
    

    }

    function find($id){

        global $mng;
        require_once 'User.php';

        // security
        
        $id = (string)$id;

        $filters = ['_id' => $id];
        $query = new MongoDB\Driver\Query($filters);     
    
        $rows = $mng->executeQuery("Terrorism.users", $query);

        $users = [];
        foreach ($rows as $row) {
            $user = new User();
            $user->set($row);
            $users[] = $user;
        }         

        return $users == [] ? [] : $users[0];

    }

    function findByUsername($username){

        global $mng;
        require_once 'User.php';
        
        $filters = ['username' => $username];
        $query = new MongoDB\Driver\Query($filters);     
    
        $rows = $mng->executeQuery("Terrorism.users", $query);

        $users = [];
        foreach ($rows as $row) {
            $user = new User();
            $user->set($row);
            $users[] = $user;
        }         

        return $users == [] ? [] : $users[0];

    }

    function findLog($username, $password){

        global $mng;
        require_once 'User.php';

        /*echo '<br><br>';
        echo $username;
        echo '<br><br>';
        echo $password;
        echo '<br><br>';*/

        $filters = ['username' => $username, 'password' => $password];
        $query = new MongoDB\Driver\Query($filters);     
    
        $rows = $mng->executeQuery("Terrorism.users", $query);

        $users = [];
        foreach ($rows as $row) {
            $user = new User();
            $user->set($row);
            $users[] = $user;
        }         

        return $users == [] ? [] : $users[0];

    }

}