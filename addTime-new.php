<?php

session_start();

include("config.php");

$clientsValue = $_POST['clients'];
$jobTitleValue = $_POST['jobtype'];
$jobIDValue = $_POST['jobID'];
$jobVersionValue = $_POST['jobVersion'];
$jobHoursValue = $_POST['jobHours'];
$created_atValue = $_POST['jobDate'];
$userNameValue = $_POST['userName'];

$sql = "SELECT sum(jobHours) as jobHour FROM cmg_timetracker 
        WHERE jobDate='".$created_atValue."' AND userName ='".$userNameValue."'";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$jobHours = 0;

while ( $row = $result->fetch_assoc() ):
    $jobHours = $row[ "jobHour" ];
endwhile;

$jobHoursValue2 = ($jobHours + $jobHoursValue);

//$created_atValue = date("Y-m-d H:i:s");
// $userNameValue = $_SESSION['uName'];
if($jobHoursValue2 > 12){
    echo("100");
}else if($userNameValue){
    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO cmg_timetracker 
            (clientID, userName, jobTypeID, jobID, jobVersion, jobHours, jobDate) 
        VALUES (:clientID, :userName, :jobTypeID, :jobID, :jobVersion,
            :jobHours, :jobDate)");
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