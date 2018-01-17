$('.js-SubmitBtn').click(function () {

	var clients = $('#clients');
	var jobID = $('#jobID');
	var jobVersion = $('#jobVersion');
	var jobHours = $('#jobHours');
	var jobtype = $('#jobtype');
	var userID = $('#userID');
	var siteBaseURL = $('#siteBaseURL').val();
	var targetURL = $('#targetURL').val();
	var checkError = 0;

	clients.parent().removeClass('error');
	jobtype.parent().removeClass('error');
	jobID.parent().removeClass('error');
	jobVersion.parent().removeClass('error');
	jobHours.parent().removeClass('error');

	if (clients.val() == '0') {
		clients.parent().addClass('error');
		checkError = 1;
	}

	if (jobtype.val() == '0') {
		jobtype.parent().addClass('error');
		checkError = 1;
	}


	if (jobID.val() == '-' && clients.val() == '20') {
		jobID.parent().addClass('error');
		checkError = 1;
	}

	if (jobVersion.val() == '-' && clients.val() == '20') {
		jobVersion.parent().addClass('error');
		checkError = 1;
	}

	if (jobHours.val() == "") {
		jobHours.parent().addClass('error');
		checkError = 1;
	}


	if (checkError == 0) {

		var q = 'clients=' + clients.val();		
		q += '&jobID=' + jobID.val();
		q += '&jobVersion=' + jobVersion.val();
		q += '&jobHours=' + jobHours.val();
		q += '&jobtype=' + jobtype.val();

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				window.location.replace(targetURL);
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
	var userID = $('#userID');
	var recordID = $('#updateRecordID').val();
	var siteBaseURL = $('#updateURL').val();
	var targetURL = $('#targetURL').val();	
	var checkError = 0;

	clients.parent().removeClass('error');
	jobtype.parent().removeClass('error');
	jobID.parent().removeClass('error');
	jobVersion.parent().removeClass('error');
	jobHours.parent().removeClass('error');

	if (clients.val() == '0') {
		clients.parent().addClass('error');
		checkError = 1;
	}

	if (jobtype.val() == '0') {
		jobtype.parent().addClass('error');
		checkError = 1;
	}


	if (jobID.val() == '-' && clients.val() == '20') {
		jobID.parent().addClass('error');
		checkError = 1;
	}

	if (jobVersion.val() == '-' && clients.val() == '20') {
		jobVersion.parent().addClass('error');
		checkError = 1;
	}

	if (jobHours.val() == "") {
		jobHours.parent().addClass('error');
		checkError = 1;
	}


	if (checkError == 0) {

		var q = 'clients=' + clients.val();		
		q += '&jobID=' + jobID.val();
		q += '&jobVersion=' + jobVersion.val();
		q += '&jobHours=' + jobHours.val();
		q += '&jobtype=' + jobtype.val();
		q += '&recordID=' + recordID;

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {
				window.location.replace(targetURL);
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
	var jobID = $(this).parent().parent().find('.jobID').html();	
	var jobVersion = $(this).parent().parent().find('.jobVersion').html();
	var jobHours = $(this).parent().parent().find('.jobHours').html();
	var recordID = $(this).parent().find('.recordID').val();
	var targetURL = $('#editURL').val();
	
	var q = 'recordID=' + recordID;
	q += '&clientName=' + clientName;
	q += '&jobType=' + jobType;
	q += '&jobVersion=' + jobVersion;

	$('.js-JobID-2').fadeOut('fast');
	$('.js-JobVersion-2').fadeOut('fast');

	$.ajax({
		type: "POST",
		url: targetURL,
		data: q,
		cache: false,
		success: function (result) {

			result = jQuery.parseJSON(result);

			$('.js-clients-2').empty();
			$('.js-jobtype-2').empty();
			$('.js-jobVersion-2').empty();

            $('.js-clients-2').append(result.clients);
            $('.js-jobtype-2').append(result.jobType);
            $('.js-jobVersion-2').append(result.tplJobVersion);
            $('.js-jobID-2').val(jobID);
            $('.js-jobHours-2').val(jobHours);
            if(jobID != '-'){
            	$('.js-JobID-2').fadeIn('fast');
            }
            if(jobVersion != '-'){
            	$('.js-JobVersion-2').fadeIn('fast');
            }
            
            
            $('.updateRecordID').val(recordID);
                     
            //jQuery('#totalPage').val(result.totalPage);
            
            // if( result.currentPage == result.totalPage || result.html == '' ){
            //     jQuery('.js-load-competions').fadeOut('fast');                
            // }

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
	$('.js-JobVersion').fadeOut();

	if (selectedItem == "19") {
		$('.js-JobID').fadeIn('slow');
	}
	if (selectedItem == "20") {
		$('.js-JobID').fadeIn('slow');
		$('.js-JobVersion').fadeIn('slow');
	}
		
	var siteBaseURL = $('#clientBaseURL').val();
	var checkError = 0;

	if(selectedItem == 0 ){
		checkError = 1;
		
	}

	if (checkError == 0) {

		
		var q = 'clients=' + selectedItem;		

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {				
					$('#jobtype').empty();
					$('#jobtype').append(result);				
			}
		});

	}
	
});


$(".js-clients-2").change(function () {
	var selectedItem = $(this).val();

	$('.js-JobID-2').fadeOut();
	$('.js-JobVersion-2').fadeOut();

	if (selectedItem == "19") {
		$('.js-JobID-2').fadeIn('slow');
	}
	if (selectedItem == "20") {
		$('.js-JobID-2').fadeIn('slow');
		$('.js-JobVersion-2').fadeIn('slow');
	}
		
	var siteBaseURL = $('#clientBaseURL').val();
	var checkError = 0;

	if(selectedItem == 0 ){
		checkError = 1;
		
	}

	if (checkError == 0) {

		
		var q = 'clients=' + selectedItem;		

		$.ajax({
			type: "POST",
			url: siteBaseURL,
			data: q,
			cache: false,
			success: function (result) {				
					$('#jobtype2').empty();
					$('#jobtype2').append(result);				
			}
		});

	}
	
});
