(function($){
	
	$(document).ready(function(){

		// Initialize sortable functionality for form fields
		$('#lbox-fields').sortable({
			containment: 'parent',
			stop: function( event, ui ) { update_form_html(); }
		}).disableSelection();		

		// Initialize inspector menu
		$('#lbox-field-inspector > div.custom-setting').each(function(){

			var settings_title = $(this).data('title');
			var settings_id = settings_title.replace(' ','-').toLowerCase();

			$(this).attr( 'id', settings_id );

			$('#lbox-field-inspector > ul').append( '<li><a href="#' + settings_id + '">' + settings_title + '</li>' );

		});

		$('#lbox-field-inspector').tabs({ 
			active: 0
		});

		// Initialize 'clear form' button to reset form
		$('#clear-fields').on( 'click', function(e) {
			e.preventDefault;

			$('#lbox-fields').html('');
			update_form_html();

		});

		// Add a new field to the form
		$('#add-fields button').on('click', function(e){

			e.preventDefault();

			var field = $(this).find('> div').clone(true);

			$('#lbox-fields').append(field);

			$('#lbox-fields div.date input').mask('99/99/9999');
			$('#lbox-fields .credit-card input[name="card_number"]').mask('9999 9999 9999 9999');
			$('#lbox-fields div.zip input').mask('99999');

			$('#TB_closeWindowButton').click();

			update_form_html();

			$('#lbox-field-inspector').tabs();

		});

		// Set listener for when settings change the value

		// $("#form-inspector").tabs();
		// $('#dropdown-creator > div').sortable();

		// $('.lemonbox-fields').addClass('edit');

		// $('.lemonbox-fields.edit').sortable({ items: '> li', cancel: '.lemonbox-fields li.focus *' });

		// $('h3.form-title').text( $('input[name="form_title"]').val() );
		// $('#form-settings .form-title').val( $('input[name="form_title"]').val() );

		// Actions to trigger edit options when field is selected
		$(document).on('click', '#lbox-fields > div', function(){

			var field = $(this);
			var field_type = field.data('field-type');

			var label = ($(this).find('label').length) ? $(this).find('label').text() : '';
			var field_name = ($(this).find('input').length) ? $(this).find('input').attr('name') : '';
			var required = ($(this).find('input,textarea,select').hasClass('required')) ? 1 : 0;
			var placeholder_text = ($(this).find('input').length) ? $(this).find('input').attr('placeholder') : '';

			var name_disabled = ($(this).data('disable-name')) ? $(this).data('disable-name') : false;
			var placeholder_disabled = ($(this).data('disable-placeholder')) ? $(this).data('disable-placeholder') : false;

			// Remove 'fields' prefix from name
			field_name = (field_name.length) ? field_name.substring(7,field_name.length-1) : '';

			// $('.focus *').removeAttr('contenteditable');
			$('.focus').removeClass('focus');
			$(this).addClass('focus');
			// $('#field-settings .product-settings').hide();
			// $('#field-settings .general-settings').show();
			$('#field-settings .dropdown-settings').hide();

			$('#lbox-field-inspector input').val('');

			// $(this).find('label').attr('contenteditable', true);

			// Update standard inspector fields
			$('input.label').val( label );
			$('input.field-name').val( field_name ).attr('disabled',name_disabled);
			$('select.required').val( required );
			$('input.placeholder').val( placeholder_text ).attr('disabled',placeholder_disabled);

			if ( $(this).hasClass('title') ) {

				field_type = 'title';
				// $(this).find('h2').attr('contenteditable', true);

			} else if ( $(this).hasClass('text') ) {

				field_type = 'text';
				// $(this).find('p').attr('contenteditable', true);
				$('#field-settings .general-settings').hide();

			} else if ( field_type == 'dropdown' ) {

				var options = '';

				$('#field-settings .dropdown-settings').show();

				field.find('option').each(function( index, value ){

					if (( $(this).val() !== '' ) && ( $(this).val() !== '--' )) {
						options += $(this).text() + ':' + $(this).val() + '\n';
					}

				});

				$('.dropdown-settings textarea').val( options );

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
		
		// Pre-select the first field to load the inspector
		$('#lbox-fields > div:first-of-type').click();

		$(document).on('keyup change', '#lbox-field-inspector #field-settings input,textarea,select', function(){

			var edit_field = $(this);
			var related_to = edit_field.data('rel');
			var value = edit_field.val();

			if ( $(this).hasClass('label') ) {
				
				$('#lbox-fields .focus label').text( $(this).val() );

			}

			if ( related_to == 'dropdown' ) {

				var options = value.split(/\n/);
				var select = $('#lbox-fields .focus select');
				var is_multiple = select.attr('multiple');

				if ( !is_multiple )
					select.html('<option>--</option>');

				$(options).each(function( index, value ){
					
					var option = value.split(':');

					if (( option[1] !== undefined ) && option[1] && option[0] )
						select.append('<option value="' + option[1] + '">' + option[0] + '</option>');

				});

			}

			if ( related_to == 'format' ) {
				
				var select = $('#lbox-fields .focus select');

				if ( value == 'multiple' ) 
					select.attr( value, value );
				else 
					select.removeAttr( 'multiple' );

			}

			// } else if ( $(this).hasClass('placeholder') ) {
				
			// 	$('.lemonbox-fields .focus').find('input,textarea').attr( 'placeholder', $(this).val() );

			// } else if ( $(this).hasClass('field-name') ) {

			// 	$('.lemonbox-fields .focus').find('input,textarea,select').attr( 'name', 'fields[' + $(this).val() + ']' );

			// } else if ( $(this).hasClass('form-title') ) {

			// 	$('h3.form-title').text( $(this).val() );
			// 	$('.lemonbox-fields input[name="form_title"]').val( $(this).val() );

			// } else if ( $(this).hasClass('product') ) {
				
			// 	$('.lemonbox-fields input[name="product_id"]').val( $(this).val() );
			// 	$('.lemonbox-fields .product-title').text( $(this).find(':selected').text() );
			// 	$('.lemonbox-fields .cost span').text('$' + $(this).find(':selected').data('price') );
			// 	$('.lemonbox-fields input[name="price"]').val( $(this).find(':selected').data('price') );

			// } else if ( $(this).hasClass('max-quantity') ) {

			// 	$('.lemonbox-fields select[name="quantity"]').html('');
				
			// 	var total = ($(this).val() * 1) + 1;
			// 	for( var x = 1; x < total; x++ ) {
			// 		$('.lemonbox-fields select[name="quantity"]').append('<option value="' + x + '">' + x + '</option>');
			// 	}

			// } else if ( $(this).hasClass('option-text') ) {

			// 	$('.lemonbox-fields .focus select').find('option:nth-child(' + $(this).parent().data('index') + ')').text( $(this).val() );

			// } else if ( $(this).hasClass('option-value') ) {

			// 	$('.lemonbox-fields .focus select').find('option:nth-child(' + $(this).parent().data('index') + ')').val( $(this).val() );

			// } else if ( $(this).hasClass('required') ) {

			// 	if ( $(this).val() == 1 ) $('.lemonbox-fields .focus').find('input,select,textarea').addClass('required');
			// 	else $('.lemonbox-fields .focus').find('input,select,textarea').removeClass('required');

			// } else if ( $(this).hasClass('payment-type') ) {
				
			// 	$('.lemonbox-fields .focus input[name="payment_type"]').val( $(this).val() );

			// 	if ( $(this).val() == 'cash' ) {
			// 		$('.lemonbox-fields .focus .credit-card').hide();
			// 		$('.lemonbox-fields .focus .credit-card').find('.required').removeClass('required');
			// 	} else {
			// 		$('.lemonbox-fields .focus .credit-card').show();
			// 		$('.lemonbox-fields .focus .credit-card').find('input').addClass('required');
			// 	}

			// }

			update_form_html();

		});

		// $('.form-action').on('click', function(e){

		// 	$('.form-action.active').removeClass('active');
		// 	$(this).addClass('active');

		// 	if ( $(this).hasClass('preview') ) {

		// 		$('.lemonbox-fields').addClass('preview').removeClass('edit');

		// 	} else if ( $(this).hasClass('edit') ) {

		// 		$('.lemonbox-fields').addClass('edit').removeClass('preview');

		// 	}

		// });

		$('.field-action').on('click', function(e){

			if ( $(this).hasClass('delete') ) {
				$('#lbox-fields > div.focus').remove();
				//$('#form-inspector a[href="#form-settings"]').click();
				$('#lbox-fields > div:first-of-type').click();
				$('#lbox-field-inspector input').val('');
			}

		});

		// $('.lemonbox-fields.edit button[type="submit"]').on('click', function(e){
		// 	e.preventDefault();
		// });


		

		// $('button.save-form').on('click', function(e){
		// 	e.preventDefault();

		// 	var form_fields = $('.lemonbox-fields').parent().clone();
		// 	$(form_fields).find('.lemonbox-fields').removeClass('edit ui-sortable');
		// 	$(form_fields).find('*').removeAttr('contenteditable').removeClass('focus');
		// 	$(form_fields).find('input[name="mode"]').remove();

		// 	var button = $(this);
		// 	var button_text = $(this).text();

		// 	$(this).attr('disabled','true').text('...');

		// 	$.ajax({
		// 		type: 'POST',
		// 	  	url: lemonbox.ajaxurl,
		// 	  	data: {
		// 	  		action: 'lemonbox_save_form',
		// 	  		html: $(form_fields).html(),
		// 	  		form_id: $(this).data('form-id'),
		// 	  		confirmation_message: $('#confirmation-message').val(),
		// 	  		form_title: $('.lemonbox-fields input[name="form_title"]').val(),
		// 	  		best: 'one in town'
		// 	  	}
		// 	}).done(function( data ) {
		// 		$(button).text(button_text).removeAttr('disabled');

		// 		alert('Done!');
		// 	});

		// });

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


		window.update_form_html = function update_form_html() {

			var form_fields = $('#lbox-fields').clone();

			form_fields.removeClass('ui-sortable');
			form_fields.find('> div').removeClass('focus');

			$('#lbox-form-html').val( form_fields.html() );

			// console.log( 'dom changed' );

			return true;

			$(form_fields).find('#lbox-fields').removeClass('edit ui-sortable');
			
			$(form_fields).find('input[name="mode"]').remove();

		}

		// Populate the html field
		update_form_html();

	});

	
	
})(jQuery);