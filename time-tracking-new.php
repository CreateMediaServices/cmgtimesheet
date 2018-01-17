<?php
session_start();
include( 'config.php' );

$uNameValue = $_SESSION[ 'uName' ];
$uTypeValue = $_SESSION['uType'];

$workingHours =array();

if(!($uNameValue)):	
	header( "Location: ".$siteBaseURL );
endif;

$created_atValue = date("Y-m-d");

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


$sql = "SELECT * FROM cmg_projecttype";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$projectTypeID[$counter] = $row[ "id" ];
	$projectTypeLabel[$projectTypeID[$counter]] = $row[ "projectType" ];	
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sql = "SELECT * FROM cmg_jobtypes";
$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	$jobTypeID[$counter] = $row[ "id" ];
	$jobDeptID[$jobTypeID[$counter]] = $row[ "deptID" ];	
	$jobTypeName[$jobTypeID[$counter]] = $row[ "jobTitle" ];	
	$counter++;
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

while ( $row = $result->fetch_assoc() ):
	$uClientId[$counter] = $row[ "id" ];
	$uClientName[$uClientId[$counter]] = $row[ "clientName" ];	
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
	$uClientIds[$counter] = $row[ "id" ];
	$uClientNames[$uClientIds[$counter]] = $row[ "clientName" ];	
	$counter++;
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

$sqlSelect = "SELECT * FROM cmg_timetracker where 
				userName='" . $uNameValue . "' ORDER BY jobDate DESC";

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

$timeCheck = 0;
if( isset( $_GET['timeCheck'] ) ):
	$timeCheck = $_GET['timeCheck'];
endif;

$sql = "SELECT sum(jobHours) as workingHours, jobDate FROM 
				cmg_timetracker where userName='" . $uNameValue . "'
				GROUP BY jobDate";

$result = $db->query( $sql );
$totalRecords = $result->num_rows;
$counter = 0;

while ( $row = $result->fetch_assoc() ):
	if($row[ "workingHours" ] < 8 ){
		$workingHours[$counter] = 8 - $row[ "workingHours" ];
		$workingDate[$counter] = $row[ "jobDate" ];	
		$counter++;
	}	
endwhile;

unset($sql);
unset($row);
unset($result);
unset($totalRecords);

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
		<i class="txt">Timesheet
			<span>Track time on projects</span>
		</i>
	</a>
</div>
				
<?php 
if( $uTypeValue == 1 ){ 
?>
	<div class="t-col header-col t-col--compress panel-action topMenu">
		<a href="javascript:void(0);" class="c-btn btn--blue u-fr">
			<i class="fa fa-plus"></i>New&nbsp;&nbsp;&nbsp;
		</a>
		<ul>
			<li>
				<a href="add-projecttype-new.php" class="c-btn btn--blue u-fr">
					<i class="fa fa-folder-o"></i>Add Project Type
				</a>
			</li>
			<li>
				<a href="add-client-new.php" class="c-btn btn--blue u-fr">
					<i class="fa fa-user-o"></i>Add Client
				</a>
			</li>
			<li>
				<a href="add-job-type-new.php" class="c-btn btn--blue u-fr">
					<i class="fa fa-tasks"></i>Add Job Type
				</a>
			</li>
		</ul>
	</div>

	<div class="t-col header-col t-col--compress panel-action topMenu">
		<a href="javascript:void(0);" class="c-btn btn--blue u-fr">
			<i class="fa fa-plus"></i>Report&nbsp;&nbsp;&nbsp;
		</a>
		<ul>
			<li>
				<a href="resource-detail.php" class="c-btn btn--blue u-fr">
					<i class="fa fa-line-chart"></i>Resource detail
				</a>
			</li>			
		</ul>
	</div>
<?php 
} 
?>

<div class="t-col header-col t-col--compress panel-action userName">
	Hi <?php echo ($uNameValue); ?>
</div>

<div class="t-col header-col t-col--compress logout">
	<a href="logout.php" class="c-icon">
		LOGOUT<i class="fa fa-sign-out"></i>
	</a>
</div>
				
		</div>
	</div>
</div>	

<div class="header-row header-row--sty-2 content--lg">
	<div class="container">
	<form class="c-form-sty form-sty--1 form--white">

<div class="c-form-item item--lg">
	<label for="clients">Client Name</label>
	<select style="width: 100%" name="clients" id="clients" class="js-clients">
		<option value="0">Select Client</option>
<?php
$counter=0;
while($counter < sizeof($uClientName) ) :
?>
		<option value="<?php echo $uClientId[$counter]; ?>">
			<?php echo $uClientName[$uClientId[$counter]]; ?>
		</option>
<?php
	$counter++;
endwhile;
?>
	</select>
</div>	

<div class="c-form-item js-jobtype">
	<label for="jobtype">Job Title</label>
	<select style="width: 100%" name="jobtype" id="jobtype" >
		<option value="0">Select Job Title</option>
	</select>
</div>
<div class="c-form-item js-JobID colWidth1" style="display: none;">
	<label for="jobID">Job Number</label>
	<input type="text" id="jobID" name="jobID" value="">
	<strong>e.g. SC-EXXXXXX</strong>
</div>
<div class="c-form-item js-jobVersion colWidth" style="display: none;">
	<label for="jobVersion">Version</label>
	<input type="text" id="jobVersion" name="jobVersion" value="">
	<strong>e.g. XX</strong>
</div>
<div class="c-form-item colWidth">
	<label for="jobHours">Hours</label>
	<input type="text" id="jobHours" name="jobHours">
	<label><span>[Min. 0.5 - Max. 12]</span></label>
</div>
<div class="c-form-item colWidth">
	<label for="jobDate">Date</label>
	<input id="jobDate" name="jobDate" class="js-date-picker"
		value="<?php echo($created_atValue); ?>">
</div>

<div class="action">
	<a href="javascript:void(0);" class="c-btn btn--emp js-SubmitBtn">
		Add Time
	</a>

	<input type="hidden" name="siteBaseURL" id="siteBaseURL"
		value="<?php echo($siteBaseURL.'/addTime-new.php'); ?>">

	<input type="hidden" name="clientBaseURL" id="clientBaseURL"
		value="<?php echo($siteBaseURL.'/loadjobtype-new.php'); ?>">

	<input type="hidden" name="targetURL" id="targetURL"
		value="<?php echo($siteBaseURL.'/time-tracking-new.php'); ?>">

	<input type="hidden" name="editURL" id="editURL"
		value="<?php echo($siteBaseURL.'/search-new.php'); ?>">

	<input type="hidden" name="updateURL" id="updateURL"
		value="<?php echo($siteBaseURL.'/updateTime-new.php'); ?>">

	<input type="hidden" name="deleteURL" id="deleteURL"
		value="<?php echo($siteBaseURL.'/deleteTime-new.php'); ?>">

	<input type="hidden" name="userNameValue" id="userNameValue"
		value="<?php echo($uNameValue); ?>">

	<input type="hidden" name="clientCheck" id="clientCheck">
		
</div>
		
		</form>
		</div>
	</div>
</header>

<main class="c-main">
<?php
if(sizeof($workingHours) > 0){
?>	
	<div class="datesMissing">
		<div class="this-toggle js-module-toggle"><span>Toggle</span></div>
		<h1>Date with remaing hour(s)</h1>
		<ul>
<?php
$counter=0;
while($counter < sizeof($workingHours)){
?>
			<li>
				<span><?= $workingDate[$counter]; ?></span>
				<?= $workingHours[$counter]; ?> Hour(s)
			</li>
<?php
	$counter++;
}
?>
		
		</ul>
	</div>
<?php
}
?>	
	<section class="c-content-1 content--lg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

<table class="js-data-table-3 c-table-1" data-display-length='50'>
	<thead>
		<tr>
			<th data-priority="3">Client</th>
			<th>Job Type</th>
			<th>Job Number</th>
			<th>Version</th>
			<th>Hours</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php 

if ($totalRecordsSelect > 0) :

	$counter=0;
	while($counter < sizeof($uID) ) :
		$jobDetail = $deptName[$jobDeptID[$jobTypeIDSelect[$counter]]]
						.' - '.$jobTypeName[$jobTypeIDSelect[$counter]];	
?>
		<tr>
			<td class="clientName"><?php echo $uClientNames[$clientIDSelect[ $counter ]]; ?></td>
			<td class="jobType">
				<?= $jobDetail; ?>
			</td>
			<td class="jobID"><?php echo $jobIDSelect[$counter]; ?></td>	
			<td class="jobVersion"><?php echo $jobVersionSelect[$counter]; ?></td>
			<td class="jobHours"><?php echo $jobHoursSelect[$counter]; ?></td>
			<td class="jobDate"><?php echo $uDateSelect[$counter]; ?></td>
			<td>
				<a href="#searchRecord"
					class="js-open-popup js-search-record">Edit</a>
				<input type="hidden" value="<?php echo($uID[$counter]); ?>"
					name="recordID" class="recordID">
				<input type="hidden" value="<?php echo($jobTypeIDSelect[$counter]); ?>"
					name="recordJobTypeID" class="recordJobTypeID">
				<input type="hidden" value="<?php echo($clientIDSelect[ $counter ]); ?>"
					name="recordClientID" class="recordClientID">
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
            <div class="c-form-sty form-sty--1 form--white">
                
<div class="c-form-item item--lg medium">
	<label for="clients2">Client Name</label>
	<select style="width: 100%" name="clients2" id="clients2"
		class="js-clients-2">
		<option value="0">Select client</option>		
	</select>
</div>

<div class="c-form-item large">
	<label for="jobtype2">Job Type</label>
	<select style="width: 100%" name="jobtype2" id="jobtype2"
		class="js-jobtype-2">
		<option value="0">Select Job Type</option>
	</select>
</div>

<div class="c-form-item js-JobID-2 small" style="display: none;">
	<label for="jobID2">Job Number</label>
	<input type="text" id="jobID2" name="jobID2" value="-">
</div>

<div class="c-form-item js-jobVersion-2 small" style="display: none;">
	<label for="jobVersion2">Version</label>
	<input type="text" id="jobVersion2" name="jobVersion2" value="">
</div>

<div class="c-form-item small">
	<label for="jobHours2">Hours
		<span>[Min. 0.5 - Max. 12]</span>
	</label>
	<input type="text" id="jobHours2" name="jobHours2"
		class="js-jobHours-2">
</div>

<div class="c-form-item date">
	<label for="jobDate2">Date</label>
	<input id="jobDate2" name="jobDate2" value="" class="js-jobDate-2 js-date-picker">
</div>

<div class="action">
	<a href="javascript:void(0);" class="c-btn btn--emp js-updateBtn">
		<i class="fa"></i>Update</a>
		<input type="hidden" name="updateRecordID" class="updateRecordID"
			id="updateRecordID">
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
                    <a href="javascript:void(0);"
                    	class="c-btn btn--sm btn--a btn--blue js-close-popup">No</a>
                    <a href="javascript:void(0)"
                    	class="c-btn btn--sm btn--a js-close-popup js-delete-record">
                    	Yes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="c-popups">
    <div class="overlay js-close-popup"></div>
    <div class="c-popup-1 popup" id="hoursAdded" style="width: 300px;">
        <div class="wrapper">
        	<div class="c-form-sty form-sty--1 form--white">
        		<div class="title">&nbsp;</div>
                <div class="sub-title" style="text-align: center;">
                	Time successfully added
            	</div>
                <div class="action action2">
                    <a href="javascript:void(0);"
                    	class="c-btn btn--sm btn--a btn--blue js-close-popup">OK</a>                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="c-popups">
    <div class="overlay js-close-popup"></div>
    <div class="c-popup-1 popup" id="hoursError" style="width: 400px;">
        <div class="wrapper">
        	<div class="c-form-sty form-sty--1 form--white"> 
        		<div class="title">&nbsp;</div>               
                <div class="sub-title" style="text-align: center;">
                	You can not add more than 12hrs to one day
            	</div>
                <div class="action action2">
                    <a href="javascript:void(0);"
                    	class="c-btn btn--sm btn--a btn--blue js-close-popup">OK</a>                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
-->
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

<?php
if($timeCheck == 1):
?>
<script>

$(document).ready(function() {
	openPopup("#hoursAdded");
});

</script>
<?php
endif;
?>

</body>
</html>