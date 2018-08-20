<?php 

/*
 * Post Types for plugin
 * @package HTD_Contact_Form
 */

class HTD_CF_Post_Type {

	public function __construct(){

		// $this->init();


	}

	public static function init(){
		self::htd_register_post_type();
		// add_action( 'init', array( 'HTD_Custom_Post_Type', 'htd_register_post_type' ) );

	}

	/**
	 * Registers a new post type
	 * @uses $wp_post_types Inserts new post type object into the list
	 *
	 * @param string  Post type key, must not exceed 20 characters
	 * @param array|string  See optional args description above.
	 * @return object|WP_Error the registered post type object, or an error object
	 */
	public static function htd_register_post_type () {

		$labels = array(
			'name'               => __( 'HTD Contact Forms', 'htd-contact-form' ),
			'singular_name'      => __( 'HTD Contact Form', 'htd-contact-form' ),
			'add_new'            => _x( 'Add New HTD Contact Form', 'htd-contact-form', 'htd-contact-form' ),
			'add_new_item'       => __( 'Add New HTD Contact Form', 'htd-contact-form' ),
			'edit_item'          => __( 'Edit HTD Contact Form', 'htd-contact-form' ),
			'new_item'           => __( 'New HTD Contact Form', 'htd-contact-form' ),
			'view_item'          => __( 'View HTD Contact Form', 'htd-contact-form' ),
			'search_items'       => __( 'Search HTD Contact Forms', 'htd-contact-form' ),
			'not_found'          => __( 'No HTD Contact Forms found', 'htd-contact-form' ),
			'not_found_in_trash' => __( 'No HTD Contact Forms found in Trash', 'htd-contact-form' ),
			'parent_item_colon'  => __( 'Parent HTD Contact Form:', 'htd-contact-form' ),
			'menu_name'          => __( 'HTD Contact Forms', 'htd-contact-form' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-welcome-add-page',
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
				'author',
				
			),
		);

		register_post_type( 'htd-contact-form', $args );
	}



}



?>