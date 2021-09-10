<?php 



function connectDB() : mysqli {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $DbName = 'BienesRaices_crud';
    
    $db = new mysqli($host, $user , $password , $DbName) ;

    if(!$db){
        echo 'error de conexión';
        exit;
    }

    return $db;
}