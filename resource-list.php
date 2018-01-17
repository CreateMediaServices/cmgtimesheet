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

$sqlUser = "SELECT * FROM cmg_user";
$resultUser = $db->query( $sqlUser );
$counter = 0;

while ( $rowUser = $resultUser->fetch_assoc() ):
	$userName[ $counter ] = $rowUser[ "userName" ];

	$sqlTime = "SELECT sum(jobHours) as SumJobHours FROM cmg_timetracker 
				WHERE userName='" . $userName[ $counter ] . "' AND
				(jobDate >='".$startDate."' AND jobDate <='".$endDate."')";

	$resultTime = $db->query( $sqlTime );
	$totalRecordsTime = $resultTime->num_rows;
	$innercounter = 0;

	while ( $rowTime = $resultTime->fetch_assoc() ):
		$jobHours[ $counter ] = $rowTime[ "SumJobHours" ];
	endwhile;

	$counter++;
endwhile;

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
					<div class="col-md-6"></div>
				</form>
				</div>
				<div class="row">
					<div class="col-md-6">
						<table class="js-data-table-2 c-table-1 c-table-2" data-display-length='-1'>
							<thead>
								<tr>
									<th data-priority="3">User Name</th>
									<th>Job Hours</th>
								</tr>
							</thead>
							<tbody>
<?php 
$counter=0;
while($counter < sizeof($userName) ) :
	$detailURL = "user-detail.php?userName=".$userName[ $counter ].$queryString;
?>
	<tr>
		<td class="clientName">
			<a href="<?= $detailURL; ?>">
				<?php echo(strtoupper($userName[$counter])); ?>
			</a>
		</td>
		<td class="jobType">
			<?php echo($jobHours[$counter]); ?>
		</td>
	</tr>
<?php
	$counter++;
endwhile;
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