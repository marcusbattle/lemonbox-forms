(function($){

	$(document).ready(function(){

		$('.lemonbox-fields li.birthdate input').mask('99/99/9999');
		$('.lemonbox-fields li.credit-card input[name="card_number"]').mask('9999 9999 9999 9999');
		$('.lemonbox-fields li.zip input').mask('99999');


		$('.lemonbox-fields li button[type="submit"]').on('click', function(e){
			e.preventDefault();

			var button = $(this);
			var button_text = $(this).text();

			$(this).attr('disabled','true').text('...');

			$.ajax({
				type: 'POST',
			  	url: lemonbox.ajaxurl,
			  	data: $('.lemonbox-fields').closest('form').serialize() + '&action=lemonbox_process_form'
			}).done(function( data ) {
				$(button).text(button_text).removeAttr('disabled');

				alert('Done!');
			});

		});
	});

})(jQuery);