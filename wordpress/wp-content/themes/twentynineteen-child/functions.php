<?php

/*Prevent non-logged in users from accessing the site's user and post data using the WordPress REST API.*/
//add_filter( 'rest_authentication_errors', function( $result ) {
//   if ( !empty( $result ) ) {
//       return $result;
//   } 
//   if( !is_user_logged_in() ) {
//       return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );    
//   }
//   return $result;
//});


add_image_size( "medium_square_crop", 400, 400, true );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'parent-style', "" . get_template_directory_uri() . '/style.css?mod=05292022' );
    wp_enqueue_style( 'print-styles', "" . get_stylesheet_directory_uri() . '/assets/css/print-styles.css?mod=05312022', array(), '', 'print' );
});
