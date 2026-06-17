<?php
/**
 * Theme Setup Class
 *
 * Handles theme supports, menus, sidebars, image sizes, and content width.
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Developer_Starter_Pro_Setup {

	/**
	 * Constructor — hook into WordPress.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
		add_action( 'after_setup_theme', array( $this, 'custom_image_sizes' ) );

		// Allow SVG uploads.
		add_filter( 'upload_mimes', array( $this, 'allow_svg_uploads' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'check_svg_filetype' ), 10, 4 );


	}

	/**
	 * Add theme supports.
	 */
	public function theme_support() {
		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable post thumbnails.
		add_theme_support( 'post-thumbnails' );

		// Custom logo support.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 80,
				'width'       => 250,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// HTML5 markup support.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// Post formats.
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'gallery',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Custom header support.
		add_theme_support(
			'custom-header',
			array(
				'default-image' => '',
				'width'         => 1920,
				'height'        => 600,
				'flex-height'   => true,
				'flex-width'    => true,
			)
		);

		// Custom background support.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'ffffff',
			)
		);



		// Automatic feed links.
		add_theme_support( 'automatic-feed-links' );

		// Responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Block editor styles.
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		// Editor styles.
		add_editor_style( 'assets/css/editor-style.css' );

		// Load textdomain for translations.
		load_theme_textdomain( 'developer-starter-pro', developer_starter_pro_DIR . '/languages' );
	}

	/**
	 * Register navigation menus.
	 */
	public function register_menus() {
		register_nav_menus(
			array(
				'primary'   => esc_html__( 'Primary Menu', 'developer-starter-pro' ),
				'footer'    => esc_html__( 'Footer Menu', 'developer-starter-pro' ),
				'mobile'    => esc_html__( 'Mobile Menu', 'developer-starter-pro' ),
				'top_bar'   => esc_html__( 'Top Bar Menu', 'developer-starter-pro' ),
			)
		);
	}

	/**
	 * Register widget areas / sidebars.
	 */
	public function register_sidebars() {
		// Main Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Main Sidebar', 'developer-starter-pro' ),
				'id'            => 'sidebar-main',
				'description'   => esc_html__( 'Widgets for the main sidebar area.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget developer-starter-pro-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		// Footer Widget Area 1.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Column 1', 'developer-starter-pro' ),
				'id'            => 'footer-1',
				'description'   => esc_html__( 'First footer widget area.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		// Footer Widget Area 2.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Column 2', 'developer-starter-pro' ),
				'id'            => 'footer-2',
				'description'   => esc_html__( 'Second footer widget area.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		// Footer Widget Area 3.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Column 3', 'developer-starter-pro' ),
				'id'            => 'footer-3',
				'description'   => esc_html__( 'Third footer widget area.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		// Footer Widget Area 4.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Column 4', 'developer-starter-pro' ),
				'id'            => 'footer-4',
				'description'   => esc_html__( 'Fourth footer widget area.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);

		// Blog Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'developer-starter-pro' ),
				'id'            => 'sidebar-blog',
				'description'   => esc_html__( 'Widgets for the blog sidebar.', 'developer-starter-pro' ),
				'before_widget' => '<div id="%1$s" class="widget developer-starter-pro-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/**
	 * Set the content width based on the theme's design.
	 */
	public function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'developer_starter_pro_content_width', 1200 );
	}

	/**
	 * Register custom image sizes.
	 */
	public function custom_image_sizes() {
		// Doctor profile photo.
		add_image_size( 'developer-starter-pro-doctor-thumb', 400, 500, true );
		add_image_size( 'developer-starter-pro-doctor-large', 800, 1000, true );

		// Service card.
		add_image_size( 'developer-starter-pro-service-thumb', 400, 300, true );

		// Testimonial photo.
		add_image_size( 'developer-starter-pro-testimonial', 100, 100, true );

		// Hero slider.
		add_image_size( 'developer-starter-pro-hero', 1920, 800, true );

		// Gallery.
		add_image_size( 'developer-starter-pro-gallery', 600, 400, true );
		add_image_size( 'developer-starter-pro-gallery-large', 1200, 800, true );

		// Blog.
		add_image_size( 'developer-starter-pro-blog-thumb', 600, 400, true );
		add_image_size( 'developer-starter-pro-blog-large', 1200, 600, true );
	}



	/**
	 * Allow SVG file uploads in WordPress media library.
	 *
	 * @param array $mimes Allowed mime types.
	 * @return array Modified allowed mime types.
	 */
	public function allow_svg_uploads( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Override file extension validation check for SVG files.
	 *
	 * @param array  $data     File data.
	 * @param string $file     Full path to the file.
	 * @param string $filename The name of the file.
	 * @param array  $mimes    Allowed mime types.
	 * @return array Modified file data.
	 */
	public function check_svg_filetype( $data, $file, $filename, $mimes ) {
		$filetype = wp_check_filetype( $filename, $mimes );
		$ext      = $filetype['ext'];

		if ( 'svg' === $ext ) {
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}

		return $data;
	}
}
