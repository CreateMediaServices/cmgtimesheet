<?php
// session_start();

// $uNameValue = $_SESSION[ 'uName' ];

// if ( isset( $uNameValue ) ):
// 	header( "Location: " . $siteBaseURL );
// endif;

$current = 0;

$jobID = $_GET['jobID'];
$jobName = $_GET['jobName'];

$startDate = date('Y-m-01');
$endDate = date('Y-m-d');

if(isset($_POST['startDate']) && isset($_POST['endDate']) ){
	$startDate = date('Y-m-d',strtotime($_POST['startDate']));
	$endDate = date('Y-m-d',strtotime($_POST['endDate']));
	$current = 1;
}

include( 'config.php' );

/*
SELECT column-names
  FROM table-name1 JOIN table-name2 
    ON column-name1 = column-name2
*/

$queryString='';
$queryString = '&startDate='.$startDate;
$queryString .= '&endDate='.$endDate;


$sqlTime = "SELECT cmg_timetracker.userName, 
				sum(cmg_timetracker.jobHours) as SumJobHours 
				FROM cmg_jobtypes JOIN cmg_timetracker
				ON cmg_jobtypes.id = cmg_timetracker.jobTypeID					
				WHERE (cmg_timetracker.jobDate >='".$startDate."' AND
				cmg_timetracker.jobDate <='".$endDate."' AND cmg_jobtypes.id = $jobID)				
				GROUP BY cmg_jobtypes.jobTitle
				ORDER BY cmg_jobtypes.jobTitle DESC";

//ORDER BY cmg_clients.clientName DESC

$resultTime = $db->query( $sqlTime );
$totalRecordsTime = $resultTime->num_rows;
$innercounter = 0;
$counter=0;
while ( $rowTime = $resultTime->fetch_assoc() ):
	$userName[ $counter ] = $rowTime[ "userName" ];	
	$jobHours[ $counter ] = $rowTime[ "SumJobHours" ];
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
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

<main class="c-main">
	<section class="c-content-1 content--lg">
		<div class="container">
			<div class="row">

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	<div class="col-md-2">
		<div class="c-form-item">
			<label for="startDate">Job Type</label>
			
		</div>	
	</div>	
</form>

			</div>
			<div class="row">

<div class="col-md-6">
	<table class="js-data-table-2 c-table-1 c-table-2" data-display-length='-1'>
		<thead>
			<tr>
				<th>User</th>
				<th>Job Hours</th>
			</tr>
		</thead>
		<tbody>
<?php 
$counter=0;
while($counter < sizeof($userName) ) :	
?>
			<tr>
				<td class="userName">
					
						<?php echo( strtoupper($userName[$counter]) ); ?>
					
				</td>
				<td class="jobHours">
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