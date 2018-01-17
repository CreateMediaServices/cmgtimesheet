<?php

$clients = $_POST[ 'clients' ];

include( 'config.php' );

$sql = "SELECT * FROM jobstypes where clientid=" . $clients;
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$uId[ $counter ] = $row[ "id" ];
	$uClientJobId[ $counter ] = $row[ "clientId" ];
	$uJobType[ $counter ] = $row[ "jobType" ];
	$counter++;
endwhile;
if ( $result->num_rows > 0 ) :
	$counter = 0;
	while ( $counter < sizeof( $uClientJobId ) ):
		?>
		<option value="<?php echo $uJobType[$counter]; ?>">
			<?php echo $uJobType[$counter]; ?>
		</option>
	<?php

	$counter++;
	endwhile;
endif;
?>