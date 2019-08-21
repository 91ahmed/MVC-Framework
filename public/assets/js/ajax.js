/** User Registration **/
$(function(){
	$('.ajax-form').on('submit', function(e){
		e.preventDefault();

		var formData     = new FormData($(this)[0]);
		var formAction   = $(this).attr('action');
		var formMethod   = $(this).attr('method');
		var formRedirect = $(this).attr('data-redirect'); 

		$.ajax({
			url: formAction,
			method: formMethod,
			datatType: 'json',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () 
			{
				$('.ajax-errors ul').empty();
				$('.ajax-errors').fadeOut('fast');
				$('.ajax-form input, .ajax-form textarea').attr('disabled', 'disabled');
			},
			success: function (data) 
			{
				$('.ajax-errors').fadeOut('fast');
				$('.ajax-form input, .ajax-form textarea').removeAttr('disabled');

				if (formRedirect == 'save') {
					//$('.ajax-save').fadeIn('fast');

					// Reset From Inputs
					document.getElementsByClassName("ajax-form")[0].reset();
					$('form :input').val('');
					$('form :textarea').val('');
					$('.myfile_name').html('');
				} else if (formRedirect == 'update') {
					//$('.ajax-update').fadeIn('fast');
				} else if (formRedirect == 'delete') {
					//$('.ajax-delete').fadeIn('fast');
				} else if(formRedirect == 'restore') {
					//$('.ajax-restore').fadeIn('fast');
				} else if(formRedirect == 'load') {
					//window.location.reload();
				} else if(formRedirect !== 'off') {
					window.location.href = formRedirect;
				}
			},
			error: function (data, exception)
			{
				$('.ajax-errors').fadeIn('fast');
				$('.ajax-errors ul').empty();
				$('.ajax-form input, .ajax-form textarea').removeAttr('disabled');

				if(exception == 'error'){
					var errors = data.responseJSON;

					$.each(errors, function(key, value){
						$('.ajax-errors ul').append('<li>'+value+'</li>');
					});
				}
			},
		});
 
		return false;
	});
});
