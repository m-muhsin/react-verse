<?php

function reactverse_get_theme_mod( WP_REST_Request $request ) {
	$param = $request['value'];
	$imageUrl = get_theme_mod($param);
	$mediaData =  attachment_url_to_postid($imageUrl);
	$altText = get_post_meta( $mediaData, '_wp_attachment_image_alt', true );
	
	$data = array ( 
		'url' => $imageUrl,
		'alt' => $altText
		);

	if ( $data['url'] == '' ) {
		return new WP_Error( 'no_customizer_option', 'Invalid customizer key', array( 'status' => 404 ) );
	}

	return new WP_REST_Response( $data , 200);

}

add_action( 'rest_api_init', function () {
  register_rest_route( 'myplugin/v1', '/theme_mod/(?P<value>[a-zA-Z0-9-_]+)', array(
    'methods' => 'GET',
    'callback' => 'reactverse_get_theme_mod',
  ) );
} );