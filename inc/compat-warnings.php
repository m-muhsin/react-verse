<?php
/**
 * ReactVerse compatbility warnings
 *
 * Prevents ReactVerse from running on WordPress versions without the REST API,
 * since this theme requires API functionality. If this file is loaded,
 * we know we have an incompatible WordPress.
 *
 * @package ReactVerse
 */

/**
 * Prevent switching to ReactVerse on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function reactverse_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'reactverse_upgrade_notice' );
}
add_action( 'after_switch_theme', 'reactverse_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * ReactVerse on WordPress versions prior to 4.7.
 */
function reactverse_upgrade_notice() {
	$message = __( 'ReactVerse requires WordPress 4.7 or higher. Please update your site and try again.', 'ReactVerse' );
	printf( '<div class="error"><p>%s</p></div>', $message ); /* WPCS: xss ok. */
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 */
function reactverse_customize() {
	wp_die( __( 'ReactVerse requires WordPress 4.7 or higher. Please update your site and try again.', 'reactverse' ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'reactverse_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 */
function reactverse_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( __( 'ReactVerse requires WordPress 4.7 or higher. Please update your site and try again.', 'reactverse' ) );
	}
}
add_action( 'template_redirect', 'reactverse_preview' );
