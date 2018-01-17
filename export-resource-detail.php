<?php

// $servername = "localhost";
// $username = "alzahiaa_zahia";
// $password = "L5GLHt0QVn6*]4v";
// $dbname = "alzahiaa_apr2016";

// $prefix = "";
// $conn = mysqli_connect( $servername, $username, $password, $dbname )or die( "Could not connect database" );


$startDate = date('Y-m-01');
$endDate = date('Y-m-d');

if(isset($_GET['startDate']) && isset($_GET['endDate']) ){
	$startDate = date('Y-m-d',strtotime($_GET['startDate']));
	$endDate = date('Y-m-d',strtotime($_GET['endDate']));	
}

include( 'config.php' );

$filename = "timesheet ".$startDate.' - '.$endDate.".csv";
$fp = fopen( 'php://output', 'w' );

$header = array( 'User', 'Client', 'Job Type', 'Job Number', 'Version', 'Hours', 'Date' );
header( 'Content-type: application/csv' );
header( 'Content-Disposition: attachment; filename=' . $filename );
fputcsv( $fp, $header );


$sql = "SELECT userName, clientName, jobTitle, jobVersion, cmg_timetracker.jobID,
			jobHours, jobDate FROM cmg_timetracker JOIN cmg_jobtypes 
			ON cmg_jobtypes.id = cmg_timetracker.jobTypeID 
			JOIN cmg_clients ON cmg_clients.id = cmg_timetracker.clientID 
			WHERE jobDate >='".$startDate."' AND jobDate <='".$endDate."'";

$result = $db->query( $sql );

while ( $row = $result->fetch_assoc() ) {
	fputcsv( $fp, $row );
}

exit(0);

?>
