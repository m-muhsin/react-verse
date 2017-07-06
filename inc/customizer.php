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
		'title'       => __( 'Heading Color Gradient', ' ' ),
		'priority'    => 30,
		'description' => 'Pick two colors to generate gradient colour for headings',
	) );
	$wp_customize->add_setting( 'gradient_one', array('default'=>'#0473d0') );
	$wp_customize->add_setting( 'gradient_two', array('default'=>'#f50b8b') );
	$wp_customize->add_setting( 'direction', array('default'=>'right') );

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
	$wp_customize->add_control( 'direction', array(
    'label'   => 'Select Direction of Gradient:',
    'section' => 'gradient_section',
    'type'    => 'select',
    'choices'    => array(
        'Left' => 'Left',
        'Right' => 'Right',
        'Top' => 'Top',
        'Bottom' => 'Bottom',
        ),
	) );
	$wp_customize->get_setting( 'gradient_one'  )->transport = 'refresh';
    $wp_customize->get_setting( 'gradient_two'  )->transport = 'refresh';
    $wp_customize->get_setting( 'direction'  )->transport = 'refresh';
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
