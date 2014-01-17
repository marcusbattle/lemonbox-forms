<?php
	
	/*
	Plugin Name: LemonBox Forms
	Plugin URI: http://lemonboxapps.com
	Description: LemonBox Forms
	Version: 0.0.1
	Author: LemonBox
	Author URI: http://lemonboxapps.com
	License: DO NOT STEAL
	*/

	function load_lemonbox_forms_admin_assets() {
		wp_enqueue_script('jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery') );
		wp_enqueue_script('jquery-mask', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.maskedinput.min.js', array('jquery') );
		wp_enqueue_script( 'lbox-forms-edit-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.js', array('jquery-mask') );
		wp_enqueue_script( 'lbox-forms-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.edit.js', array('jquery-ui') );
		wp_register_style( 'lbox-forms-edit-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.edit.css' );
        wp_enqueue_style( 'lbox-forms-edit-css' );

        wp_register_style( 'lbox-forms-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.css' );
        wp_enqueue_style( 'lbox-forms-css' );

        wp_localize_script( 'lbox-forms-edit-js', 'lemonbox', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	function load_lemonbox_forms_assets() {
		wp_enqueue_script( 'jquery-mask', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.maskedinput.min.js', array('jquery') );
		wp_enqueue_script( 'lbox-forms-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.js', array('jquery-mask') );

		wp_register_style( 'lbox-forms-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.css' );
        wp_enqueue_style( 'lbox-forms-css' );

		wp_localize_script( 'lbox-forms-js', 'lemonbox', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	function lemonbox_forms_settings() {
		add_menu_page( 'LemonBox Forms', 'Forms', 'administrator', 'lemonbox-forms', 'lbox_menu_home', '', 6 );
	}

	function lbox_menu_home() {

		ob_start();

		if ( isset($_GET['action']) && ($_GET['action'] == 'new') ) {
			include( plugin_dir_path( __FILE__ ) . 'pages/forms-edit.php' );
		} else if ( isset($_GET['action']) && ($_GET['action'] == 'edit') ) {
			include( plugin_dir_path( __FILE__ ) . 'pages/forms-edit.php' );
		} else {
			include( plugin_dir_path( __FILE__ ) . 'pages/forms-home.php' );
		}

		ob_flush();

	}

	function lbox_forms_init() {

		global $wpdb;

		// Create forms table
		$table_name = $wpdb->prefix . "lemonbox_forms";

		$sql = "CREATE TABLE $table_name (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			form_title varchar(128) NOT NULL,
			form_type varchar(64) NOT NULL DEFAULT 'custom',
			fields text,
			form_author mediumint(11) NOT NULL,
			confirmation_message text,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			UNIQUE KEY id (id)
		);";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);


		// create entries table
		$table_name = $wpdb->prefix . "lemonbox_entries";

		$sql = "CREATE TABLE $table_name (
			id mediumint(11) NOT NULL AUTO_INCREMENT,
			form_id mediumint(11) NOT NULL,
			entry text,
			user_id mediumint(11) DEFAULT 0,
			product_id mediumint(11),
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			UNIQUE KEY id (id)
		);";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

	}

	function lbox_get_forms() { 
		global $wpdb;

		$sql = "
			SELECT forms.*, COUNT(entries.id) AS entries, users.display_name AS author 
			FROM {$wpdb->prefix}lemonbox_forms AS forms
			LEFT JOIN {$wpdb->prefix}lemonbox_entries AS entries ON entries.form_id = forms.id
			LEFT JOIN {$wpdb->base_prefix}users AS users ON users.ID = forms.form_author
			GROUP BY forms.id
		";
		return $wpdb->get_results($sql);

	}

	function lemonbox_get_form( $form_id = 0 ) { 
		global $wpdb;

		$sql = "
			SELECT forms.*
			FROM {$wpdb->prefix}lemonbox_forms AS forms
			WHERE forms.id = $form_id
		";
		return $wpdb->get_row($sql);

	}

	function lbox_admin_class( $classes ) {

		if ( isset($_GET['page']) && ($_GET['page'] == 'lemonbox-forms') ) {
		    echo "lemonbox";
		}

	}

	function lbox_form_shortcode( $atts ){

		global $wpdb;

		extract( shortcode_atts( array(
			'name' => '',
			'id' => '',
		), $atts ) );

		if ( $name ) {

			$sql = "SELECT * FROM {$wpdb->prefix}lemonbox_forms WHERE form_title = '$name'";
			$form = $wpdb->get_row($sql);

		} elseif ( $id ) {

			$sql = "SELECT * FROM {$wpdb->prefix}lemonbox_forms WHERE id = '$id'";
			$form = $wpdb->get_row($sql);

		}

		if ( $form ) return "<form class=\"lemonbox-form\"><input type=\"hidden\" name=\"form_id\" value=\"{$form->id}\" />" . stripslashes($form->fields) . "</form>";

	}

	function lbox_process_form() {
		
		global $wpdb;

		if ( isset($_POST) ) {

			extract( $_POST );

			$site_name = get_bloginfo();
			$admin_email = get_bloginfo('admin_email');

			$form = lemonbox_get_form( $form_id );
			$mode = isset($_POST['mode']) ? $_POST['mode'] : 'live';

			if ( isset($_POST['fields']) ) extract( $_POST['fields'] );

			// Charge if product is present
			if ( isset($product_id) ) {
				
				// Set name for charge if available
				if ($first_name) $_POST['name'] = $first_name . ' ' . $last_name;

				$response = lemonbox_post_payments();

				if( !$response['success'] ) {
					echo json_encode( array( 'success' => false, 'msg' => $response->msg ) );
					exit;
				}

			}

			// E-mail receipt
			$email_to = isset($email) ? $email : '';
			$form_title = isset($form_title) ? $form_title : 'Receipt for your entry';

			$headers[] = "From: $site_name <$admin_email>";
			$headers[] = "Reply-To: $site_name <$admin_email>";
			$headers[] = "BCC: $site_name <$admin_email>";

			add_filter( 'wp_mail_content_type', 'set_html_content_type' );
			wp_mail( $email_to, $form_title, lemonbox_generate_form_receipt( $form->confirmation_message ), $headers );
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

			$data = array(
				'form_id' => $_POST['form_id'],
				'entry' => isset($_POST['fields']) ? serialize($_POST['fields']) : '',
				'user_id' => get_current_user_id(),
				'product_id' => isset( $product_id ) ? $product_id : 0
			);

			if ( $mode != 'preview' ) {
			
				$wpdb->insert( "{$wpdb->prefix}lemonbox_entries", $data );
				$msg = isset($response) ? $response['msg'] : $form->confirmation_message;
				echo json_encode( array( 'success' => true, 'msg' => $msg ) );
				exit;

			} else {

				echo json_encode( array( 'success' => false, 'msg' => 'There was a problem processing your request' ) );
				exit;

			}

		}

		exit;
	}

	function lbox_save_form() {

		global $wpdb;

		if ( $_POST['form_id'] ) {

			$response = $wpdb->update( "{$wpdb->prefix}lemonbox_forms", array( 
				'fields' => trim($_POST['html']), 
				'form_title' => $_POST['form_title'],
				'confirmation_message' => $_POST['confirmation_message'] 
			), array( 'id' => $_POST['form_id'] ) );

		} else {

			$response = $wpdb->insert( "{$wpdb->prefix}lemonbox_forms", array( 
				'fields' => trim($_POST['html']), 
				'form_title' => $_POST['form_title'],
				'form_type' => 'custom',
				'form_author' => get_current_user_id(),
				'confirmation_message' => $_POST['confirmation_message']
			) );

		}
		
		exit;
	}

	function lemonbox_generate_form_receipt( $message ) {

		if ( isset($_POST['fields']) ) {

			$message .= "<h3>Your Receipt</h3><ul>";

			foreach ( $_POST['fields'] as $field => $value ) {

				$message .= "<li>" . ucwords(str_replace( '_', ' ', $field)) . ": $value</li>";

			}

			$message .= "</ul>";

			if ( isset($_POST['product_id']) && function_exists('lemonbox_get_product') ) {

				$product = lemonbox_get_product( $_POST['product_id'] );

				$message .= "<h3>Your Purchase</h3>";
				$message .= "<p>{$product[0]->post_title} | Qty: " . $_POST['quantity'] . "</p>";

			}

			return $message;

		}

		return '';

	}

	function set_html_content_type() {
		return 'text/html';
	}

	add_action( 'init', 'lbox_forms_init' );
	add_action( 'admin_menu', 'lemonbox_forms_settings' );
	add_filter( 'admin_body_class', 'lbox_admin_class' );
	add_action( 'admin_enqueue_scripts', 'load_lemonbox_forms_admin_assets' );
	add_action( 'wp_enqueue_scripts', 'load_lemonbox_forms_assets' );
	add_shortcode( 'lemonbox_form', 'lbox_form_shortcode' );
	add_action( 'wp_ajax_lemonbox_process_form', 'lbox_process_form' );
	add_action( 'wp_ajax_nopriv_lemonbox_process_form', 'lbox_process_form' );
	add_action( 'wp_ajax_lemonbox_save_form', 'lbox_save_form' );
	add_action( 'wp_ajax_nopriv_lemonbox_save_form', 'lbox_save_form' );
?>