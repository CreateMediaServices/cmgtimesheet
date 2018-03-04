<?php

$clients = $_POST[ 'clients' ];

include( 'config.php' );

$dIDs = array();

$sql = "SELECT * FROM cmg_clients where id=" . $clients;
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$dID = $row[ "deptID" ];	
	$JobIDs = $row[ "JobID" ];	
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sql = "SELECT * FROM cmg_client_depart where clientID=" . $clients;
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$dIDs[$counter] = $row[ "deptID" ];
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$dIDs = implode(', ', $dIDs);

$sql = "SELECT * FROM cmg_dept WHERE id IN(".$dIDs.")";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;

while ( $row = $result->fetch_assoc() ):

	$deptIDs = $row[ "id" ];
	$deptName[$deptIDs] = $row[ "deptName" ];	
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sql = "SELECT * FROM cmg_jobtypes WHERE deptID IN (".$dIDs.") AND clientID=".$clients;
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):	
	$jobTitle[ $counter ] = $row[ "jobTitle" ];
	$jobID[ $counter ] = $row[ "id" ];
	$deptID[ $counter ] = $row[ "deptID" ];	
	$counter++;
endwhile;

$tplResult = "";

if ( $result->num_rows > 0 ) :
	$counter = 0;
	while ( $counter < sizeof( $jobTitle ) ):

		$dName = "";
		if($deptID[$counter] != 3 ){
			$dName = $deptName[$deptID[$counter]]." - ";
		}

		$tplResult .= <<<EOT
                        <option value="$jobID[$counter]">$dName$jobTitle[$counter]</option>
EOT;

	$counter++;
	endwhile;	

endif;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$arrReturn['html'] = $tplResult;
$arrReturn['clientJobVersion'] = $JobIDs;
echo json_encode($arrReturn);    

?>