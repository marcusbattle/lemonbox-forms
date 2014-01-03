(function($){
	
	$(document).ready(function(){

		$('.lemonbox-fields.edit').sortable({ items: '> li', cancel: '.lemonbox-fields li.focus *' });

		$('.lemonbox-fields.edit li').on('click', function(){
			
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

			$('#field-inspector .type').text(field_type);
			$('#field-inspector .placeholder').text(field_type);

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
	});

	
	
})(jQuery);