(function($){

	$(document).ready(function(){

		$('.lemonbox-fields li.birthdate input').mask('99/99/9999');
		$('.lemonbox-fields li.credit-card input[name="card_number"]').mask('9999 9999 9999 9999');
		$('.lemonbox-fields li.zip input').mask('99999');
	});

})(jQuery);