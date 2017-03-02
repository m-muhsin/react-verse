<?php
/**
 * ReactVerse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ReactVerse
 */

/**
 * Check to ensure latest version
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/compat-warnings.php';
	return;
}

if ( ! defined( 'REACTVERSE_VERSION' ) ) {
	define( 'REACTVERSE_VERSION', time() );
}

if ( ! defined( 'REACTVERSE_APP' ) ) {
	define( 'REACTVERSE_APP', 'reactverse-app' );
}

if ( ! function_exists( 'reactverse_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *		
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function reactverse_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ReactVerse, use a find and replace
	 * to change 'ReactVerse' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'reactverse', get_template_directory() . '/languages' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'reactverse' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_post_type_support( 'post', 'comments' );
	add_post_type_support( 'page', 'comments' );
}
endif; // reactverse_setup
add_action( 'after_setup_theme', 'reactverse_setup' );

/**
 * Enqueue scripts and styles.
 */
function reactverse_scripts() {
	
	wp_enqueue_style( 'reactverse-style', get_template_directory_uri() . '/build/style.css', array(), REACTVERSE_VERSION );
	wp_enqueue_script( REACTVERSE_APP, get_template_directory_uri() . '/build/app.js', array( 'jquery' ), REACTVERSE_VERSION, true );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'reactverse-child-style', get_stylesheet_uri() );
	}

	$url = trailingslashit( home_url() );
	$path = trailingslashit( parse_url( $url, PHP_URL_PATH ) );

	$reactverse_settings = sprintf(
		'var SiteSettings = %s; var ReactVerseSettings = %s;',
		wp_json_encode( array(
			'endpoint' => esc_url_raw( $url ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
		) ),
		wp_json_encode( array(
			'user' => get_current_user_id(),
			'userDisplay' => $user ? $user->display_name : '',
			'frontPage' => array(
				'page' => $front_page_slug,
				'blog' => $blog_page_slug,
			),
			'URL' => array(
				'base' => esc_url_raw( $url ),
				'path' => $path,
			),
			'meta' => array(
				'title' => get_bloginfo( 'name', 'display' ),
				'description' => get_bloginfo( 'description', 'display' ),
			),
		) )
	);
	wp_add_inline_script( REACTVERSE_APP, $reactverse_settings, 'before' );
}
add_action( 'wp_enqueue_scripts', 'reactverse_scripts' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Serif Pro and Source Code Pro by default is
 * localized. For languages that use characters not supported by
 * either font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function reactverse_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate into
	 * your own language.
	 */
	$codepro = _x( 'on', 'Open Sans font: on or off', 'reactverse' );

	if ( 'off' !== $serifpro || 'off' !== $codepro ) {
		$font_families = array();

		if ( 'off' !== $codepro )
			$font_families[] = urlencode( 'Open Sans:400,500,600,700' );

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'reactverse-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @return void
 */
function reactverse_fonts() {
	$fonts_url = reactverse_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'reactverse-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'reactverse_fonts' );
