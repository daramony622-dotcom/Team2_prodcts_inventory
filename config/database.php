<?php
    $host = 'localhost';
    $username = 'root';
    $db = '';
    $password = '';

    
    try{
        $db = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8mb4",
            $username, $password,
            [ 
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
            
        );
    }catch (PDOException $e){
        die(json_encode(['status'=>false, 'message'=>'Error connection Database!']));
    }
    

?>