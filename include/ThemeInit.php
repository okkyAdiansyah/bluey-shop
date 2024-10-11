<?php
/**
 * Initialization for theme functionalities
 * 
 * @package Bluey Shop
 */

/**
 * Accessed directly
 */
if( ! defined( 'ABSPATH' ) ){
    exit;
}

class ThemeInit{

    /**
     * @var array $template_pages list of template page
     */
    public $template_pages = array('about-us', 'contact', 'faq');

	public function __construct(){
		add_action( 'after_setup_theme', array($this, 'setup') );
		add_action( 'after_switch_theme', array($this, 'bs_init_template_page')  );
		add_action( 'wp_enqueue_scripts', array($this, 'bs_register_styles'), 10 );
		add_action( 'wp_enqueue_scripts', array($this, 'bs_register_scripts'), 10 );
	}

    /**
     * Setup all Wordpress theme support upon init hook
     */
    public function setup(){
	    /**
	     * Add default posts and comments RSS feed links to head.
	     */
	    add_theme_support( 'automatic-feed-links' );
	    /*
	     * Enable support for Post Thumbnails on posts and pages.
	     *
	     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
	     */
	    add_theme_support( 'post-thumbnails' );
        /**
         * Enable menu creation support
         */
        add_theme_support( 'menus' );
	    /**
	     * Enable support for site logo.
	     */
	    add_theme_support(
	    	'custom-logo',
	    	apply_filters(
	    		'bluey_custom_logo_args',
	    		array(
	    			'height'      => 110,
	    			'width'       => 470,
	    			'flex-width'  => true,
	    			'flex-height' => true,
	    		)
	    	)
        );
	    /**
	     * Register menu locations.
	     */
	    register_nav_menus(
	    	apply_filters(
	    		'bluey_register_nav_menus',
	    		array(
	    			'primary'   => __( 'Primary Menu', THEME_TEXT_DOMAIN ),
	    			'secondary' => __( 'Secondary Menu', THEME_TEXT_DOMAIN ),
	    			'responsive'  => __( 'Responsive Menu', THEME_TEXT_DOMAIN ),
	    		)
	    	)
        );
	    /*
	     * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
	     * to output valid HTML5.
	     */
	    add_theme_support(
	    	'html5',
	    	apply_filters(
	    		'bluey_html5_args',
	    		array(
	    			'search-form',
	    			'comment-form',
	    			'comment-list',
	    			'gallery',
	    			'caption',
	    			'widgets',
	    			'style',
	    			'script',
	    		)
	    	)
        );
	    /**
	     * Setup the WordPress core custom background feature.
	     */
	    add_theme_support(
	    	'custom-background',
	    	apply_filters(
	    		'bluey_custom_background_args',
	    		array(
	    			'default-color' => apply_filters( 'bluey_default_background_color', 'ffffff' ),
	    			'default-image' => '',
	    		)
	    	)
        );
	    /**
	     * Setup the WordPress core custom header feature.
	     */
	    add_theme_support(
	    	'custom-header',
	    	apply_filters(
	    		'bluey_custom_header_args',
	    		array(
	    			'default-image' => '',
	    			'header-text'   => false,
	    			'width'         => 1950,
	    			'height'        => 500,
	    			'flex-width'    => true,
	    			'flex-height'   => true,
	    		)
	    	)
        );
	    /**
	     * Declare support for title theme feature.
	     */
	    add_theme_support( 'title-tag' );
	    /**
	     * Declare support for selective refreshing of widgets.
	     */
	    add_theme_support( 'customize-selective-refresh-widgets' );
	    /**
	     * Add support for full and wide align images.
	     */
	    add_theme_support( 'align-wide' );
	    /**
	     * Add support for editor styles.
	     */
	    add_theme_support( 'editor-styles' );
	    /**
	     * Add support for editor font sizes.
	     */
	    add_theme_support(
	    	'editor-font-sizes',
	    	array(
	    		array(
	    			'name' => __( 'Small', THEME_TEXT_DOMAIN ),
	    			'size' => 14,
	    			'slug' => 'small',
	    		),
	    		array(
	    			'name' => __( 'Normal', THEME_TEXT_DOMAIN ),
	    			'size' => 16,
	    			'slug' => 'normal',
	    		),
	    		array(
	    			'name' => __( 'Medium', THEME_TEXT_DOMAIN ),
	    			'size' => 23,
	    			'slug' => 'medium',
	    		),
	    		array(
	    			'name' => __( 'Large', THEME_TEXT_DOMAIN ),
	    			'size' => 26,
	    			'slug' => 'large',
	    		),
	    		array(
	    			'name' => __( 'Huge', THEME_TEXT_DOMAIN ),
	    			'size' => 37,
	    			'slug' => 'huge',
	    		),
	    	)
        );
	    /**
	     * Add support for responsive embedded content.
	     */
	    add_theme_support( 'responsive-embeds' );
        /**
         * Woocommerce theme support 
         */
        add_theme_support( 'woocommerce' );
    }

    /**
     * Register main style
     * 
     * @return void
     */
    public function bs_register_styles(){
        wp_enqueue_style( 'theme-style', get_template_directory_uri(  ) . '/assets/styles/theme.css', array(), THEME_VERSION);
        add_editor_style( get_template_directory_uri(  ) . '/editor-style.css' );
    }

    /**
     * Register main js script
     * 
     * @return void
     */
    public function bs_register_scripts(){
        wp_enqueue_script( 'bs-ajax-add-to-cart', get_template_directory_uri(  ) . 'assets/scripts/bs-ajax-add-to-cart.js', array('jquery'), THEME_VERSION, false);
        wp_enqueue_script( 'bs-main-script', get_template_directory_uri(  ) . 'assets/scripts/bs-main-script.js', array('jquery'), THEME_VERSION, false);
        wp_enqueue_script( 'bs-slider', get_template_directory_uri(  ) . 'assets/scripts/bs-slider.js', array('jquery'), THEME_VERSION, false);
    }

    /**
     * Register template page
	 * 
	 * @param string $template_page template page slug that will be registered during theme activation
	 * 
	 * @return void
     */
	public function bs_register_template_page($template_page){
		// Find if page slug is more than 2 word
		if( str_contains( '-', $template_page ) ){
			$page_title = str_replace( '-', ' ', ucwords($template_page));
		} else {
			$page_title = ucfirst($template_page);
		}

		/**
		 * Check if page exist, abort if true
		 */
		$page_exists = get_page_by_path( $template_page );

		$page_args = array(
			'post_type' => 'page',
			'post_title' => __($page_title, THEME_TEXT_DOMAIN),
			'post_content' => '',
			'post_status' => 'publish',
			'post_slug' => $template_page
		);

		if( ! isset( $page_exists->ID ) ){
			wp_insert_post( $page_args );
		} else {
			return;
		}
	}

	/**
	 * Initiate template page list
	 */
	public function bs_init_template_page(){
		foreach ($this->template_pages as $page) {
			$this->bs_register_template_page($page);
		}
	}
}

return new ThemeInit();