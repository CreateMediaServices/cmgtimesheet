<?php
session_start();

$startDate = date('Y-m-01');
$endDate = date('Y-m-d');

if(isset($_POST['startDate']) && isset($_POST['endDate']) ){
	$startDate = date('Y-m-d',strtotime($_POST['startDate']));
	$endDate = date('Y-m-d',strtotime($_POST['endDate']));	
}

$queryString ="";
$queryString = '&startDate='.$startDate;
$queryString .= '&endDate='.$endDate;

include( 'config.php' );

$uNameValue = $_SESSION[ 'uName' ];

if ( !( $uNameValue ) ):
	//header( "Location: http://clients.createmedia-group.com/cmg/timesheet/" );
	header( "Location: " . $siteBaseURL );
endif;

$sql = "SELECT * FROM cmg_jobtypes";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$jobTypeID[$counter] = $row[ "id" ];
	$jobTypeName[$jobTypeID[$counter]] = $row[ "jobTitle" ];	
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sql = "SELECT * FROM cmg_clients ORDER BY clientName";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$uClientId[$counter] = $row[ "id" ];
	$uClientName[$uClientId[$counter]] = $row[ "clientName" ];	
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sqlSelect = "SELECT * FROM cmg_timetracker 
				WHERE jobDate >='".$startDate."' AND jobDate <='".$endDate."'";
				
$resultSelect = $db->query( $sqlSelect );
$totalRecordsSelect = $resultSelect->num_rows;
$counter = 0;

if ($totalRecordsSelect > 0) :
	while ( $rowSelect = $resultSelect->fetch_assoc() ):		
		$uID[ $counter ] = $rowSelect[ "id" ];
		$clientIDSelect[ $counter ] = $rowSelect[ "clientID" ];
		$userNameSelect[ $counter ] = $rowSelect[ "userName" ];
		$jobTypeIDSelect[ $counter ] = $rowSelect[ "jobTypeID" ];
		$jobIDSelect[ $counter ] = $rowSelect[ "jobID" ];
		$jobVersionSelect[ $counter ] = $rowSelect[ "jobVersion" ];
		$jobHoursSelect[ $counter ] = $rowSelect[ "jobHours" ];
		$uDateSelect[ $counter ] = $rowSelect[ "jobDate" ];


		$counter++;
	endwhile;
endif;

$detailURL = "export-resource-detail.php?queryString=".$queryString;

?>
<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Create Media Group | Timesheet</title>
	<meta name="description" content="Image Library for CMG & SCB">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="shortcut icon" href="img/favicon/favicon.ico">
	<link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="img/favicon/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="img/favicon/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16">

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/grid12.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap-tagsinput.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/custom.css">
	<script src="js/vendor/modernizr-2.8.3.min.js"></script>

	<style>
		.dataTables_length, .dataTables_filter{
			display: none;
		}
		.userName{
			text-transform: capitalize;
		}

	</style>
</head>

<body class="resource-listing">
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong>
            browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>
            to improve your experience.</p>
        <![endif]-->

<main class="c-main">
	<section class="c-content-1 content--lg">
		<div class="container">
			<div class="row">

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	<div class="col-md-2">
		<div class="c-form-item">
			<label for="startDate">Start Date</label>
			<input id="startDate" name="startDate" class="js-date-picker"
				value="<?php echo $startDate; ?>">
		</div>
	
	</div>
	
	<div class="col-md-0"></div>
	
	<div class="col-md-2">
		<div class="c-form-item">
			<label for="endDate">End Date</label>
			<input id="endDate" name="endDate" class="js-date-picker"
				value="<?php echo $endDate; ?>">
		</div>
	</div>
	<div class="col-md-0"></div>
	<div class="col-md-2">
		<label for="endDate">&nbsp;</label>
		<input type="submit" value="Find" class="c-btn btn--emp">
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-2">
		<div class="c-form-item">
			<label for="endDate">&nbsp;</label>
			<a href="<?= $detailURL; ?>" class="c-btn btn--blue u-fr"> Export </a>
		</div>
	</div>	
</form>

			</div>
		</div>
	</section>	

	<section class="c-content-1 content--lg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

<table class="js-data-table-4 c-table-1" data-display-length='50'>
	<thead>
		<tr>
			<th>User</th>
			<th>Client</th>
			<th>Job Type</th>
			<th>Job Number</th>
			<th>Version</th>
			<th>Hours</th>
			<th>Date</th>			
		</tr>
	</thead>
	<tbody>
<?php 

if ($totalRecordsSelect > 0) :

	$counter=0;
	while($counter < sizeof($uID) ) :										
?>
		<tr>
			<td class="userName">
				<?php echo $userNameSelect[$counter]; ?>
			</td>
			<td class="clientName">
				<?php echo $uClientName[$clientIDSelect[ $counter ]]; ?>
			</td>
			<td class="jobType">
				<?php echo $jobTypeName[$jobTypeIDSelect[$counter]]; ?>
			</td>
			<td class="jobID">
				<?php echo $jobIDSelect[$counter]; ?>
			</td>	
			<td class="jobVersion">
				<?php echo $jobVersionSelect[$counter]; ?>
			</td>
			<td class="jobHours">
				<?php echo $jobHoursSelect[$counter]; ?>
			</td>
			<td>
				<?php echo $uDateSelect[$counter]; ?>
			</td>			
		</tr>
<?php
	$counter++;
	endwhile;
endif;
?>
		</tbody>
</table>
				</div>
			</div>
		</div>
	</section>
</main>

	<footer class="c-main-footer">
		<p>2017 &copy; Create Media Services</p>
	</footer>


	<!-- <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script> -->
	<script src="js/vendor/jquery-1.12.0.min.js"></script>
	<script src="js/vendor/select2.full.min.js"></script>
	<script src="js/vendor/bootstrap-tagsinput.min.js"></script>
	<script src="js/vendor/datatables.min.js"></script>
	<script src="js/vendor/owl.carousel.min.js"></script>

	<script src="js/vendor/collapse.js"></script>
	<script src="js/vendor/transition.js"></script>
	<script src="js/vendor/moment.min.js"></script>
	<script src="js/vendor/bootstrap-datetimepicker.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/custom.js"></script>
</body>

</html>