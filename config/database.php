<?php
// used to connect to the database
$host = "localhost";
$db_name = "lokijia7";
$username = "lokijia7";
$password = "_[IGHaihS4tyLM@l";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
     
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
