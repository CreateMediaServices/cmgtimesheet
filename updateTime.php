<?php

session_start();

include("config.php");
$clientsValue = $_POST['clients'];
$jobTitleValue = $_POST['jobtype'];
$jobIDValue = $_POST['jobID'];
$jobVersionValue = $_POST['jobVersion'];
$jobHoursValue = $_POST['jobHours'];
$recordID = $_POST['recordID'];
$created_atValue = $_POST['jobDate'];;

$userNameValue = $_SESSION['uName'];
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE timetracker SET clients=:clients, userName=:userName, jobTitle=:jobTitle, jobID=:jobID, jobVersion=:jobVersion, jobHours=:jobHours, created_at=:created_at WHERE id='".$recordID."'");

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
    $jobVersion = $jobVersionValue;
    $jobHours = $jobHoursValue;
    $created_at = $created_atValue;
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>