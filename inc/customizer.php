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
	$wp_customize->add_section( 'heading_gradient_section' , array(
		'title'       => __( 'Heading Color Gradient', ' ' ),
		'priority'    => 30,
		'description' => 'Pick two colors to generate gradient colour for headings',
	) );
	$wp_customize->add_setting( 'heading_gradient_one', array('default'=>'#0473d0') );
	$wp_customize->add_setting( 'heading_gradient_two', array('default'=>'#f50b8b') );
	$wp_customize->add_setting( 'heading_direction', array('default'=>'right') );
	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'heading_gradient_one',
			array (
				'label'      => __( 'First Color', 'reactverse' ),
				'section'    => 'heading_gradient_section',
				'settings'   => 'heading_gradient_one',
			)
		)
	);
	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'heading_gradient_two',
			array (
				'label'      => __( 'Second Color', 'reactverse' ),
				'section'    => 'heading_gradient_section',
				'settings'   => 'heading_gradient_two',
			)
		)
	);
	$wp_customize->add_control( 'heading_direction', array(
    'label'   => 'Select Direction of Gradient:',
    'section' => 'heading_gradient_section',
    'type'    => 'select',
    'choices'    => array(
        'Left' => 'Left',
        'Right' => 'Right',
        'Top' => 'Top',
        'Bottom' => 'Bottom',
        ),
	) );
	$wp_customize->get_setting( 'heading_gradient_one'  )->transport = 'refresh';
    $wp_customize->get_setting( 'heading_gradient_two'  )->transport = 'refresh';
    $wp_customize->get_setting( 'heading_direction'  )->transport = 'refresh';
}
add_action( 'customize_register', 'reactverse_gradient_title' );
function reactverse_gradient_body ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'body_gradient_section' , array(
		'title'       => __( 'Body Color Gradient', ' ' ),
		'priority'    => 30,
		'description' => 'Pick two colors to generate gradient colour for the body',
	) );
	$wp_customize->add_setting( 'body_gradient_one', array('default'=>'#f49acc') );
	$wp_customize->add_setting( 'body_gradient_two', array('default'=>'#599bd1') );
	$wp_customize->add_setting( 'body_direction', array('default'=>'bottom') );
	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'body_gradient_one',
			array (
				'label'      => __( 'First Color', 'reactverse' ),
				'section'    => 'body_gradient_section',
				'settings'   => 'body_gradient_one',
			)
		)
	);
	$wp_customize->add_control (
		new WP_Customize_Color_Control (
			$wp_customize,
			'body_gradient_two',
			array (
				'label'      => __( 'Second Color', 'reactverse' ),
				'section'    => 'body_gradient_section',
				'settings'   => 'body_gradient_two',
			)
		)
	);
	$wp_customize->add_control( 'body_direction', array(
    'label'   => 'Select Direction of Gradient:',
    'section' => 'body_gradient_section',
    'type'    => 'select',
    'choices'    => array(
        'Left' => 'Left',
        'Right' => 'Right',
        'Top' => 'Top',
        'Bottom' => 'Bottom',
        ),
	) );
	$wp_customize->get_setting( 'body_gradient_one'  )->transport = 'refresh';
    $wp_customize->get_setting( 'body_gradient_two'  )->transport = 'refresh';
    $wp_customize->get_setting( 'body_direction'  )->transport = 'refresh';
}
add_action( 'customize_register', 'reactverse_gradient_body' );

/*
* Adding placeholder media uploader
*/
function reactverse_post_image_placeholder ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'post_image_placeholder_section' , array(
		'title'       => __( 'Post Image Placeholder', ' ' ),
		'priority'    => 30,
		'description' => 'Set global post placeholder image to use if no featured image provided.',
	) );

	$wp_customize->add_setting( 'placeholder_image_url', array() );

	$wp_customize->add_control (
		new WP_Customize_Image_Control(
           $wp_customize,
           'image_url',
           array(
               'label'      => __( 'Upload a placeholder image', 'reactverse' ),
               'section'    => 'post_image_placeholder_section',
               'settings'	=> 'placeholder_image_url'
           )
       )
	);


	$wp_customize->get_setting( 'placeholder_image_url'  )->transport = 'postMessage';
}
add_action( 'customize_register', 'reactverse_post_image_placeholder' );

/* For infinite scrolling */
function reactverse_posts_infinite_scroll ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'posts_infinite_scroll_section' , array(
		'title'       => __( 'Infinite Scrolling / Pagination'),
		'priority'    => 30,
		'description' => 'Posts display mode.',
	) );
	$wp_customize->add_setting( 'infinite_scroll', array(
        'default'    => true
    ) );
	$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'infinite_scroll',
			array(
				'label'     => __('Select how to display your posts', 'reactverse'),
				'section'   => 'posts_infinite_scroll_section',
				'type'      => 'radio',
				'choices' => array(
					true => __( 'Infinite scrolling' ),
					false => __( 'Pagination' )
				),
			)
		)
	);
	$wp_customize->get_setting( 'infinite_scroll'  )->transport = 'postMessage';
}
add_action( 'customize_register', 'reactverse_posts_infinite_scroll' );

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
