<?php

session_start();

include("config.php");

$clientsValue = $_POST['clients'];
$jobTitleValue = $_POST['jobtype'];
$jobIDValue = $_POST['jobID'];
$jobHoursValue = $_POST['jobHours'];
$recordID = $_POST['recordID'];
$created_atValue = $_POST['jobDate'];
$userNameValue = $_POST['userName'];

if($clientsValue == 24){
    $jobTitleValue = 923; 
    $jobIDValue = $_POST['jobtypeNew']; 
}

if(isset( $_POST['jobVersion'] ) && $_POST['jobVersion'] > 0 ){
    $jobVersionValue = $_POST['jobVersion'];
}else{
    $jobVersionValue = "";    
}

$sql = "SELECT * FROM cmg_timetracker 
        WHERE jobDate='".$created_atValue."' AND id <>".$recordID." AND userName ='".$userNameValue."'";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$jobHours = 0;

while ( $row = $result->fetch_assoc() ):
    $jobHours += $row[ "jobHours" ];
endwhile;

$jobHours += $jobHoursValue;

// $userNameValue = $_SESSION['uName'];
if($jobHours > 13){
    echo("100");
}else if($userNameValue){
    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE cmg_timetracker SET clientID=:clientID, userName=:userName, jobTypeID=:jobTypeID, jobID=:jobID, jobVersion=:jobVersion, jobHours=:jobHours, jobDate=:jobDate WHERE id='".$recordID."'");

        $stmt->bindParam(':clientID', $clientID);
    	$stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':jobTypeID', $jobTypeID);
        $stmt->bindParam(':jobID', $jobID);
        $stmt->bindParam(':jobVersion', $jobVersion);
        $stmt->bindParam(':jobHours', $jobHours);    
        $stmt->bindParam(':jobDate', $jobDate);

        // insert a row
        $clientID = $clientsValue;
    	$userName = $userNameValue;
        $jobTypeID = $jobTitleValue;
        $jobID = $jobIDValue;
        $jobVersion = $jobVersionValue;
        $jobHours = $jobHoursValue;
        $jobDate = $created_atValue;
        $stmt->execute();
        
        echo("success");

    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}else{
    echo("101");
}


?>