<?php
/**
 * ReactVerse Theme Customizer.
 *
 * @package ReactVerse
 */

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 */
function reactverse_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	add_filter( 'wp_get_nav_menu_items', '_reactverse_filter_wp_api_nav_menu_items_workaround', 20  );
}
add_action( 'customize_register', 'reactverse_customize_register' );

/**
 * Workaround issue in WP API Menus plugin to force nav menu item classes to be arrays instead of strings.
 *
 * @see \WP_REST_Menus::get_menu_location()
 *
 * @param array $items Nav menu items.
 */
function _reactverse_filter_wp_api_nav_menu_items_workaround( $items ) {
	foreach ( $items as &$item ) {
		if ( is_string( $item->classes ) ) {
			$item->classes = explode( ' ', $item->classes );
		}
	}
	return $items;
}
