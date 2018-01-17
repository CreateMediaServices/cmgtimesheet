<?php
session_start();

include("config.php");
$clientNameValue = $_POST['addclientname'];
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO clients (clientName) 
    VALUES (:clientName)");
	$stmt->bindParam(':clientName', $clientName);

    // insert a row
	$clientName = $clientNameValue;
    $stmt->execute();
    
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>