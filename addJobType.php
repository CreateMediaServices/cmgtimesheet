<?php

session_start();

include("config.php");
$clientIdValue = $_POST['clientId'];
$jobTypeValue = $_POST['jobType'];
$userNameValue = $_SESSION['uName'];
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO jobstypes (clientId, jobType) 
    VALUES (:clientId, :jobType)");
    $stmt->bindParam(':clientId', $clientId);
	$stmt->bindParam(':jobType', $jobType);
    
    // insert a row
    $clientId = $clientIdValue;
	$jobType = $jobTypeValue;    
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>