<?php
require_once 'dbconfig.php';

$dsn= "mysql:host=$host;dbname=$db";

try{
    $conn = new PDO($dsn, $username, $password);

    if($conn){
        echo "Connected to the <strong>$db</strong> database successfully!";
    }
}catch (PDOException $e){
    echo $e->getMessage();
}