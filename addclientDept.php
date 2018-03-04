<?php

session_start();
include("config.php");

$clientIDValue = $_POST['clientID'];
$deptIDValue = $_POST['deptID'];

$created_at = date("Y-m-d H:i:s");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO cmg_client_depart (clientID, deptID, created_at) 
    VALUES (:clientID, :deptID, :created_at)");
	
    $stmt->bindParam(':clientID', $clientID);
    $stmt->bindParam(':deptID', $deptID);
    $stmt->bindParam(':created_at', $created_at);

    // insert a row	
    $clientID = $clientIDValue;    
    $deptID = $deptIDValue;    
    $created_at = $created_at;
    $stmt->execute();

    echo("success");

} catch(PDOException $e){

    echo "Error: " . $e->getMessage();

}

?>