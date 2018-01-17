<?php

session_start();

include("config.php");

$clientIDValue = $_POST['clientID'];
$departmentValue = $_POST['deptID'];
$jobTitleValue = $_POST['jobTitle'];
$created_at = date("Y-m-d H:i:s");

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO cmg_jobtypes (clientID, jobTitle, deptID) 
    VALUES (:clientID, :jobTitle, :deptID)");
    $stmt->bindParam(':clientID', $clientID);
	$stmt->bindParam(':jobTitle', $jobTitle);
    $stmt->bindParam(':deptID', $deptID);
    
    // insert a row
    $clientID = $clientIDValue;
	$jobTitle = $jobTitleValue;
    $deptID = $departmentValue;
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>