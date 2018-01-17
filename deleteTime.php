<?php

session_start();

include("config.php");

$recordID = $_POST['recordID'];

$created_atValue = date("Y-m-d H:i:s");

$userNameValue = $_SESSION['uName'];
try {
    $sqlDelete = "DELETE FROM timetracker where id='" . $recordID . "'";
	$resultDelete = $db->query( $sqlDelete );
    echo("success");

} catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}



?>