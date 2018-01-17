<?php

session_start();

include("config.php");
$clientsValue = $_POST['clients'];
$jobTitleValue = $_POST['jobtype'];
$jobIDValue = $_POST['jobID'];
$jobVersionValue = $_POST['jobVersion'];
$jobHoursValue = $_POST['jobHours'];
$created_atValue = $_POST['jobDate'];

//$created_atValue = date("Y-m-d H:i:s");
$userNameValue = $_SESSION['uName'];
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO timetracker (clients, userName, jobTitle, jobID, jobVersion, jobHours, created_at) 
    VALUES (:clients, :userName, :jobTitle , :jobID, :jobVersion, :jobHours, :created_at)");
    $stmt->bindParam(':clients', $clients);
	$stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':jobTitle', $jobTitle);
    $stmt->bindParam(':jobID', $jobID);
    $stmt->bindParam(':jobVersion', $jobVersion);
    $stmt->bindParam(':jobHours', $jobHours);    
    $stmt->bindParam(':created_at', $created_at);

    // insert a row
    $clients = $clientsValue;
	$userName = $userNameValue;
    $jobTitle = $jobTitleValue;
    $jobID = $jobIDValue;
    //$jobVersion = $jobVersionValue;
	$jobVersion = '1-4';
    $jobHours = $jobHoursValue;
    $created_at = $created_atValue;
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>