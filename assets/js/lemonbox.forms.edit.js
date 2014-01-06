(function($){
	
	$(document).ready(function(){

		$('.lemonbox-fields.edit').sortable({ items: '> li', cancel: '.lemonbox-fields li.focus *' });

		$(document).on('click', '.lemonbox-fields.edit li', function(){
			
			var field_type = '';
			var field = '';

			$('.focus *').removeAttr('contenteditable');
			$('.focus').removeClass('focus');

			$(this).addClass('focus');
			$(this).find('label').attr('contenteditable', true);

			if ( $(this).hasClass('title') ) {

				field_type = 'title';
				$(this).find('h2').attr('contenteditable', true);

			} else if ( $(this).hasClass('text') ) {

				field_type = 'text';
				$(this).find('p').attr('contenteditable', true);

			} else if ( $(this).hasClass('dropdown') ) {

				field_type = 'dropdown';
				$(this).find('label').attr('contenteditable', true);

			} else if ( $(this).hasClass('textarea') ) {

				field_type = 'textarea';

			} else if ( $(this).hasClass('checkbox') ) {

				field_type = 'checkbox';

			}

			$('#form-inspector a[href="#field-settings"]').click();
			$('#form-inspector .type').text(field_type);
			$('#form-inspector .placeholder').text(field_type);

		});

		$('.form-action').on('click', function(e){

			$('.form-action.active').removeClass('active');
			$(this).addClass('active');

			if ( $(this).hasClass('preview') ) {

				$('.lemonbox-fields').addClass('preview').removeClass('edit');

			} else if ( $(this).hasClass('edit') ) {

				$('.lemonbox-fields').addClass('edit').removeClass('preview');

			}

		});

		$('.field-action').on('click', function(e){

			if ( $(this).hasClass('delete') ) {
				$('.lemonbox-fields li.focus').remove();
			}

		});

		$('.lemonbox-fields.edit button[type="submit"]').on('click', function(e){
			e.preventDefault();
		});


		$('#add-fields button').on('click', function(e){

			var field = $(this).find('li').clone();
			$('.lemonbox-fields li.submit').before(field);

		});

		$('button.save-form').on('click', function(e){
			e.preventDefault();

			var form_fields = $('.lemonbox-fields').parent().clone();
			$(form_fields).find('.lemonbox-fields').removeClass('edit ui-sortable');

			var button = $(this);
			var button_text = $(this).text();

			$(this).attr('disabled','true').text('...');

			$.ajax({
				type: 'POST',
			  	url: lemonbox.ajaxurl,
			  	data: {
			  		action: 'lemonbox_save_form',
			  		html: $(form_fields).html(),
			  		form_id: $(this).data('form-id')
			  	}
			}).done(function( data ) {
				$(button).text(button_text).removeAttr('disabled');

				alert('Done!');
			});

		});

		$("#form-inspector").tabs();

	});

	
	
})(jQuery);