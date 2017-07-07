<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ReactVerse
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<style>
	.purple-gradient, .purple-gradient:visited, .purple-gradient:hover,
	.purple-gradient:active, .purple-gradient:focus, .site-title {
		background-image: linear-gradient(to <?php echo get_theme_mod( 'heading_direction', 'right' ) ?>, <?php echo get_theme_mod( 'heading_gradient_one', '#0473d0' ) ?>, <?php echo get_theme_mod( 'heading_gradient_two', '#f50b8b' )?>);
	}
	body {
		background-image: linear-gradient(to <?php echo get_theme_mod( 'body_direction', 'bottom' ) ?>, <?php echo get_theme_mod( 'body_gradient_one', '#f49acc' ) ?>, <?php echo get_theme_mod( 'body_gradient_two', '#599bd1' )?>);
	}
</style>
<style>
	/* IE workaround */
	@media screen\0 {
		.purple-gradient, .purple-gradient:visited, .purple-gradient:hover,
		.purple-gradient:active, .purple-gradient:focus, .site-title {
			color: white;
			padding: 0 20px;
	}
}
</style>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'reactverse' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation" aria-live="assertive">
			<div class="menu-toggle">
				<button aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'reactverse' ); ?></button>
			</div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'fallback_cb' => '__return_false' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
