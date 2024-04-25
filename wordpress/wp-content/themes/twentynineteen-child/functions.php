<?php

add_image_size( "medium_square_crop", 400, 400, true );

add_action( 'wp_enqueue_scripts', function() {
  
    wp_enqueue_style( 'parent-style', "" . get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'main-styles', "" . get_stylesheet_directory_uri() . '/assets/css/main-styles.css?mod=04242024');
    wp_enqueue_style( 'print-styles', "" . get_stylesheet_directory_uri() . '/assets/css/print-styles.css?mod=04242024', array(), '', 'print' );
    
    wp_register_script( 'javascript-functions', get_stylesheet_directory_uri() . '/assets/javascript/javascript-functions.js' );
    wp_enqueue_script( 'javascript-functions', get_stylesheet_directory_uri() . '/assets/javascript/javascript-functions.js' );  
    
});
