(function($){
	
	$(document).ready(function(){

		$('.lemonbox-form').sortable();
		$('.lemonbox-form').disableSelection();

		/* 
		$("#form-inspector").tabs();
		$('#dropdown-creator > div').sortable();

		$('.lemonbox-fields').addClass('edit');

		$('.lemonbox-fields.edit').sortable({ items: '> li', cancel: '.lemonbox-fields li.focus *' });

		$('h3.form-title').text( $('input[name="form_title"]').val() );
		$('#form-settings .form-title').val( $('input[name="form_title"]').val() );

		$(document).on('click', '.lemonbox-fields.edit li', function(){
			
			var field_type = '';
			var field = '';
			var required = ($(this).find('input,textarea,select').hasClass('required')) ? 1 : 0;

			$('.focus *').removeAttr('contenteditable');
			$('.focus').removeClass('focus');
			$('#field-settings .product-settings').hide();
			$('#field-settings .general-settings').show();
			$('#field-settings .dropdown-settings').hide();

			$('#field-settings input').val('');

			$(this).addClass('focus');
			$(this).find('label').attr('contenteditable', true);

			if ( $(this).hasClass('title') ) {

				field_type = 'title';
				$(this).find('h2').attr('contenteditable', true);

			} else if ( $(this).hasClass('text') ) {

				field_type = 'text';
				$(this).find('p').attr('contenteditable', true);
				$('#field-settings .general-settings').hide();

			} else if ( $(this).hasClass('dropdown') ) {

				field_type = 'dropdown';
				$(this).find('label').attr('contenteditable', true);
				$('#field-settings .dropdown-settings').show();

				$('#dropdown-creator').html('');

				$(this).find('select option').each(function( i, v ){
					$('#dropdown-creator').append('<div class="option" data-index="' + (i + 1) + '"><input class="option-value" value="' + $(this).val() + '" /><input class="option-text" value="' + $(this).text() + '" /><a class="delete-option">Delete</a></div>');
				});

			} else if ( $(this).hasClass('textarea') ) {

				field_type = 'textarea';

			} else if ( $(this).hasClass('checkbox') ) {

				field_type = 'checkbox';

			} else if ( $(this).hasClass('submit') ) {

				field_type = 'submit';

			} else if ( $(this).hasClass('product') ) {

				$('#field-settings .general-settings').hide();
				$('#field-settings .product-settings').show();
				$('#field-settings .product-settings').find('.product').val( $(this).find('input[name="product_id"]').val() );
				$('#field-settings .product-settings').find('.max-quantity').val( $(this).find('select[name="quantity"] option:last-child').val() );
				$('#field-settings .product-settings').find('.payment-type').val( $(this).find('input[name="payment_type"]').val() );

			} 

			if ( ( field_type != 'title' ) && ( field_type != 'submit' ) ) {
				var field_name = $(this).find('input,textarea,select').attr('name')
				field_name = field_name.substring(7,field_name.length-1);
			} else {
				field_name = '';
			}

			$('#form-inspector a[href="#field-settings"]').click();
			$('#form-inspector .label').val( $(this).find('label').text() );
			$('#form-inspector .placeholder').val( $(this).find('input,textarea').attr('placeholder') );
			$('#form-inspector .field-name').val( field_name );
			$('#form-inspector .required').val( required );

		});
	
		$(document).on('keyup change', '#form-inspector input, #field-settings select', function(){

			if ( $(this).hasClass('label') ) {
				
				$('.lemonbox-fields .focus label').text( $(this).val() );

			} else if ( $(this).hasClass('placeholder') ) {
				
				$('.lemonbox-fields .focus').find('input,textarea').attr( 'placeholder', $(this).val() );

			} else if ( $(this).hasClass('field-name') ) {

				$('.lemonbox-fields .focus').find('input,textarea,select').attr( 'name', 'fields[' + $(this).val() + ']' );

			} else if ( $(this).hasClass('form-title') ) {

				$('h3.form-title').text( $(this).val() );
				$('.lemonbox-fields input[name="form_title"]').val( $(this).val() );

			} else if ( $(this).hasClass('product') ) {
				
				$('.lemonbox-fields input[name="product_id"]').val( $(this).val() );
				$('.lemonbox-fields .product-title').text( $(this).find(':selected').text() );
				$('.lemonbox-fields .cost span').text('$' + $(this).find(':selected').data('price') );
				$('.lemonbox-fields input[name="price"]').val( $(this).find(':selected').data('price') );

			} else if ( $(this).hasClass('max-quantity') ) {

				$('.lemonbox-fields select[name="quantity"]').html('');
				
				var total = ($(this).val() * 1) + 1;
				for( var x = 1; x < total; x++ ) {
					$('.lemonbox-fields select[name="quantity"]').append('<option value="' + x + '">' + x + '</option>');
				}

			} else if ( $(this).hasClass('option-text') ) {

				$('.lemonbox-fields .focus select').find('option:nth-child(' + $(this).parent().data('index') + ')').text( $(this).val() );

			} else if ( $(this).hasClass('option-value') ) {

				$('.lemonbox-fields .focus select').find('option:nth-child(' + $(this).parent().data('index') + ')').val( $(this).val() );

			} else if ( $(this).hasClass('required') ) {

				if ( $(this).val() == 1 ) $('.lemonbox-fields .focus').find('input,select,textarea').addClass('required');
				else $('.lemonbox-fields .focus').find('input,select,textarea').removeClass('required');

			} else if ( $(this).hasClass('payment-type') ) {
				
				$('.lemonbox-fields .focus input[name="payment_type"]').val( $(this).val() );

				if ( $(this).val() == 'cash' ) {
					$('.lemonbox-fields .focus .credit-card').hide();
					$('.lemonbox-fields .focus .credit-card').find('.required').removeClass('required');
				} else {
					$('.lemonbox-fields .focus .credit-card').show();
					$('.lemonbox-fields .focus .credit-card').find('input').addClass('required');
				}

			}

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
				$('#form-inspector a[href="#form-settings"]').click();
			}

		});

		$('.lemonbox-fields.edit button[type="submit"]').on('click', function(e){
			e.preventDefault();
		});


		$('#add-fields button').on('click', function(e){

			var field = $(this).find('li').clone();
			$('.lemonbox-fields li.submit').before(field);

			$('.lemonbox-fields li.date input').mask('99/99/9999');
			$('.lemonbox-fields .credit-card input[name="card_number"]').mask('9999 9999 9999 9999');
			$('.lemonbox-fields li.zip input').mask('99999');

		});

		$('button.save-form').on('click', function(e){
			e.preventDefault();

			var form_fields = $('.lemonbox-fields').parent().clone();
			$(form_fields).find('.lemonbox-fields').removeClass('edit ui-sortable');
			$(form_fields).find('*').removeAttr('contenteditable').removeClass('focus');
			$(form_fields).find('input[name="mode"]').remove();

			var button = $(this);
			var button_text = $(this).text();

			$(this).attr('disabled','true').text('...');

			$.ajax({
				type: 'POST',
			  	url: lemonbox.ajaxurl,
			  	data: {
			  		action: 'lemonbox_save_form',
			  		html: $(form_fields).html(),
			  		form_id: $(this).data('form-id'),
			  		confirmation_message: $('#confirmation-message').val(),
			  		form_title: $('.lemonbox-fields input[name="form_title"]').val(),
			  		best: 'one in town'
			  	}
			}).done(function( data ) {
				$(button).text(button_text).removeAttr('disabled');

				alert('Done!');
			});

		});

		$('.add-option').on('click', function(){
			$('.lemonbox-fields .focus select').append('<option></option>');
			add_option();
		});

		$(document).on('click', '.delete-option', function(){
			$('.lemonbox-fields .focus select').find('option:nth-child(' + $(this).parent().data('index') + ')').remove();
			$(this).parent().remove();
		});

		function add_option() {
			var i = $('#dropdown-creator > div').length;
			$('#dropdown-creator').append('<div class="option" data-index="' + (i + 1) + '"><input class="option-value" /><input class="option-text" /><a class="delete-option">Delete</a></div>');
		}

		*/

	});

	
	
})(jQuery);