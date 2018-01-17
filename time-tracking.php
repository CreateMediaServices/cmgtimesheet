<?php
session_start();
include( 'config.php' );

$uNameValue = $_SESSION[ 'uName' ];

if(!($uNameValue)):	
	header( "Location: ".$siteBaseURL );
endif;

$created_atValue = date("Y-m-d");

$sql = "SELECT * FROM clients";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$uClientId[$counter] = $row[ "clientId" ];
	$uClientName[$counter] = $row[ "clientName" ];
	$uClientName2[$row[ "clientId" ]] = $row[ "clientName" ];
	$counter++;
endwhile;

$sqlSelect = "SELECT * FROM timetracker where userName='" . $uNameValue . "' ORDER BY created_at DESC";
$resultSelect = $db->query( $sqlSelect );
$totalRecordsSelect = $resultSelect->num_rows;
$counter = 0;

if ($totalRecordsSelect > 0) :
	while ( $rowSelect = $resultSelect->fetch_assoc() ):
		$uClientSelectID[ $counter ] = $rowSelect[ "id" ];
		$uClientNameSelect[ $counter ] = $rowSelect[ "clients" ];
		$uNameSelect[ $counter ] = $rowSelect[ "userName" ];
		$uJobTitleSelect[ $counter ] = $rowSelect[ "jobTitle" ];
		$uJobIdSelect[ $counter ] = $rowSelect[ "jobID" ];
		$uJobVersionSelect[ $counter ] = $rowSelect[ "jobVersion" ];
		$uJobHoursSelect[ $counter ] = $rowSelect[ "jobHours" ];
		$uDateSelect[ $counter ] = $rowSelect[ "created_at" ];
		$counter++;
	endwhile;
endif;

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
	<link rel="stylesheet" href="css/main.css?version=0.001">
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

<body>
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<header class="c-main-header clearfix">
		<div class="header-row header-row--sty-1">
			<div class="t-layout">
				<div class="t-row">

					<div class="t-col header-col">
						<a href="#" class="c-logo-w-title logo-w-title--sub-title">
							<i class="c-logo">CMG</i>
							<i class="txt">Timesheet<span>Track time on projects</span></i>
						</a>
					</div>
					
					<?php if($uNameValue == 'shoaib' || $uNameValue == 'shakeel' || $uNameValue == 'hina' || $uNameValue == 'matthew' || $uNameValue == 'dina' || $uNameValue == 'pilar' || $uNameValue == 'orla' || $uNameValue == 'khaled' ){ ?>
					<div class="t-col header-col t-col--compress panel-action">
						<a href="add-projecttype.php" class="c-btn btn--blue u-fr"><i class="fa fa-plus"></i>Add Project Type</a>
					</div>
					<div class="t-col header-col t-col--compress panel-action">
						<a href="add-client.php" class="c-btn btn--blue u-fr"><i class="fa fa-plus"></i>Add Client</a>
					</div>
					<div class="t-col header-col t-col--compress panel-action">
						<a href="add-job-type.php" class="c-btn btn--blue u-fr"><i class="fa fa-plus"></i>Add Job Type</a>
					</div>
					<div class="t-col header-col t-col--compress panel-action">
						<a href="report.php" class="c-btn btn--blue u-fr"><i class="fa fa-line-chart"></i>Project Report</a>
					</div>
					<div class="t-col header-col t-col--compress panel-action">
						<a href="resource-list.php" class="c-btn btn--blue u-fr"><i class="fa fa-bar-chart"></i>Resource Report</a>
					</div>
					<?php } ?>
					
					<div class="t-col header-col t-col--compress panel-action userName">Hi <?php echo ($uNameValue); ?></div>
					<div class="t-col header-col t-col--compress logout">
						<a href="logout.php" class="c-icon">LOGOUT<i class="fa fa-sign-out"></i></a>
					</div>
					
				</div>
			</div>
		</div>
		<div class="header-row header-row--sty-2 txt-center">
			<form class="c-form-sty form-sty--1 form--white">
				<div class="c-form-item item--lg">
					<label for="keywords">Client Name</label>
					<select style="width: 100%" name="clients" id="clients" class="js-clients">
						<option value="0">Select client</option>
							<?php
							$counter=0;
							while($counter < sizeof($uClientName) ) :
							?>
							<option value="<?php echo $uClientId[$counter]; ?>"><?php echo $uClientName[$counter]; ?></option>
							<?php
							$counter++;
							endwhile;
							?>
					</select>
				</div>
				<div class="c-form-item js-cName" style="display: none;">
					<label for="cName">Client Name</label>
					<input type="text" id="cName" name="cName">
				</div>
				<div class="c-form-item js-jobtype">
					<label for="brand">Job Type</label>
					<select style="width: 100%" name="jobtype" id="jobtype" >
						<option value="0">Select Job Type</option>
					</select>

				</div>
				<div class="c-form-item js-JobID" style="display: none;">
					<label for="jobID">Job Number</label>
					<input type="text" id="jobID" name="jobID" value="-">
				</div>
				<!--<div class="c-form-item js-JobVersion" style="display: none;">
					<label for="product">Version</label>
					<input type="text" id="jobVersion" name="jobVersion" value="1-4">
					<select style="width: 100%" name="jobVersion" id="jobVersion">
						<option value="-"></option>
						<option value="1-4">1-4</option>
						<option value="5+">5+</option>
					</select>
				</div>-->
				<div class="c-form-item">
					<label for="jobHours">Hours</label>
					<input type="text" id="jobHours" name="jobHours">
				</div>
				<div class="c-form-item">
					<label for="jobDate">Date</label>
					<input id="jobDate" name="jobDate" class="js-date-picker" value="<?php echo($created_atValue); ?>">
				</div>

				

				<div class="action">
					<a href="javascript:void(0);" class="c-btn btn--emp js-SubmitBtn"><i class="fa"></i>Add Time</a>
					<input type="hidden" name="siteBaseURL" id="siteBaseURL" value="<?php echo($siteBaseURL.'/addTime.php'); ?>">
					<input type="hidden" name="clientBaseURL" id="clientBaseURL" value="<?php echo($siteBaseURL.'/loadjobtype.php'); ?>">
					<input type="hidden" name="targetURL" id="targetURL" value="<?php echo($siteBaseURL.'/time-tracking.php'); ?>">
					<input type="hidden" name="editURL" id="editURL" value="<?php echo($siteBaseURL.'/search.php'); ?>">
					<input type="hidden" name="updateURL" id="updateURL" value="<?php echo($siteBaseURL.'/updateTime.php'); ?>">
					<input type="hidden" name="deleteURL" id="deleteURL" value="<?php echo($siteBaseURL.'/deleteTime.php'); ?>">
				</div>
			</form>
		</div>
	</header>

	<main class="c-main">
		<section class="c-content-1 content--lg">
			<div class="container">
				<div class="row">
					<div class="col-md-12">

<?php

						?>

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
									<td class="clientName"><?php echo $uClientName2[$uClientNameSelect[ $counter ]]; ?></td>
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

    <div class="c-popups">
        <div class="overlay js-close-popup"></div>
        <div class="c-popup-1 popup" id="searchRecord">
            <div class="wrapper">
                <div class="c-form-sty form-sty--1 form--white" style="300px">
                    
						<div class="c-form-item item--lg medium">
							<label for="clients2">Client Name</label>
							<select style="width: 100%" name="clients2" id="clients2" class="js-clients-2">
								<option value="0">Select client</option>		
							</select>

						</div>
						<div class="c-form-item large">
							<label for="jobtype2">Job Type</label>
							<select style="width: 100%" name="jobtype2" id="jobtype2" class="js-jobtype-2">
								<option value="0">Select Job Type</option>
							</select>

						</div>
						<div class="c-form-item js-JobID-2 small" style="display: none;">
							<label for="jobID2">Job Number</label>
							<input type="text" id="jobID2" name="jobID2" value="-">
						</div>
						<!--<div class="c-form-item js-JobVersion-2 small" style="display: none;">
							<label for="jobVersion2">Version</label>
							<input type="text" id="jobVersion2" name="jobVersion2" value="1-4">
							<select style="width: 100%" name="jobVersion2" id="jobVersion2">
								<option value="-"></option>
								<option value="1-4">1-4</option>
								<option value="5+">5+</option>
							</select>
						</div>-->
						<div class="c-form-item small">
							<label for="jobHours2">Hours</label>
							<input type="text" id="jobHours2" name="jobHours2" class="js-jobHours-2">
						</div>
						<div class="c-form-item date">
							<label for="jobDate2">Date</label>
							<input id="jobDate2" name="jobDate2" value="" class="js-jobDate-2 js-date-picker">
						</div>
						<div class="action">
							<a href="javascript:void(0);" class="c-btn btn--emp js-updateBtn"><i class="fa"></i>Update</a>
							<input type="hidden" name="updateRecordID" class="updateRecordID" id="updateRecordID">
						</div>					

                </div>
            </div>
        </div>
    </div>

    <div class="c-popups">
        <div class="overlay js-close-popup"></div>
        <div class="c-popup-1 popup" id="deleteRecord">
            <div class="wrapper">
            	<div class="c-form-sty form-sty--1 form--white">
	                <div class="title">Are you sure?</div>
	                <div class="sub-title">You are about to remove your task</div>
	                <div class="action action2">
	                    <a href="javascript:void(0);" class="c-btn btn--sm btn--a btn--blue js-close-popup">No</a> <a href="javascript:void(0)" class="c-btn btn--sm btn--a js-close-popup js-delete-record">Yes</a>
	                </div>
                </div>
            </div>
        </div>
    </div>


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
	<script src="js/main.js?version=0.001"></script>
	<script src="js/custom.js?version=0.001"></script>
</body>

</html>