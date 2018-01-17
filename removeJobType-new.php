<?php

session_start();

include("config.php");

$jobIDValue = $_POST['jobID'];

try {

    $jobStatusValue = 1;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("UPDATE cmg_jobtypes SET jobStatus=:jobStatus 
            WHERE id='".$jobIDValue."'");

    $stmt->bindParam(':jobStatus', $jobStatus);
	    
    // insert a row
    $jobStatus = $jobStatusValue;	
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>