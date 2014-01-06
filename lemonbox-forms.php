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

	function lbox_forms_settings() {
		add_menu_page( 'LemonBox Forms', 'Forms', 'administrator', 'lemonbox-forms', 'lbox_menu_home', '', 6 );
	}

	function lbox_menu_home() {
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'templates/forms-home.php' );
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
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			UNIQUE KEY id (id)
		);";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

	}

	function get_lbox_forms() { 
		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}lemonbox_forms";
		return $wpdb->get_results($sql);

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
		
		if ( isset($_POST) ) {

			global $wpdb;

			extract( $_POST['fields'] );

			$email_to = isset($email) ? $email : '';

			$data = array(
				'form_id' => $_POST['form_id'],
				'entry' => serialize($_POST['fields']),
				'user_id' => get_current_user_id()
			);

			$wpdb->insert( "{$wpdb->prefix}lemonbox_entries", $data );

		}

		exit;
	}

	function lbox_save_form() {

		global $wpdb;

		$response = $wpdb->update( "{$wpdb->prefix}lemonbox_forms", array( 'fields' => $_POST['html'] ), array( 'id' => $_POST['form_id'] ) );
		echo $response;
		exit;
	}

	add_action( 'init', 'lbox_forms_init' );
	add_action( 'admin_menu', 'lbox_forms_settings' );
	add_filter( 'admin_body_class', 'lbox_admin_class' );
	add_action( 'admin_enqueue_scripts', 'load_lemonbox_forms_admin_assets' );
	add_action( 'wp_enqueue_scripts', 'load_lemonbox_forms_assets' );
	add_shortcode( 'lemonbox_form', 'lbox_form_shortcode' );
	add_action( 'wp_ajax_lemonbox_process_form', 'lbox_process_form' );
	add_action( 'wp_ajax_lemonbox_save_form', 'lbox_save_form' );
	add_action( 'wp_ajax_nopriv_lemonbox_save_form', 'lbox_save_form' );
?>