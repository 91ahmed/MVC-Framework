/**
 *	Detect online/offline internet connection
 */
$(function(){
	setInterval(function(){
		if(navigator.onLine == true){
			$('#connection').fadeOut('fast');
			// online
		}else{
			$('#connection').fadeIn('fast');
			// offline
		} 
	}, 2000);
});

/**
 *	Remove error message when input focus.
 */
$(function(){
	$('input, textarea, select').on('keyup, focusin', function(){
		$('.ajax-errors').fadeOut('fast');
	});
});

/*
$(function(){
	$(window).one('mousemove', function() { 
		if(navigator.onLine == true){
			return true; // online
		}else{
			$.toast({
			    heading: '<b>Connection Error!!</b>',
			    text: 'Please check your internet connection .',
			    showHideTransition: 'fade',
			    loader: false,
			    hideAfter: false,
			    stack: true,
			    icon: 'error'
			});

			return false; // offline
		}  
    }); 
});
*/