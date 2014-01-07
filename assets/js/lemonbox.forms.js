(function($){

	$(document).ready(function(){

		$('.lemonbox-fields li.date input').mask('99/99/9999');
		$('.lemonbox-fields .credit-card input[name="card_number"]').mask('9999 9999 9999 9999');
		$('.lemonbox-fields li.zip input').mask('99999');


		$('.lemonbox-fields li button[type="submit"]').on('click', function(e){
			e.preventDefault();

			var button = $(this);
			var button_text = $(this).text();
			var errors = false;

			$(this).attr('disabled','true').text('...');

			$('.required').each(function(){

				if ( $(this).val() == '' ) {
					$(this).addClass('error');
					errors = true;
				} else {
					$(this).removeClass('error');
				}

			});

			if ( errors ) {
				$(button).text(button_text).removeAttr('disabled');
				alert('Please complete the highlighted fields');
				return false;
			}

			$.ajax({
				type: 'POST',
			  	url: lemonbox.ajaxurl,
			  	data: $('.lemonbox-fields').closest('form').serialize() + '&action=lemonbox_process_form',
			  	dataType: 'json'
			}).done(function( data ) {
				$(button).text(button_text).removeAttr('disabled');

				alert( data.msg );

			});

		});

		$(document).on('change', '.lemonbox-fields .product select[name="quantity"]', function(){
			var price = $('.product input[name="price"]').val();

			$('.product .cost span').text( '$' + (price * $(this).val() ) );
		});

		$(document).on('keyup', '.lemonbox-fields .required', function(){
			$(this).removeClass('error');
		});

	});

})(jQuery);