<?php
session_start();


//SELECT t2.clientName, t1.userName, t1.jobTitle, t1.jobID, t1.jobVersion, t1.jobHours, t1.created_at FROM timetracker t1 INNER JOIN  clients t2 ON t1.clients = t2.clientId

$today = date('Y-m-d');
$current = 1;

if(isset($_POST['startDate']) && isset($_POST['endDate']) ){
	$startDate = date('Y-m-d',strtotime($_POST['startDate']));
	$endDate = date('Y-m-d',strtotime($_POST['endDate']));
	$current = 0;
}

include( 'config.php' );

$uNameValue = $_SESSION[ 'uName' ];

if ( !( $uNameValue ) ):
	//header( "Location: http://clients.createmedia-group.com/cmg/timesheet/" );
	header( "Location: " . $siteBaseURL );
endif;

$sqlUser = "SELECT * FROM cmguser";
$resultUser = $db->query( $sqlUser );
$counter = 0;

// while ( $rowUser = $resultUser->fetch_assoc() ):
// 	$userName[ $counter ] = $rowUser[ "userName" ];

	if($current == 1){
		$sqlTime = "SELECT * FROM timetracker ";
	}else{
		$sqlTime = "SELECT * FROM timetracker ";
	}

	$resultTime = $db->query( $sqlTime );
	$totalRecordsTime = $resultTime->num_rows;
	$innercounter = 0;

	while ( $rowTime = $resultTime->fetch_assoc() ):
		// $jobHours[ $counter ] = $rowTime[ "SumJobHours" ];

		$uClientSelectID[ $counter ] = $rowTime[ "id" ];
		$uClientNameSelect[ $counter ] = $rowTime[ "clients" ];
		$uNameSelect[ $counter ] = $rowTime[ "userName" ];
		$uJobTitleSelect[ $counter ] = $rowTime[ "jobTitle" ];
		$uJobIdSelect[ $counter ] = $rowTime[ "jobID" ];
		$uJobVersionSelect[ $counter ] = $rowTime[ "jobVersion" ];
		$uJobHoursSelect[ $counter ] = $rowTime[ "jobHours" ];
		$uDateSelect[ $counter ] = $rowTime[ "created_at" ];
		
		$counter++;
	endwhile;

// 	
// endwhile;

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
	<script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="resource-listing">
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->	

	<main class="c-main">
		<section class="c-content-1 content--lg">
			<div class="container">
				<div class="row">
					<div class="col-md-12">

						<table class="js-data-table-3 c-table-1"  data-display-length='50'>
							<thead>
								<tr>
									<th data-priority="3">Client</th>
									<th>Job Type</th>
									<th>Job Number</th>
									<!--<th>Version</th>-->
									<th>Hours</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php 

								if ($totalRecordsSelect > 0) :

									$counter=0;
									while($counter < sizeof($uClientSelectID) ) :
										$innercounter= $uClientNameSelect[$counter] - 1;
										if($uClientNameSelect[$counter] == 25 ):
											$innercounter= $uClientNameSelect[$counter] - 2;
										endif;
							?>
								<tr>
									<td class="clientName"><?php echo $uClientName[$innercounter]; ?></td>
									<td class="jobType"><?php echo $uJobTitleSelect[$counter]; ?></td>
									<td class="jobID"><?php echo $uJobIdSelect[$counter]; ?></td>
									<?php /*?><td class="jobVersion"><?php echo $uJobVersionSelect[$counter]; ?></td><?php */?>
									<td class="jobHours"><?php echo $uJobHoursSelect[$counter]; ?></td>
									<td><?php echo $uDateSelect[$counter]; ?></td>
									<td>
										<a href="#searchRecord" class="js-open-popup js-search-record">Edit</a><!--&nbsp;&nbsp;/&nbsp;&nbsp;
										<a href="#deleteRecord" class="js-open-popup js-search-delete">Delete</a>-->
										<input type="hidden" value="<?php echo($uClientSelectID[$counter]); ?>" name="recordID" class="recordID">
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