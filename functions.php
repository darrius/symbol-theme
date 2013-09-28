<?php
/**
 * Symbol functions and definitions
 *
 * @package Symbol
 * @since Symbol 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Symbol 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'symbol_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Symbol 1.0
 */
function symbol_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Including menu images
	 */

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'symbol' ),
	) );
}
endif; // symbol_setup
add_action( 'after_setup_theme', 'symbol_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Symbol 1.0
 */
function symbol_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'symbol' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'symbol_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function symbol_scripts() {

	wp_enqueue_style( 'normalize', '//normalize-css.googlecode.com/svn/trunk/normalize.css');
	wp_enqueue_style( 'prettify',  '//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css');
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'snap-js', get_template_directory_uri() . '/js/snap.min.js', array('jquery'), '20130115', true );
	wp_enqueue_script( 'prettify', '//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js', array( ), '20120206', true );
	wp_enqueue_script( 'site-js', get_template_directory_uri() . '/js/site.js', array( 'jquery', 'prettify', 'snap-js'), '20120206', true );



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'symbol_scripts' );


add_action('admin_head', 'load_theme_scripts');



require( get_template_directory() . '/inc/plugins/nav-menu-images/nav-menu-images.php' );

if (get_option('licence_symbol')) {

	// Re-define the options-framework URL
	define( 'OPTIONS_FRAMEWORK_URL', get_template_directory_uri() . '/inc/options-framework/' );

	// Load the Options Framework Plugin
	if ( !function_exists( 'optionsframework_init' ) ) {
	    define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory() . '/inc/options-framework/' );
	    require_once OPTIONS_FRAMEWORK_DIRECTORY . 'options-framework.php';
	}

	require get_template_directory() . '/inc/Theme-Updater/updater.php';

}else{
	require_once 'inc/licence.php';
}

