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
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
			);
			register_post_type( 'popup', $args );
		}
		add_action( 'init', 'rm_popup', 0 );
	}
?>