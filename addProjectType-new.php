<?php

session_start();

include("config.php");

$projectTypeValue = $_POST['projectType'];
$created_at = date("Y-m-d H:i:s");

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO cmg_projecttype (projectType, created_at) 
    VALUES (:projectType, :created_at)");
    $stmt->bindParam(':projectType', $projectType);
    $stmt->bindParam(':created_at', $created_at);
    	    
    // insert a row
    $projectType = $projectTypeValue;	
    $created_at = $created_at;    
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>