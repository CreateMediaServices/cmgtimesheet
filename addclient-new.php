<?php
session_start();

include("config.php");

$projectTypeValue = $_POST['projectType'];
$clientNameValue = $_POST['clientName'];
$jobIDValue = $_POST['jobID'];

$created_at = date("Y-m-d H:i:s");

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO cmg_clients (clientName, porjectType, jobID, created_at) 
    VALUES (:clientName, :porjectType, :jobID, :created_at)");

	$stmt->bindParam(':clientName', $clientName);
    $stmt->bindParam(':porjectType', $porjectType);
    $stmt->bindParam(':jobID', $jobID);    
    $stmt->bindParam(':created_at', $created_at);
    
    // insert a row
	$clientName = $clientNameValue;
    $porjectType = $projectTypeValue;
    $jobID = $jobIDValue;    
    $created_at = $created_at;
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>