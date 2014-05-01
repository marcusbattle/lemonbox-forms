<?php
	
	/*
	Plugin Name: LemonBox Forms
	Plugin URI: http://lemonboxcreative.com
	Description: LemonBox Forms
	Version: 0.0.1
	Author: LemonBox
	Author URI: http://lemonboxcreative.com
	License: DO NOT STEAL
	*/

	

	function load_lemonbox_forms_assets() {
		wp_enqueue_script( 'jquery-mask', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.maskedinput.min.js', array('jquery') );
		wp_enqueue_script( 'lbox-forms-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.js', array('jquery-mask') );

		wp_register_style( 'lbox-forms-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.css' );
        wp_enqueue_style( 'lbox-forms-css' );

		wp_localize_script( 'lbox-forms-js', 'lemonbox', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	function lemonbox_forms_settings() {
		// add_menu_page( 'LemonBox Forms', 'Forms', 'administrator', 'lemonbox-forms', 'lbox_menu_home', '', 6 );
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

	function lbox_forms() {

		$labels = array(
			'name'               => _x( 'Forms', 'post type general name' ),
			'singular_name'      => _x( 'Form', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'form' ),
			'add_new_item'       => __( 'Add New Form' ),
			'edit_item'          => __( 'Edit Form' ),
			'new_item'           => __( 'New Form' ),
			'all_items'          => __( 'All Forms' ),
			'view_item'          => __( 'View Form' ),
			'search_items'       => __( 'Search Forms' ),
			'not_found'          => __( 'No forms found' ),
			'not_found_in_trash' => __( 'No forms found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Forms',
			'can_export'			=> true
		);
		
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our forms and form specific data',
			'public'        => true,
			'menu_position' => 31,
			'supports'      => array( 'title', 'thumbnail' ),
			'has_archive'   => false,
			'show_in_nav_menus' => true,
			'rewrite' 			=> array( 'slug' => 'forms' ),
			'capability_type' => 'page',
			'hierarchical'	=> false,
			'publicly_queryable' => true,
			'query_var' => true,
			'can_export' => true
		);

		register_post_type('lemonbox_form',$args);

		// global $wpdb;

		// // Create forms table
		// $table_name = $wpdb->prefix . "lemonbox_forms";

		// $sql = "CREATE TABLE $table_name (
		// 	id mediumint(11) NOT NULL AUTO_INCREMENT,
		// 	form_title varchar(128) NOT NULL,
		// 	form_type varchar(64) NOT NULL DEFAULT 'custom',
		// 	fields text,
		// 	form_author mediumint(11) NOT NULL,
		// 	confirmation_message text,
		// 	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		// 	UNIQUE KEY id (id)
		// );";
		
		// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		// dbDelta($sql);


		// // create entries table
		// $table_name = $wpdb->prefix . "lemonbox_entries";

		// $sql = "CREATE TABLE $table_name (
		// 	id mediumint(11) NOT NULL AUTO_INCREMENT,
		// 	form_id mediumint(11) NOT NULL,
		// 	entry text,
		// 	user_id mediumint(11) DEFAULT 0,
		// 	product_id mediumint(11),
		// 	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
		// 	UNIQUE KEY id (id)
		// );";
		
		// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		// dbDelta($sql);

		add_thickbox(); // Makes sure that ThickBox support is loaded

	}

	function lbox_forms_admin_assets() {

		wp_enqueue_script('jquery-ui', '//code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery') );
		wp_enqueue_script('jquery-mask', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.maskedinput.min.js', array('jquery') );
		wp_enqueue_script( 'lbox-forms-edit-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.js', array('jquery-mask') );
		wp_enqueue_script( 'lbox-forms-js', plugin_dir_url( __FILE__ ) . '/assets/js/lemonbox.forms.edit.js', array('jquery-ui') );
		
		wp_register_style( 'lbox-forms-edit-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.edit.css' );
        wp_enqueue_style( 'lbox-forms-edit-css' );

        wp_register_style( 'lbox-forms-css', plugin_dir_url( __FILE__ ) . '/assets/css/lemonbox.forms.css' );
        // wp_enqueue_style( 'lbox-forms-css' );

        wp_localize_script( 'lbox-forms-edit-js', 'lemonbox', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	// Remove the slug from published post permalinks. Only affect our CPT though.
	function lbox_forms_slug_rewrite( $permalink, $post, $leavename ) {
		
	    if ( 'lemonbox_form' == $post->post_type && 'publish' == $post->post_status && !is_admin() ) {
	     	$permalink = str_replace( '/forms/', '/', $permalink );
	    }
	 
	    return $permalink;

	}

	function lbox_forms_query( $query ) {

        if( $query->is_main_query() && !$query->get('post_type') ) { 

            $post_name = $query->get('pagename'); 
            $page = get_page_by_path( $post_name, OBJECT, 'lemonbox_form' );
            $post_type = ($page) ? $page->post_type : '';

            if ( $post_type == 'lemonbox_form' ) {	

	            $query->set('lemonbox_form', $post_name); 
	            $query->set('post_type', $post_type); 
	            $query->is_single = true; 
	            $query->is_page = false; 

	        }	

        } 

        return $query;

	}

	function lbox_forms_meta_boxes() {
		add_meta_box( 'lbox-form-fields', 'Form Fields', 'lbox_forms_meta_box_form_fields', 'lemonbox_form', 'normal', 'high' );
		add_meta_box( 'lbox-form-settings', 'Form Settings', 'lbox_forms_meta_box_form_settings', 'lemonbox_form', 'normal', 'high' );
		add_meta_box( 'lbox-form-confirmation-mesage', 'Confirmation Message', 'lbox_forms_meta_box_confirmation_message', 'lemonbox_form', 'normal', 'high' );
	}

	function lbox_forms_meta_box_form_fields( $post ) {
		include plugin_dir_path( __FILE__ ) . 'templates/editor.php';
	}

	function lbox_forms_meta_box_form_settings( $post ) {
		include plugin_dir_path( __FILE__ ) . 'templates/settings.php';
	}

	function lbox_forms_meta_box_confirmation_message( $post ) {

		$confirmation_message = get_post_meta( $post->ID, 'confirmation_message', true );

		wp_editor( $confirmation_message, 'confirmation_message', $settings = array( 'textarea_rows' => 8 ) );

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

	function lbox_form_shortcode( $atts ) {

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

	function lbox_save_form( $post_id ) {

		// Update the form content by saving the form fields
		remove_action( 'save_post', 'lbox_save_form' );

		if ( isset($_REQUEST['_form_fields']) ) {

			$form = array(
			      'ID' => $post_id,
			      'post_content' => $_REQUEST['_form_fields']
			);

			$updated = wp_update_post( $form );

		}

		add_action( 'save_post', 'lbox_save_form' );

		// Save confirmation message
		if ( isset($_POST['confirmation_message']) ) {
			update_post_meta( $post_id, 'confirmation_message', $_POST['confirmation_message'] );
		}

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


	function lbox_form_filter_content( $content ) {

		if ( get_post_type() == 'lemonbox_form' ) {

			remove_filter( 'the_content', 'wpautop' );

			echo "<form class=\"lbox-form\" method=\"post\" action=\"\">";
			echo $content;
			echo '<button type="submit" class="btn btn-default">Submit</button>';
			echo "</form>";

			return false;

		}

		return $content;

	}

	function lbox_form_fields( ) {
		// config variable go here
	}

	add_action( 'init', 'lbox_forms' );
	add_action( 'admin_enqueue_scripts', 'lbox_forms_admin_assets' );

	add_filter( 'post_type_link', 'lbox_forms_slug_rewrite', 10, 3 );
	add_action( 'pre_get_posts', 'lbox_forms_query' );

	add_action( 'add_meta_boxes', 'lbox_forms_meta_boxes' );
	add_action( 'save_post', 'lbox_save_form' );

	add_filter( 'the_content', 'lbox_form_filter_content', 0 );
	// add_action( 'admin_menu', 'lemonbox_forms_settings' );
	
	
	add_action( 'wp_enqueue_scripts', 'load_lemonbox_forms_assets' );
	add_shortcode( 'lemonbox_form', 'lbox_form_shortcode' );

	add_action( 'wp_ajax_lemonbox_process_form', 'lbox_process_form' );
	add_action( 'wp_ajax_nopriv_lemonbox_process_form', 'lbox_process_form' );

	add_action( 'lbox_form_fields', 'lbox_form_fields', 10 );
?>