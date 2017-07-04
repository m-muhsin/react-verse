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
 * Register gradient customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 */
function reactverse_gradient_title ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'gradient_section' , array(
		'title'       => __( 'Color Gradient', ' ' ),
		'priority'    => 30,
		'description' => 'Pick two colors to generate gradient',
	) );
	$wp_customize->add_setting( 'gradient_one' );
	$wp_customize->add_setting( 'gradient_two' );

	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'gradient_one',
			array (
				'label'      => __( 'First Color', 'reactverse' ),
				'section'    => 'gradient_section',
				'settings'   => 'gradient_one',
			)
		)
	);
	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'gradient_two',
			array (
				'label'      => __( 'Second Color', 'reactverse' ),
				'section'    => 'gradient_section',
				'settings'   => 'gradient_two',
			)
		)
	);
	$wp_customize->get_setting( 'gradient_one'  )->transport = 'postMessage';
    $wp_customize->get_setting( 'gradient_two'  )->transport = 'postMessage';
}
add_action( 'customize_register', 'reactverse_gradient_title' );


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
