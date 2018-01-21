<?php

$clientNameSelected = $_POST['clientName'];
$jobTypeSelected = $_POST['jobType'];
$recordJobTypeID = $_POST['recordJobTypeID'];
$jobVersionSelected = $_POST['jobVersion'];
$jobNumberSelected = $_POST['jobNumber'];

$jobVersionSelected = 0;
if( $_POST['jobVersion'] != ""){
	$jobVersionSelected = $_POST['jobVersion'];
}

include( 'config.php' );

$sql = "SELECT * FROM cmg_dept";
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

$sql = "SELECT * FROM cmg_clients 
		WHERE clientStatus=0  ORDER BY clientName";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

if ($totalRecords > 0) :
	while ( $row = $result->fetch_assoc() ):
		$uClientID[$counter] = $row[ "id" ];
		$uClientName[$counter] = $row[ "clientName" ];
		$counter++;
	endwhile;
endif;

$sqlSelect = "SELECT * FROM cmg_jobtypes WHERE id =".$recordJobTypeID;
$resultSelect = $db->query( $sqlSelect );
$totalRecordsSelect = $resultSelect->num_rows;
$counter = 0;

if ($totalRecordsSelect > 0) :
	while ( $rowSelect = $resultSelect->fetch_assoc() ):
		$jobTypeID[ $counter ] = $rowSelect[ "id" ];
		$jobDeptID[$jobTypeID[$counter]] = $rowSelect[ "deptID" ];	
		$jobTypeName[ $jobTypeID[ $counter ] ] = $rowSelect[ "jobTitle" ];		
		$counter++;
	endwhile;
endif;

$tplClients = '<option value="0">Select client</option>';
$tplJobType = '<option value="0">Select Job Type</option>';

//
$counter=0;
while($counter < sizeof($uClientID)):
	$selected ='';

	if($clientNameSelected == $uClientName[$counter]):
		$selected = 'selected';
	endif;

$tplClients .= <<<EOT
	<option value="$uClientID[$counter]" $selected>$uClientName[$counter]</option>
EOT;
	$counter++;
endwhile;


$counter=0;
while($counter < sizeof($jobTypeID)):
	$selected ='';

	// if($jobTypeSelected == $jobTypeName[$counter]):
		$selected = 'selected';
	// endif;


	$jobDetail = $deptName[$jobDeptID[$jobTypeID[$counter]]]
					.' - '.$jobTypeName[$jobTypeID[$counter]];

$tplJobType .= <<<EOT
	<option value="$jobTypeID[$counter]" $selected>$jobDetail</option>
EOT;
	$counter++;
endwhile;

$tplJobVersion = $jobVersionSelected;
$tplJobNumber = $jobNumberSelected;

$arrReturn['clients'] = $tplClients;
$arrReturn['jobType'] = $tplJobType;	
$arrReturn['jobNumber'] = $tplJobNumber;
$arrReturn['jobVersion'] = $tplJobVersion;

echo json_encode($arrReturn);

?>