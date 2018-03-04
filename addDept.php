<?php

session_start();
include("config.php");

$deptNameValue = $_POST['deptName'];
$created_at = date("Y-m-d H:i:s");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO cmg_dept (deptName, created_at) 
    VALUES (:deptName, :created_at)");

	$stmt->bindParam(':deptName', $deptName);    
    $stmt->bindParam(':created_at', $created_at);

    // insert a row
	$deptName = $deptNameValue;
    $created_at = $created_at;
    $stmt->execute();

    echo("success");

} catch(PDOException $e){

    echo "Error: " . $e->getMessage();

}

?>