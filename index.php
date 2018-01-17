<?php
session_start();
include("config.php");
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

<body>
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

	<section class="c-main-box">
		<header class="header">
			<a href="#" class="c-logo-w-title"><i class="c-logo">Create Media Group</i><i class="txt">Timesheet</i></a>
		</header>
		<div class="box-wrapper">
			<form class="c-form-sty form--emp">
			<div class="row">
				<div class="col-md-12">
					<div class="error-msg">Invalid user name or password</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<input type="text" placeholder="Name" name="uName" id="uName">
					<input type="password" placeholder="Password" name="uPassword" id="uPassword" style="margin-bottom: 20px;">
				</div>
			</div>		
			<div class="row">
				<div class="col-md-12">
					<input type="button" class="c-btn btn--emp js-LoginBtn" value="Login">
					<input type="hidden" name="siteBaseURL" id="siteBaseURL" value="<?php echo($siteBaseURL.'/login-new.php'); ?>">
					<input type="hidden" name="targetURL" id="targetURL" value="<?php echo($siteBaseURL.'/time-tracking-new.php'); ?>">
				</div>
			</div>
			</form>
		</div>
	</section>
	<div class="t-layout u-mh-100">
		<div class="t-row">
			<div class="t-col">
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
	<script src="js/main.js"></script>
	<script src="js/custom.js"></script>
	
</body>

</html>