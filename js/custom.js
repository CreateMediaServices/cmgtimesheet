$('.js-SubmitBtn').click(function () {

	var clients = $('#clients');
	var jobID = $('#jobID');
	var cName = $('#cName');
	var jobVersion = $('#jobVersion');
	var jobHours = $('#jobHours');
	var jobtype = $('#jobtype');
	var jobtypeNew = $('#jobtype-new');
	var userID = $('#userID');
	var siteBaseURL = $('#siteBaseURL').val();
	var targetURL = $('#targetURL').val();
	var jobDate = $('#jobDate');
	var userName = $('#userNameValue').val();
	var clientCheck = $('#clientCheck').val();

	var checkError = 0;
	
	clients.parent().removeClass('error');
	jobtype.parent().removeClass('error');
	jobID.parent().removeClass('error');
	jobVersion.parent().removeClass('error');
	jobHours.parent().removeClass('error');
	jobtypeNew.parent().removeClass('error');


	if (clients.val() == '0') {
		clients.parent().addClass('error');
		checkError = 1;
	}	

	if(clients.val() == 24 && jobtypeNew.val() == ''){
		jobtypeNew.parent().addClass('error');
		checkError = 1;			
	}else if (jobtype.val() == '0' && clients.val() != 24) {
		jobtype.parent().addClass('error');
		checkError = 1;		
	}


	if (jobID.val() == '' && clientCheck == '1') {
		jobID.parent().addClass('error');
		checkError = 1;
	}	

	if (jobVersion.val() == '' && clientCheck == '1') {
		jobVersion.parent().addClass('error');
		checkError = 1;
	}	
	
	if (jobHours.val() == "") {
		jobHours.parent().addClass('error');
		checkError = 1;
	}	

	if (jobHours.val() > 12 || jobHours.val() < 0.5 ) {
		jobHours.parent().addClass('error');
		checkError = 1;
	}		

	if (jobDate.val() == "") {
		jobDate.parent().addClass('error');
		checkError = 1;
	}	
	
	jobTypeValue = jobtype.val();
	jobTypeNewValue = jobtypeNew.val();
	// if(cName.val()){
	// 	jobTypeValue = cName.val();
	// }

	// alert("Test"+checkError+" "+clients.val()+" "+jobtypeNew.val());

	if(clientCheck == '0'){
		jobID.val('');
		jobVersion.val('');
	}

	if (checkError == 0) {

		var q = 'clients=' + clients.val();		
		q += '&jobID=' + jobID.val();
		q += '&jobVersion=' + jobVersion.val();
		q += '&jobHours=' + jobHours.val();
		q += '&jobtype=' + jobTypeValue;
		q += '&jobtypeNew=' + jobTypeNewValue;
		q += '&jobDate=' + jobDate.val();
		q += '&userName=' + userName;

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					window.location.replace(targetURL+"?timeCheck=1");	
				}else if(result == '100'){					
					openPopup("#hoursError");
					jobHours.parent().addClass('error');
				}			
			}
		});

	}

});


$('.js-add-jobtype').click(function () {
	
	var clientID = $('#clientID');
	var deptID = $('#deptID');
	var jobTitle = $('#jobTitle');	
	var siteBaseURL = $('#siteBaseURL').val();	
	
	var checkError = 0;

	$('.success').fadeOut('fast');
	$('.fail').fadeOut('fast');

	clientID.parent().removeClass('error');
	deptID.parent().removeClass('error');		
	jobTitle.parent().removeClass('error');		

	if (clientID.val() == '0' || clientID.val() == '') {
		clientID.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (deptID.val() == '0' || deptID.val() == '') {
		deptID.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (jobTitle.val() == '' ) {
		jobType.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (checkError == 0) {

		var q = 'clientID=' + clientID.val();		
		q += '&deptID=' + deptID.val();
		q += '&jobTitle=' + jobTitle.val();

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					$('.success').fadeIn('slow');	
				}
			}
		});

	}

});

$('.js-add-projectType').click(function () {
	
	var projectType = $('#projectType');	
	var siteBaseURL = $('#siteBaseURL').val();	
	
	var checkError = 0;
	$('.success').fadeOut('fast');
	$('.fail').fadeOut('fast');

	projectType.parent().removeClass('error');	

	if (projectType.val() == '' ) {
		projectType.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (checkError == 0) {

		var q = 'projectType=' + projectType.val();		

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					$('.success').fadeIn('slow');	
				}				
			}
		});

	}

});

$('.js-add-client').click(function () {
	
	var projectType = $('#projectType');
	var clientName = $('#clientName');	
	var jobID = $('#jobID');		
	var siteBaseURL = 'addclient-new.php';	
	var checkError = 0;

	$('.success').fadeOut('fast');
	$('.fail').fadeOut('fast');

	projectType.parent().removeClass('error');
	clientName.parent().removeClass('error');		

	if (projectType.val() == '0' || projectType.val() == '') {
		projectType.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (clientName.val() == '' ) {
		clientName.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (checkError == 0) {

		var q = 'projectType=' + projectType.val();		
		q += '&clientName=' + clientName.val();
		q += '&jobID=' + jobID.val();
		
		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					$('.success').fadeIn('slow');	
				}		
			}
		});

	}

});


$('.js-add-dept').click(function () {
	
	var deptName = $('#deptName');	
	var siteBaseURL = $('#siteBaseURL').val();	
	var checkError = 0;

	$('.success').fadeOut('fast');
	$('.fail').fadeOut('fast');

	deptName.parent().removeClass('error');	

	if (deptName.val() == '' ) {
		deptName.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (checkError == 0) {

		var q = 'deptName=' + deptName.val();		
		
		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					$('.success').fadeIn('slow');	
				}		
			}
		});

	}

});


$('.js-update-dept').click(function () {
	
	var deptID = $('#deptID');
	var clientID = $('#clientID');		
	var siteBaseURL = $('#siteBaseURL').val();	
	var checkError = 0;

	$('.success').fadeOut('fast');
	$('.fail').fadeOut('fast');

	deptID.parent().removeClass('error');
	clientID.parent().removeClass('error');		

	if (deptID.val() == '0' || deptID.val() == '') {
		deptID.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (clientID.val() == '' ) {
		clientID.parent().addClass('error');
		checkError = 1;
		$('.fail').fadeIn('slow');
	}

	if (checkError == 0) {

		var q = 'deptID=' + deptID.val();		
		q += '&clientID=' + clientID.val();
		
		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				if(result == 'success'){
					$('.success').fadeIn('slow');	
				}		
			}
		});

	}

});





$('.js-updateBtn').click(function () {

	var clients = $('#clients2');
	var jobID = $('#jobID2');
	var jobVersion = $('#jobVersion2');
	var jobHours = $('#jobHours2');
	var jobtype = $('#jobtype2');
	var jobDate = $('#jobDate2');
	var jobtypeNew = $('#jobtype-new2');
	var userID = $('#userID');
	var recordID = $('#updateRecordID').val();
	var siteBaseURL = $('#updateURL').val();
	var targetURL = $('#targetURL').val();	
	var clientCheck = $('#clientCheck').val();
	var userName = $('#userNameValue').val();

	var checkError = 0;

	clients.parent().removeClass('error');
	jobtype.parent().removeClass('error');
	jobID.parent().removeClass('error');
	jobVersion.parent().removeClass('error');
	jobHours.parent().removeClass('error');
	jobDate.parent().removeClass('error');
	jobtypeNew.parent().removeClass('error');

	if (clients.val() == '0') {
		clients.parent().addClass('error');
		checkError = 1;
	}

	if(clients.val() == 24 && jobtypeNew.val() == ''){
		jobtypeNew.parent().addClass('error');
		checkError = 1;			
	}else if (jobtype.val() == '0' && clients.val() != 24) {
		jobtype.parent().addClass('error');
		checkError = 1;		
	}	

	if (jobID.val() == '' && clientCheck == '1') {
		jobID.parent().addClass('error');
		checkError = 1;
	}

	if (jobVersion.val() == '' && clientCheck == '1') {
		jobVersion.parent().addClass('error');
		checkError = 1;
	}

	if (jobHours.val() == "") {
		jobHours.parent().addClass('error');
		checkError = 1;
	}

	if (jobDate.val() == "") {
		jobDate.parent().addClass('error');
		checkError = 1;
	}	

	if(clientCheck == '0'){
		jobID.val('');
		jobVersion.val('');
	}

	if (checkError == 0) {

		var q = 'clients=' + clients.val();		
		q += '&jobID=' + jobID.val();
		q += '&jobVersion=' + jobVersion.val();
		q += '&jobHours=' + jobHours.val();
		q += '&jobtype=' + jobtype.val();
		q += '&jobtypeNew=' + jobtypeNew.val();
		q += '&recordID=' + recordID;
		q += '&jobDate=' + jobDate.val();
		q += '&userName=' + userName;

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {				
				if(result == 'success'){
					window.location.replace(targetURL+"?timeCheck=1");	
				}else if(result == '100'){					
					openPopup("#hoursError");
					jobHours.parent().addClass('error');
				}
			}
		});

	}

});


$('#uPassword').keydown(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
                
        var uName = $('#uName');
		var uPassword = $('#uPassword');
		var siteBaseURL = $('#siteBaseURL').val();
		var targetURL = $('#targetURL').val();
		var checkError = 0;

		uName.parent().removeClass('error');
		uPassword.parent().removeClass('error');
		$('.error-msg').removeClass('show-error');

		if (uName.val() == '') {
			uName.parent().addClass('error');
			checkError = 1;
		}

		if (uPassword.val() == '') {
			uPassword.parent().addClass('error');
			checkError = 1;
		}

		if (checkError == 0) {

			var q = 'uName=' + uName.val();
			q += '&uPassword=' + uPassword.val();

			$.ajax({
				type: "POST",
				url: siteBaseURL,
				data: q,
				cache: false,
				success: function (result) {

					if (result == "success") {
						window.location.replace(targetURL);
					}
					else{
						$('.error-msg').addClass('show-error');
					}
				}
			});

		}

    }  
});

$('.js-LoginBtn').click(function () {

	var uName = $('#uName');
	var uPassword = $('#uPassword');
	var siteBaseURL = $('#siteBaseURL').val();
	var targetURL = $('#targetURL').val();
	var checkError = 0;

	uName.parent().removeClass('error');
	uPassword.parent().removeClass('error');
	$('.error-msg').removeClass('show-error');

	if (uName.val() == '') {
		uName.parent().addClass('error');
		checkError = 1;
	}

	if (uPassword.val() == '') {
		uPassword.parent().addClass('error');
		checkError = 1;
	}

	if (checkError == 0) {

		var q = 'uName=' + uName.val();
		q += '&uPassword=' + uPassword.val();

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {

				if (result == "success") {
					window.location.replace(targetURL);
				}
				else{
					$('.error-msg').addClass('show-error');
				}
			}
		});

	}

});


$('.js-search-record').click(function () {

	var clientName = $(this).parent().parent().find('.clientName').html();
	var jobType = $(this).parent().parent().find('.jobType').html();
	var jobNumber = $(this).parent().parent().find('.js-jobNumber').html();	
	var jobVersion = $(this).parent().parent().find('.jobVersion').html();
	var jobHours = $(this).parent().parent().find('.jobHours').html();
	var jobDate = $(this).parent().parent().find('.jobDate').html();
	var recordID = $(this).parent().find('.recordID').val();	
	var recordJobTypeID = $(this).parent().find('.recordJobTypeID').val();
	var recordClientID = $(this).parent().find('.recordClientID').val();	
	var targetURL = $('#editURL').val();
	
	var q = 'recordID=' + recordID;
	q += '&clientName=' + clientName;
	q += '&jobType=' + jobType;
	q += '&jobHours=' + jobHours;
	q += '&jobVersion=' + jobVersion;
	q += '&jobNumber=' + jobNumber;
	q += '&recordJobTypeID=' + recordJobTypeID;
	q += '&recordClientID=' + recordClientID;
	q += '&jobDate=' + jobDate;

	$('.js-JobNumber-2').fadeOut('fast');
	$('.js-jobVersion-2').fadeOut('fast');

	$('.js-jobtype2').fadeIn();
    $('.js-jobtype-new-2').fadeOut();

	$.ajax({
		type: "POST",
		url: targetURL,
		data: q,
		cache: false,
		success: function (result) {

			result = jQuery.parseJSON(result);

			$('.js-clients-2').empty();
			$('#jobtype2').empty();			

            $('.js-clients-2').append(result.clients);
            $('#jobtype2').append(result.jobType);
            $('#jobtype-new2').val(result.jobNumber);
            $('#jobID2').val(result.jobNumber);            
            $('#jobVersion2').val(result.jobVersion);
            $('.js-jobHours-2').val(jobHours);
            $('.js-jobDate-2').val(jobDate);

            if(recordClientID == 24){
            	$('.js-jobtype2').fadeOut();
            	$('.js-jobtype-new-2').fadeIn('slow');
            }

            if(result.jobVersion > 0){
            	$('.js-JobNumber-2').fadeIn('fast');
            	$('.js-jobVersion-2').fadeIn('fast');            	
            }
            
            $('.updateRecordID').val(recordID);

		}
	});

});

$('.js-search-delete').click(function () {

	var recordID = $(this).parent().find('.recordID').val();
    $('.deleteRecordID').val(recordID);	

});


$('.js-deleteBtn').click(function () {

	var recordID = $('.deleteRecordID').val();
	var siteBaseURL = $('#deleteURL').val();
	var targetURL = $('#targetURL').val();		

    $('.updateRecordID').val(recordID);

    var q = 'recordID=' + recordID;	

    $.ajax({
		type: "POST",
		url: siteBaseURL,
		data: q,
		cache: false,
		success: function (result) {
			window.location.replace(targetURL);
		}
	});

});


$('.js-close-popup').click(function (e) {
	e.preventDefault();
	closePopup();
});

$('.js-open-popup').click(function (e) {
		e.preventDefault();

		var target = $(this).attr('href');		
		openPopup(target);
});

function openPopup(target) {

	$('html').addClass('popup-open');
		
	$(target).closest('.c-popups').show();
	$(target).show();

	setTimeout(function () {
		$(target).closest('.c-popups').addClass('show');
		$(target).addClass('show-this');
	}, 10);
		
}

function closePopup() {
	/*if (typeof player !== 'undefined') {
		player.pauseVideo();
	}*/

	$('html').removeClass('popup-open');

	if($('.c-popups .js-video').length > 0){
		var thisVideoId = Math.abs($('.c-popups .js-video').attr('data-video-id'));
		players[thisVideoId].player.pauseVideo();
	}

	$('.c-popups').removeClass('show');
	$('.c-popups .popup').removeClass('show-this');

	setTimeout(function () {
		$('.c-popups').hide();
		$('.c-popups .popup').hide();
	}, 600);
}



$(".js-clients").change(function () {
	var selectedItem = $(this).val();

	$('.js-JobID').fadeOut();
	$('.js-jobVersion').fadeOut();
	$('.js-cName').fadeOut();
	$('.js-jobtype-new').fadeOut();
	$('.js-jobtype').fadeIn('slow');

	$('#clientCheck').val('0');
	
	var siteBaseURL = $('#clientBaseURL').val();
	var checkError = 0;

	if(selectedItem == 0 ){
		checkError = 1;		
	}	

	if(selectedItem == 24){		
		$('.js-jobtype').fadeOut();
		$('.js-jobtype-new').fadeIn('slow');		
	}else if (checkError == 0) {
	
		var q = 'clients=' + selectedItem;		

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {	

				result = jQuery.parseJSON(result);
                	
				$('#jobtype').empty();
				$('#jobtype').append(result.html);

				if(result.clientJobVersion == 1){
					$('.js-JobID').fadeIn('slow');
					$('.js-jobVersion').fadeIn('slow');					
					$('#clientCheck').val('1');					
				}
			}
		});

	}
	
});


$(".js-clients-2").change(function () {
	var selectedItem = $(this).val();

	$('.js-JobID-2').fadeOut();
	$('.js-jobVersion-2').fadeOut();
	$('.js-cName').fadeOut();
	$('.js-jobtype-new-2').fadeOut();
	$('.js-jobtype2').fadeIn('slow');

	$('#clientCheck').val('0');
	
	var siteBaseURL = $('#clientBaseURL').val();
	var checkError = 0;

	if(selectedItem == 0 ){
		checkError = 1;		
	}

	if(selectedItem == 24){		
		$('.js-jobtype2').fadeOut();
		$('.js-jobtype-new-2').fadeIn('slow');		
	}else if (checkError == 0) {
		
		var q = 'clients=' + selectedItem;		

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {	

				result = jQuery.parseJSON(result);
                	
				$('#jobtype2').empty();
				$('#jobtype2').append(result.html);

				if(result.clientJobVersion == 1){
					$('.js-JobID-2').fadeIn('slow');
					$('.js-jobVersion-2').fadeIn('slow');
					$('#clientCheck').val('1');					
				}
			}
		});

	}
	
});
