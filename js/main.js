$(function () {
	
	$('.js-module-toggle').click(function(e){
		e.preventDefault();
		$(this).parent().toggleClass('is--closed');
	});

	$('.js-date-picker').datetimepicker({
		format: 'YYYY-MM-DD',
		maxDate: moment()
	});

	/*$('.js-date-picker').click(function () {
		console.log($('.dropdown-menu')[0].outerHTML);
	});*/

	$('.js-linked-popup').click(function (e) {
		e.preventDefault();
		var target = $(this).attr('href');
		activePopup(target);
	});

	$('.js-popup-close').click(function (e) {
		e.preventDefault();
		closePopup();
	});

	function activePopup(target) {
		$(target).show();
		setTimeout(function () {
			$(target).addClass('active');
		});
		
		$('body').addClass('popup-active');

		if($(target+' .js-focus-me').get(0)){
			$(target+' .js-focus-me').focus();
		}
	}

	function closePopup() {
		$('.js-is-popup').removeClass('active');
		setTimeout(function () {
			$('.js-is-popup').hide()
		}, 350);
		$('body').removeClass('popup-active');
	}

	globalCalc();
	swapItems();

	$("select").select2({
		// minimumResultsForSearch: Infinity
	});

	$(".js-carousel-1").owlCarousel({
		// items: Carousel1Items,
		nav: true,
		margin: 20,
		responsive : {
		    0 : {
		    	items: 2
		    },
		    768 : {
		    	items: 3
		    },
		    992 : {
		    	items: 4
		    },
		    1100 : {
		    	items: 5
		    },
		    1300 : {
		    	items: 6
		    }
		}
	});

	dataTableObj = $('.js-data-table').DataTable({
		dom: '<"top"fB>t<"bottom"ip>',
		responsive: true,
		buttons: [
			{
				text: 'View Archives',
				className: 'c-btn btn--blue',
				action: function ( e, dt, button, config ) {
			    	window.location = 'archive.php';
			    }
			},{
				text: '<i class="fa fa-file-excel-o"></i> Downlaod as Excel',
				extend: 'excel',
				className: 'c-btn btn--blue'
			}
		],
	});


	$(document).ready(function() {
	    $('.js-data-table-2').DataTable({
	        "bPaginate": false,
	        "bFilter": false,
	        "bInfo": false
	    });

	    $('.js-data-table-3').DataTable( {
	        "order": [[ 5, "desc" ]]
	    } );

	    $('.js-data-table-4').DataTable( {
	        "order": [[ 6, "desc" ]]
	    } );

	});


	// File Upload
	if($('#fileupload').get(0)){
		
		/*$('#fileupload').fileupload({
			progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $('#file-progress').css(
		            'height', progress + '%'
		        );
		        if(progress >= 100){
		        	previewImage(document.getElementById('fileupload'));
		        }
		    }
	    });*/

	    if (isAdvancedUpload()){
	    	$('.c-fileinput-button .js-drag-txt').show();
	    }

	    if(Modernizr.filereader && isAdvancedUpload()){
	    	$('.c-fileinput-button').addClass('is-fancy');
		    $('#fileupload').change(function () {
		    	previewImage(this);
		    });
	    }

    }

});

$(window).resize(function () {
	swapItems();
	globalCalc();
});


windowWidth = 0;
windowHeight = 0;
function globalCalc() {
	windowWidth = $(window).width();
	windowHeight = $(window).height();
}

function isAdvancedUpload(){
	var div = document.createElement( 'div' );
	return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
}

function previewImage(input){
	console.log(input.files);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#file-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function swapItems() {
	$('[data-swap-mobile]').each(function () {
		var thisTarget = $(this).attr('data-swap-mobile');

		if(thisTarget == 'next'){
			if(windowWidth<992){
				if(!$(this).hasClass('is-swaped')){
					$(this).addClass('is-swaped');
					$(this).insertAfter($(this).next());
				}
			}else{
				if($(this).hasClass('is-swaped')){
					$(this).removeClass('is-swaped');
					$(this).insertBefore($(this).prev());
				}
			}
		}

	});
}