<?php
	/*
	Plugin Name: Roar Media Pop-ups
	Description: A plugin that extends the Roar Media theme for additional popup functionality. <strong>Requires Roar Media theme and Advanced Custom Fields Pro!</strong>
	Version: 0.0.1
	Author: Roar Media, Kris Williams
	Author URI: mailto:webmaster@roarmedia.com
	*/
	$rm_themename = wp_get_theme();
	// Check if Roar Media child theme active and if ACF is being used.
	if ('roarmedia' === $rm_themename->get('TextDomain') && function_exists('acf_get_field')) {
	//// Register Custom Post Type
		function rm_popup() {
			$labels = array(
				'name'                  => _x( 'Pop-ups', 'Post Type General Name', 'text_domain' ),
				'singular_name'         => _x( 'Pop-up', 'Post Type Singular Name', 'text_domain' ),
				'menu_name'             => __( 'Pop-ups', 'text_domain' ),
				'name_admin_bar'        => __( 'Pop-up', 'text_domain' ),
				'archives'              => __( 'Pop-up Archives', 'text_domain' ),
				'attributes'            => __( 'Pop-up Attributes', 'text_domain' ),
				'parent_item_colon'     => __( 'Parent Pop-up:', 'text_domain' ),
				'all_items'             => __( 'All Pop-ups', 'text_domain' ),
				'add_new_item'          => __( 'Add New Pop-up', 'text_domain' ),
				'add_new'               => __( 'Add New', 'text_domain' ),
				'new_item'              => __( 'New Pop-up', 'text_domain' ),
				'edit_item'             => __( 'Edit Pop-up', 'text_domain' ),
				'update_item'           => __( 'Update Pop-up', 'text_domain' ),
				'view_item'             => __( 'View Pop-up', 'text_domain' ),
				'view_items'            => __( 'View Pop-ups', 'text_domain' ),
				'search_items'          => __( 'Search Pop-up', 'text_domain' ),
				'not_found'             => __( 'Not found', 'text_domain' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
				'featured_image'        => __( 'Featured Image', 'text_domain' ),
				'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
				'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
				'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
				'insert_into_item'      => __( 'Insert into pop-up', 'text_domain' ),
				'uploaded_to_this_item' => __( 'Uploaded to this pop-up', 'text_domain' ),
				'items_list'            => __( 'Pop-ups list', 'text_domain' ),
				'items_list_navigation' => __( 'Pop-ups list navigation', 'text_domain' ),
				'filter_items_list'     => __( 'Filter pop-ups list', 'text_domain' ),
			);
			$args = array(
				'label'                 => __( 'Pop-up', 'text_domain' ),
				'description'           => __( 'Create popups that are displayed in a lightbox', 'text_domain' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'revisions' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 20,
				'menu_icon'             => 'dashicons-format-aside',
				'show_in_admin_bar'     => false,
				'show_in_nav_menus'     => false,
				'can_export'            => true,
				'has_archive'           => false,
				'exclude_from_search'   => true,
				'publicly_queryable'    => false,
				'capability_type'       => 'page',
			);
			register_post_type( 'popup', $args );
		}
		add_action( 'init', 'rm_popup', 0 );
	//// Enqueue Scripts
		function rm_popup_scripts() {
			wp_enqueue_style( 'rm-popup-styles', plugins_url('assets/css/styles.css', __FILE__), false, '', 'all' );
			wp_enqueue_script( 'rm-popup-script', plugins_url('assets/js/scripts.js', __FILE__ ), array('jquery'), null, true );
		}
		add_action('wp_enqueue_scripts', 'rm_popup_scripts');
	//// Enable ALB
		function add_builder_to_popup($metabox)
		{
		  foreach($metabox as &$meta)
		  {
		    if($meta['id'] == 'avia_builder' || $meta['id'] == 'layout')
		    {
		      $meta['page'][] = 'popup'; /*instead add the name of the custom post type here*/
		    }
		  }
		  return $metabox;
		}
		add_filter('avf_builder_boxes', 'add_builder_to_popup');
	//// Copy Plugin ACFs to Theme ACFs
		function mv_rm_popup_acf() {
			$rm_popup_jsons = glob('./wp-content/plugins/rm-popup/assets/acf_json/*.json', GLOB_BRACE);
			foreach($rm_popup_jsons as $rm_popup_json) {
				$rm_popup_json_file = plugin_dir_path(__FILE__) . 'assets/acf_json/' . basename($rm_popup_json);
				$rm_acf_json_dir = get_stylesheet_directory() . '/includes/acf_json/';
				//copy($rm_popup_json_file, $rm_acf_json_dir . basename($rm_popup_json));
				if (!file_exists($rm_acf_json_dir . basename($rm_popup_json))) {
					copy($rm_popup_json_file, $rm_acf_json_dir . basename($rm_popup_json));
				}
			}
		}
		add_action('wp_head', 'mv_rm_popup_acf');
	//// Add Global Pop-up's page
		if( function_exists('acf_add_options_page') ) {	
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Global Pop-ups',
				'menu_title'	=> 'Global Pop-ups',
				'parent_slug'	=> 'edit.php?post_type=popup',
			));
		}
	//// Get Popup
		function get_rm_popup($target) {
			$rm_popup = array(
				'id' => get_field('rm_popup_post', $target),
			);
			if (get_field('rm_popup_start', $target)) {
				$rm_popup['start'] = get_field('rm_popup_start', $target);
			}
			if (get_field('rm_popup_end', $target)) {
				$rm_popup['end'] = get_field('rm_popup_end', $target);
			}
			if (get_field('rm_popup_freq', $target)) {
				$rm_popup['freq'] = get_field('rm_popup_freq', $target);
			}
			if (get_field('rm_popup_display', $target)) {
				$rm_popup['display'] = get_field('rm_popup_display', $target);
			}
			if (get_field('rm_popup_delay', $target)) {
				$rm_popup['delay'] = get_field('rm_popup_delay', $target);
			}
			if (get_field('rm_popup_anchor', $target)) {
				$rm_popup['anchor'] = get_field('rm_popup_anchor', $target);
			}
			return $rm_popup;
		}
	//// Make Popup
		function make_rm_popup($args) {
			$rm_popup_post = get_post($args['id']);
			$rm_popup_content = apply_filters('the_content', $rm_popup_post->post_content);
			if ($args['anchor'] && !empty($args['anchor'])) {
				$rm_popup_id = $args['anchor'];
			} else {
				$rm_popup_id = 'rm-popup-' . $args['id'];
			}
			$rm_popup_cookie = 'rmpu-' . $args['id'];
			$rm_popup_html = '<div id="%s" data-rmpu-cookie="%s" class="rm-popup mfp-hide">%s</div>';
			echo sprintf($rm_popup_html, $rm_popup_id, $rm_popup_cookie, $rm_popup_content);
		}
	//// Global Popup Args
		function rm_popup_global_args() {
			if (get_field('rm_popup_enabled', 'option')) {
				$rm_global_popup = get_rm_popup('option');

				$rm_popup_select = get_field('rm_popup_select', 'option');
				if ('all' !== $rm_popup_select) {
					$rm_popup_selected = get_field('rm_popup_posts', 'option');
				} else {
					$rm_popup_selected = null;
				}
				if (null !== $rm_popup_selected) {
					foreach ($rm_popup_selected as $rm_post_id) {
						if ('include' === $rm_popup_select && (is_single($rm_post_id) || is_page($rm_post_id))) {
							make_rm_popup($rm_global_popup);
						} elseif ('exclude' === $rm_popup_select && (!is_single($rm_post_id) && !is_page($rm_post_id))) {
							print_r($rm_global_popup);
						}
					}
				}
			}
		}
		add_action('wp_footer', 'rm_popup_global_args');
	}
?>