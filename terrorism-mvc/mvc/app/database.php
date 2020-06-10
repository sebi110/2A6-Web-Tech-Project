<?php
   
    try{
        $mng = new MongoDB\Driver\Manager(
        
            "mongodb+srv://some_user:some_password@cluster0-k9i77.mongodb.net/test?retryWrites=true&w=majority"
        );


    } catch (MongoDB\Driver\Exception\Exception $e) {

        $filename = basename(__FILE__);
        
        echo "The $filename script has experienced an error.\n"; 
        echo "It failed with the following exception:\n";
        
        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";       
    }
    
