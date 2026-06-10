<?php
/**
 * Custom Taxonomies
 *
 * Registers Department and Treatment Type taxonomies.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Taxonomies {

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_department' ) );
		add_action( 'init', array( $this, 'register_treatment_type' ) );
	}

	/**
	 * Register Department taxonomy.
	 * Applies to: Doctors, Services.
	 */
	public function register_department() {
		$labels = array(
			'name'                       => _x( 'Departments', 'Taxonomy General Name', 'developer-starter-pro' ),
			'singular_name'              => _x( 'Department', 'Taxonomy Singular Name', 'developer-starter-pro' ),
			'menu_name'                  => esc_html__( 'Departments', 'developer-starter-pro' ),
			'all_items'                  => esc_html__( 'All Departments', 'developer-starter-pro' ),
			'parent_item'                => esc_html__( 'Parent Department', 'developer-starter-pro' ),
			'parent_item_colon'          => esc_html__( 'Parent Department:', 'developer-starter-pro' ),
			'new_item_name'              => esc_html__( 'New Department Name', 'developer-starter-pro' ),
			'add_new_item'               => esc_html__( 'Add New Department', 'developer-starter-pro' ),
			'edit_item'                  => esc_html__( 'Edit Department', 'developer-starter-pro' ),
			'update_item'                => esc_html__( 'Update Department', 'developer-starter-pro' ),
			'view_item'                  => esc_html__( 'View Department', 'developer-starter-pro' ),
			'separate_items_with_commas' => esc_html__( 'Separate departments with commas', 'developer-starter-pro' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove departments', 'developer-starter-pro' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'developer-starter-pro' ),
			'popular_items'              => esc_html__( 'Popular Departments', 'developer-starter-pro' ),
			'search_items'               => esc_html__( 'Search Departments', 'developer-starter-pro' ),
			'not_found'                  => esc_html__( 'Not Found', 'developer-starter-pro' ),
			'no_terms'                   => esc_html__( 'No departments', 'developer-starter-pro' ),
			'items_list'                 => esc_html__( 'Departments list', 'developer-starter-pro' ),
			'items_list_navigation'      => esc_html__( 'Departments list navigation', 'developer-starter-pro' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'         => 'department',
				'with_front'   => false,
				'hierarchical' => true,
			),
		);

		register_taxonomy( 'department', array( 'doctors', 'services' ), $args );
	}

	/**
	 * Register Treatment Type taxonomy.
	 * Applies to: Services.
	 */
	public function register_treatment_type() {
		$labels = array(
			'name'                       => _x( 'Treatment Types', 'Taxonomy General Name', 'developer-starter-pro' ),
			'singular_name'              => _x( 'Treatment Type', 'Taxonomy Singular Name', 'developer-starter-pro' ),
			'menu_name'                  => esc_html__( 'Treatment Types', 'developer-starter-pro' ),
			'all_items'                  => esc_html__( 'All Treatment Types', 'developer-starter-pro' ),
			'parent_item'                => esc_html__( 'Parent Treatment Type', 'developer-starter-pro' ),
			'parent_item_colon'          => esc_html__( 'Parent Treatment Type:', 'developer-starter-pro' ),
			'new_item_name'              => esc_html__( 'New Treatment Type Name', 'developer-starter-pro' ),
			'add_new_item'               => esc_html__( 'Add New Treatment Type', 'developer-starter-pro' ),
			'edit_item'                  => esc_html__( 'Edit Treatment Type', 'developer-starter-pro' ),
			'update_item'                => esc_html__( 'Update Treatment Type', 'developer-starter-pro' ),
			'view_item'                  => esc_html__( 'View Treatment Type', 'developer-starter-pro' ),
			'separate_items_with_commas' => esc_html__( 'Separate treatment types with commas', 'developer-starter-pro' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove treatment types', 'developer-starter-pro' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'developer-starter-pro' ),
			'popular_items'              => esc_html__( 'Popular Treatment Types', 'developer-starter-pro' ),
			'search_items'               => esc_html__( 'Search Treatment Types', 'developer-starter-pro' ),
			'not_found'                  => esc_html__( 'Not Found', 'developer-starter-pro' ),
			'no_terms'                   => esc_html__( 'No treatment types', 'developer-starter-pro' ),
			'items_list'                 => esc_html__( 'Treatment Types list', 'developer-starter-pro' ),
			'items_list_navigation'      => esc_html__( 'Treatment Types list navigation', 'developer-starter-pro' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'         => 'treatment-type',
				'with_front'   => false,
				'hierarchical' => true,
			),
		);

		register_taxonomy( 'treatment_type', array( 'services' ), $args );
	}
}
