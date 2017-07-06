<?php
/**
 * ReactVerse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ReactVerse
 */

/**
 * ReactVerse only works if the REST API is available
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/compat-warnings.php';
	return;
}

if ( ! defined( 'REACTVERSE_VERSION' ) ) {
	define( 'REACTVERSE_VERSION', '1.0.3' );
}

if ( ! defined( 'REACTVERSE_APP' ) ) {
	define( 'REACTVERSE_APP', 'reactverse' );
}

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
	 * to change 'reactverse' to the name of your theme in all the template files.
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
}
add_action( 'after_setup_theme', 'reactverse_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function reactverse_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'reactverse' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'reactverse_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function reactverse_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'reactverse_content_width', 635 );
}
add_action( 'after_setup_theme', 'reactverse_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function reactverse_scripts() {
	if ( is_customize_preview() ) {
		wp_enqueue_script( 'reactverse-customize-preview', get_template_directory_uri() . '/build/customize-preview.js', array( 'jquery', 'customize-preview', 'customize-preview-nav-menus', REACTVERSE_APP ), REACTVERSE_VERSION, true );
	}

	wp_enqueue_style( 'reactverse-style', get_template_directory_uri() . '/build/style.css', array(), REACTVERSE_VERSION );
	wp_enqueue_style( 'bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css' );
	wp_enqueue_script( REACTVERSE_APP, get_template_directory_uri() . '/build/app.js', array( 'jquery', 'wp-a11y' ), REACTVERSE_VERSION, true );
	if ( is_child_theme() ) {
		wp_enqueue_style( 'reactverse-child-style', get_stylesheet_uri() );
	}

	if ( class_exists( 'Jetpack_Tiled_Gallery' ) ) {
		Jetpack_Tiled_Gallery::default_scripts_and_styles();
	}

	$url = trailingslashit( home_url() );
	$path = trailingslashit( wp_parse_url( $url )['path'] );

	$front_page_slug = false;
	$blog_page_slug = false;
	if ( 'posts' !== get_option( 'show_on_front' ) ) {
		$front_page_id = get_option( 'page_on_front' );
		$front_page = get_post( $front_page_id );
		if ( $front_page->post_name ) {
			$front_page_slug = $front_page->post_name;
		}

		$blog_page_id = get_option( 'page_for_posts' );
		$blog_page = get_post( $blog_page_id );
		if ( $blog_page->post_name ) {
			$blog_page_slug = $blog_page->post_name;
		}
	}

	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );

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
			'gradientData' => array(
				'one' => get_theme_mod( 'gradient_one' ),
				'two' => get_theme_mod( 'gradient_two' ),
				'dir' => get_theme_mod( 'direction' ),
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

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$opensans = _x( 'on', 'Open Sans font: on or off', 'reactverse' );

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Raleway, translate this to 'off'. Do not translate into
	 * your own language.
	 */
	$raleway = _x( 'on', 'Raleway font: on or off', 'reactverse' );

	if ( 'off' !== $opensans || 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $opensans ) {
			$font_families[] = rawurlencode( 'Open Sans:400,400italic,700,700italic,900italic' );
		}

		if ( 'off' !== $raleway ) {
			$font_families[] = rawurlencode( 'Raleway:700' );
		}

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
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
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'reactverse-fonts', esc_url_raw( $fonts_url ), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'reactverse_fonts' );

/**
 * Add "pagename" to the accepted parameters in the query for page requests via API.
 *
 * @param array           $args    Key value array of query var to query value.
 * @param WP_REST_Request $request The request used.
 */
function reactverse_add_path_to_page_query( $args, $request ) {
	if ( isset( $request['pagename'] ) ) {
		$args['pagename'] = $request['pagename'];
	}
	return $args;
}
add_filter( 'rest_page_query', 'reactverse_add_path_to_page_query', 10, 2 );

// Allow anon comments via API when using this theme.
add_filter( 'rest_allow_anonymous_comments', '__return_true' );




// Include extra functionality.
require get_template_directory() . '/inc/load-menu.php';
require get_template_directory() . '/inc/load-data.php';
require get_template_directory() . '/inc/permalinks.php';
require get_template_directory() . '/inc/customizer.php';
