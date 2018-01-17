<?php

$clientNameSelected = $_POST['clientName'];
$jobTypeSelected = $_POST['jobType'];
//$jobVersionSelected = $_POST['jobVersion'];

include( 'config.php' );

$sql = "SELECT * FROM clients";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

if ($totalRecords > 0) :
	while ( $row = $result->fetch_assoc() ):
		$uClientID[$counter] = $row[ "clientId" ];
		$uClientName[$counter] = $row[ "clientName" ];
		$counter++;
	endwhile;
endif;

$sqlSelect = "SELECT * FROM jobstypes";
$resultSelect = $db->query( $sqlSelect );
$totalRecordsSelect = $resultSelect->num_rows;
$counter = 0;

if ($totalRecordsSelect > 0) :
	while ( $rowSelect = $resultSelect->fetch_assoc() ):
		$jobTypeID[ $counter ] = $rowSelect[ "id" ];
		$jobTypeName[ $counter ] = $rowSelect[ "jobType" ];		
		$counter++;
	endwhile;
endif;

$tplClients = '<option value="0">Select client</option>';
$tplJobType = '<option value="0">Select Job Type</option>';
$tplJobVersion = '<option value="-"></option>';

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

	if($jobTypeSelected == $jobTypeName[$counter]):
		$selected = 'selected';
	endif;

$tplJobType .= <<<EOT
	<option value="$jobTypeName[$counter]" $selected>$jobTypeName[$counter]</option>
EOT;
	$counter++;
endwhile;


//
//if($jobVersionSelected == "1-4" ){
//	$tplJobVersion .= '<option value="1-4" selected>1-4</option>';
//}else{
//	$tplJobVersion .= '<option value="1-4">1-4</option>';
//}


//if($jobVersionSelected == "5+" ){
//	$tplJobVersion .= '<option value="5+" selected>5+</option>';
//}else{
//	$tplJobVersion .= '<option value="5+">5+</option>';
//}


	$arrReturn['clients'] = $tplClients;
	$arrReturn['jobType'] = $tplJobType;	
	//$arrReturn['jobVersion'] = $tplJobVersion;	

    echo json_encode($arrReturn);


?>




