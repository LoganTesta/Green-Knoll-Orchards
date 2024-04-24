<?php
/**
 * Plugin Name: General Testimonials
 * Plugin URI: https://www.tualatintopbakery.com/general-testimonials
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: Add customer testimonials to your site, with layout and styling customizations.
 * Author URI: https://www.tualatintopbakery.com
 */

defined( 'ABSPATH' ) or exit( "File protected." );


add_action( 'admin_enqueue_scripts', function(){ 
    wp_enqueue_style( 'general-testimonials-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-admin-styles.css' ); 
} );

add_action( 'wp_enqueue_scripts', function(){ 
  wp_enqueue_style( 'general-testimonials-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-styles.php' ); 
} );


function gt_create_testimonial_post_type() {
    register_post_type( 'general-testimonials',
            array(
                'labels' => array(
                    'name' => __( 'General Testimonials' ),
                    'singular_name' => __( 'General Testimonial' )
                ),
                'public' => true,
                'show_in_menu' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'custom_fields' ),
                'hierarchical' => false
            )
    );
}
add_action( 'init', 'gt_create_testimonial_post_type' );


/*Set up the settings page*/
function gt_admin_menu(){
    add_submenu_page( 'edit.php?post_type=general-testimonials', 'Settings', 'Settings', 'manage_options', 'general-testimonials', 'gt_generate_settings_page' );
}
add_action( 'admin_menu', 'gt_admin_menu' );


/*Set up the settings page inputs*/
function gt_register_settings() {
    add_option( 'general-testimonials-leading-text', "Customer Testimonials" );
    add_option( 'general-testimonials-leading-text-position', "center" );
    add_option( 'general-testimonials-image-width-height', "120" );
    add_option( 'general-testimonials-border-radius', "15" );
    add_option( 'general-testimonials-float-image-direction', "left" );
    add_option( 'general-testimonials-testimonials-per-row', "2" );
    add_option( 'general-testimonials-number-to-display', "" );
    add_option( 'general-testimonials-rating-scale', "0-5" );
    add_option( 'general-testimonials-date-layout', "1" );

    register_setting( 'general-testimonials-settings-group', 'general-testimonials-leading-text', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-leading-text-position', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-image-width-height', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-border-radius', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-float-image-direction', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-testimonials-per-row', 'gt_validatetextfield' );  
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-number-to-display', 'gt_validatetextfield' );  
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-rating-scale', 'gt_validatetextfield' );  
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-date-layout', 'gt_validatetextfield' );
}
add_action( 'admin_init', 'gt_register_settings' );


function gt_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}


function gt_generate_settings_page() {
    global $post;
    
    $ratingScale = get_option( 'general-testimonials-rating-scale' );
    $maxRating = substr( $ratingScale, 2 );
        
    $args = array(
        "post_type" => "general-testimonials"
    );
    $posts = get_posts( $args );
    $numberOfPosts = count( $posts );
   
    foreach ( $posts as $aPost ) {
        $testimonialrating =  gt_get_testimonialrating( $aPost );
        if ( $testimonialrating > $maxRating ) {
            $testimonialrating = "";
        }
        update_post_meta( $aPost->ID, 'testimonialrating', $testimonialrating );
    }
    
    
    ?>
    <h1 class="general-testimonials__plugin-title">General Testimonials Settings</h1>
    <form class="testimonials-settings-form" method="post" action="options.php">
        <?php settings_fields( 'general-testimonials-settings-group' ); ?>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-leading-text">Testimonials Leading Text</label>
                <input id="generalTestimonialsLeadingText" class="admin-input-container__input general-testimonials-leading-text" name="general-testimonials-leading-text" type="text" value="<?php echo get_option( 'general-testimonials-leading-text' ); ?>" />
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Leading Text Position</span>   
                <label class="" for="generalTestimonialsLeadingTextPosition0">left</label>
                <input id="generalTestimonialsLeadingTextPosition0" class="general-testimonials-leading-text-position" name="general-testimonials-leading-text-position" type="radio" value="left" <?php if ( get_option( 'general-testimonials-leading-text-position' ) === "left" ) { echo 'checked="checked"'; } ?> />
                <label class="" for="generalTestimonialsLeadingTextPosition1">center</label>
                <input id="generalTestimonialsLeadingTextPosition1" class="general-testimonials-leading-text-position" name="general-testimonials-leading-text-position" type="radio" value="center" <?php if ( get_option( 'general-testimonials-leading-text-position' ) === "center" ) { echo 'checked="checked"'; } ?> />
                <label class="" for="generalTestimonialsLeadingTextPosition2">right</label>
                <input id="generalTestimonialsLeadingTextPosition2" class="general-testimonials-leading-text-position" name="general-testimonials-leading-text-position" type="radio" value="right" <?php if ( get_option( 'general-testimonials-leading-text-position' ) === "right" ) { echo 'checked="checked"'; } ?> />        
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-image-width-height">Image Width, Height (Max, 60-150px)</label>
                <input id="generalTestimonialsNumberToDisplay" class="admin-input-container__input smaller general-testimonials-image-width-height" name="general-testimonials-image-width-height" type="number" value="<?php echo get_option( 'general-testimonials-image-width-height' ); ?>" min="60" max="150" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 120px</span>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-border-radius">Image Border Radius</label>
                <input id="generalTestimonialsImageWidthHeight" class="admin-input-container__input general-testimonials-border-radius" name="general-testimonials-border-radius" type="text" value="<?php echo get_option( 'general-testimonials-border-radius' ); ?>" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 15px</span>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Float Image Direction</span>         
                <input id="generalTestimonialsFloatImageDirection0" class="general-testimonials-float-image-direction" name="general-testimonials-float-image-direction" type="radio" value="left" <?php if ( get_option( 'general-testimonials-float-image-direction' ) === "left" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsFloatImageDirection0">Left</label>
                <input id="generalTestimonialsFloatImageDirection1" class="general-testimonials-float-image-direction" name="general-testimonials-float-image-direction" type="radio" value="right" <?php if ( get_option( 'general-testimonials-float-image-direction' ) === "right" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsFloatImageDirection1">Right</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Testimonials Per Row (Max)</span>         
                <input id="generalTestimonialsTestimonialsPerRow0" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="1" <?php if ( get_option( 'general-testimonials-testimonials-per-row' ) === "1" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow0">1</label>
                <input id="generalTestimonialsTestimonialsPerRow1" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="2" <?php if ( get_option( 'general-testimonials-testimonials-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow1">2</label>
                <input id="generalTestimonialsTestimonialsPerRow2" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="3" <?php if ( get_option( 'general-testimonials-testimonials-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow2">3</label>
                <input id="generalTestimonialsTestimonialsPerRow3" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="4" <?php if ( get_option( 'general-testimonials-testimonials-per-row' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow3">4</label>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-number-to-display">Testimonials to Display (Empty: display all)</label>
                <input id="generalTestimonialsNumberToDisplay" class="admin-input-container__input smaller general-testimonials-number-to-display" name="general-testimonials-number-to-display" type="number" value="<?php echo get_option( 'general-testimonials-number-to-display' ); ?>" />
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Testimonials Rating Scale. Note: reducing the max rating will set any ratings above the new max value to empty.</span>         
                <input id="generalTestimonialsRatingScale0" class="general-testimonials-rating-scale" name="general-testimonials-rating-scale" type="radio" value="0-4" <?php if ( get_option( 'general-testimonials-rating-scale' ) === "0-4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsRatingScale0">0-4</label>
                <input id="generalTestimonialsRatingScale1" class="general-testimonials-rating-scale" name="general-testimonials-rating-scale" type="radio" value="0-5" <?php if ( get_option( 'general-testimonials-rating-scale' ) === "0-5" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsRatingScale1">0-5</label>
                <input id="generalTestimonialsRatingScale2" class="general-testimonials-rating-scale" name="general-testimonials-rating-scale" type="radio" value="0-10" <?php if ( get_option( 'general-testimonials-rating-scale' ) === "0-10" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsRatingScale2">0-10</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Date Layout</span>         
                <input id="generalTestimonialsDateLayout0" class="general-testimonials-date-layout" name="general-testimonials-date-layout" type="radio" value="1" <?php if ( get_option( 'general-testimonials-date-layout' ) === "1" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsDateLayout0">May 14, 2023 (default)</label>
                <input id="generalTestimonialsDateLayout1" class="general-testimonials-date-layout" name="general-testimonials-date-layout" type="radio" value="2" <?php if ( get_option( 'general-testimonials-date-layout' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsDateLayout1">May 2023</label>
                <input id="generalTestimonialsDateLayout2" class="general-testimonials-date-layout" name="general-testimonials-date-layout" type="radio" value="3" <?php if ( get_option( 'general-testimonials-date-layout' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsDateLayout2">14 May 2023</label>
            </div>
            <?php submit_button(); ?>
        </form>
    <?php
}


function gt_add_custom_metabox_info() {
    add_meta_box( 'custom-metabox', __( 'Testimonial Information' ), 'gt_url_custom_metabox', 'general-testimonials', 'side', 'low' );
}
add_action( 'admin_init', 'gt_add_custom_metabox_info' );


//Admin area HTML and logic 
function gt_url_custom_metabox() {
    global $post;
    
    wp_nonce_field( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    $ratingScale = get_option( 'general-testimonials-rating-scale' );
    $maxRating = substr( $ratingScale, 2 );
    

    
    /*Gather the input data, sanitize it, and update the database.*/
    $testimonialprovidedname = sanitize_text_field( get_post_meta( $post->ID, 'testimonialprovidedname', true ) );
    update_post_meta( $post->ID, 'testimonialprovidedname', $testimonialprovidedname );
    $testimoniallabel = sanitize_text_field( get_post_meta( $post->ID, 'testimoniallabel', true ) );
    update_post_meta( $post->ID, 'testimoniallabel', $testimoniallabel );
    $testimoniallocation = sanitize_text_field( get_post_meta( $post->ID, 'testimoniallocation', true ) );
    update_post_meta( $post->ID, 'testimoniallocation', $testimoniallocation );
    $testimonialurl = sanitize_text_field( get_post_meta( $post->ID, 'testimonialurl', true ) );
    update_post_meta( $post->ID, 'testimonialurl', $testimonialurl );
    $testimonialdate = sanitize_text_field( get_post_meta( $post->ID, 'testimonialdate', true ) );
    update_post_meta( $post->ID, 'testimonialdate', $testimonialdate ); 
    $testimonialrating = sanitize_text_field( get_post_meta( $post->ID, 'testimonialrating', true ) );
    update_post_meta( $post->ID, 'testimonialrating', $testimonialrating ); 
    $testimonialorder = sanitize_text_field( get_post_meta( $post->ID, 'testimonialorder', true ) );
    if ( isset( $testimonialorder ) === false || $testimonialorder === "" ) {
        $testimonialorder = "n/a";
    }
    update_post_meta( $post->ID, 'testimonialorder', $testimonialorder );


    $errorsprovidedname = "";
    if ( isset( $errorsprovidedname ) ) {
        echo $errorsprovidedname;
    }
    
    $errorslabel = "";
    if ( isset( $errorslabel ) ) {
        echo $errorslabel;
    }
   
    $errorslink = "";
    if ( ! preg_match( "/http(s?):\/\//", $testimonialurl ) && $testimonialurl !== "" ) {
        $errorslink = "This URL is not valid";
        $testimonialurl = "http://";
    }
    
    if ( isset( $errorslink ) ){
        echo $errorslink;
    }
    
    $errorsorder = "";
    if ( isset( $errorsorder ) ) {
        echo $errorsorder;
    }
    
    ?>
    <p>
        <label for="testimonialprovidedname">Provided Testimonial Name:<br />
            <input id="testimonialprovidedname" name="testimonialprovidedname" size="37" value="<?php if ( isset( $testimonialprovidedname ) ) { echo $testimonialprovidedname; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimoniallabel">Testimonial Label:<br />
            <input id="testimoniallabel" name="testimoniallabel" size="37" value="<?php if ( isset( $testimoniallabel ) ) { echo $testimoniallabel; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimoniallocation">Location:<br />
            <input id="testimoniallocation" name="testimoniallocation" size="37" value="<?php if ( isset( $testimoniallocation ) ) { echo $testimoniallocation; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialurl">Related URL:<br />
            <input id="testimonialurl" size="37" name="testimonialurl" value="<?php if ( isset( $testimonialurl ) ) { echo $testimonialurl; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialdate">Date<br />
            <input id="testimonialdate" size="37" name="testimonialdate" type="date" value="<?php if ( isset( $testimonialdate ) ) { echo $testimonialdate; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialrating">Rating (<?php echo $ratingScale; ?>)<br />
            <input id="testimonialrating" size="37" name="testimonialrating" type="number" min="0" max="<?php echo $maxRating?>" value="<?php if ( isset( $testimonialrating ) ) { echo $testimonialrating; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialorder">Testimonial Order:<br />
            <input id="testimonialorder" size="37" type="number" min="1" name="testimonialorder" value="<?php if ( isset( $testimonialorder ) ) { echo $testimonialorder; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function gt_save_custom_testimonialprovidedname( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimonialprovidedname'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimonialprovidedname', $_POST['testimonialprovidedname'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_custom_testimonialprovidedname' );

function gt_get_testimonialprovidedname( $post ) {
    $testimonialname = get_post_meta( $post->ID, 'testimonialprovidedname', true );
    return $testimonialname;
}


function gt_save_custom_testimoniallabel( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimoniallabel'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimoniallabel', $_POST['testimoniallabel'] );
        }  else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_custom_testimoniallabel' );

function gt_get_testimoniallabel( $post ) {
    $testimoniallabel = get_post_meta( $post->ID, 'testimoniallabel', true );
    return $testimoniallabel;
}


function gt_save_custom_testimoniallocation( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimoniallocation'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimoniallocation', $_POST['testimoniallocation'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_custom_testimoniallocation' );

function gt_get_testimoniallocation( $post ) {
    $testimoniallocation = get_post_meta( $post->ID, 'testimoniallocation', true );
    return $testimoniallocation;
}


function gt_save_custom_url( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimonialurl'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimonialurl', $_POST['testimonialurl'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_custom_url' );

function gt_get_url( $post ) {
    $testimonialurl = get_post_meta( $post->ID, 'testimonialurl', true );
    return $testimonialurl;
}


function gt_save_testimonialdate( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimonialdate'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimonialdate', $_POST['testimonialdate'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_testimonialdate' );

function gt_get_testimonialdate( $post ) {
    $testimonialdate = get_post_meta( $post->ID, 'testimonialdate', true );
    return $testimonialdate;
}


function gt_save_testimonialrating( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimonialrating'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimonialrating', $_POST['testimonialrating'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_testimonialrating' );

function gt_get_testimonialrating( $post ) {
    $testimonialrating = get_post_meta( $post->ID, 'testimonialrating', true );
    return $testimonialrating;
}


function gt_save_custom_order( $post_id ) {
    global $post;
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    if ( isset( $_POST['testimonialorder'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'testimonialorder', $_POST['testimonialorder'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'gt_save_custom_order' );

function gt_get_order( $post ) {
    $testimonialorder = get_post_meta( $post->ID, 'testimonialorder', true );
    return $testimonialorder;
}



/*Adjust admin columns for Testimonials*/
if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === "general-testimonials" ){

    add_filter( 'admin_bar_menu', 'gt_setup_instructions' );
    function gt_setup_instructions() {
        if ( get_admin_page_title() === 'General Testimonials' ) {
            echo '<div class="general-testimonials__instructions">
                <p class="general-testimonials__instructions__intro">Add customer testimonials to your site, with layout and styling customizations.</p>
                <p><strong>Shortcode:</strong> [general_testimonials].</p>
                <p><strong>PHP code:</strong> <code>&lt?php echo do_shortcode( "[general_testimonials]" ); ?></code> 
                </div>';
        }
    }
    

    add_filter( 'manage_posts_columns', 'gt_setup_adjust_admin_columns' );
    function gt_setup_adjust_admin_columns( $columns ) {
        $columns = array(
            'cb' => $columns['cb'],
            'title' => __( 'Title' ),
            'image' => __( 'Image' ), 
            'content' => __( 'Testimonial Text' ),
            'testimonialprovidedname' => __( 'Provided Name', 'gt' ),
            'order' => __( 'Order' ),
            'date' => __( 'Date' ),
            'testimonialdate' => __( 'Testimonial Date', 'gt' ),
        );   
        return $columns;
    }


    //Add images and other data to posts admin
    add_action( 'manage_posts_custom_column', 'gt_add_data_to_admin_columns', 10, 2 );
    function gt_add_data_to_admin_columns( $column, $post_id ) {
        if ( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
        }
        if ( 'testimonialprovidedname' === $column ) {
            echo get_post_meta( $post_id, 'testimonialprovidedname', true );
        }
        if ( 'content' === $column ) {
            echo get_post_field( 'post_content', $post_id );
        }
        if ( 'order' === $column ) {
            echo get_post_meta( $post_id, 'testimonialorder', true );
        }
        if ( 'testimonialdate' === $column ) {
            echo get_post_meta( $post_id, 'testimonialdate', true );
        }
    }


    //Determine order of testimonials shown in admin*/
    add_action( 'pre_get_posts', 'gt_custom_post_order_sort' );
    function gt_custom_post_order_sort( $query ) { 
        if ( $query->is_main_query() && $_GET['post_type'] === "general-testimonials" ){
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'meta_key', 'testimonialorder' );
            $query->set( 'order', 'ASC' );
        }
    }
}


//Register the shortcode so we can show testimonials.
function gt_load_testimonials( $postQuery ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "general-testimonials"
    );

    if ( isset( $postQuery['rand'] ) && $postQuery['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'testimonialorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $postQuery['max'] ) ) {
        $args['posts_per_page'] = ( int ) $postQuery['max'];
    }
    
    $dateLayout = intval( get_option( 'general-testimonials-date-layout' ) );
    $dateLayoutFormat = "";
    if ( $dateLayout === 1 ) {
        $dateLayoutFormat = 'F j, Y';
    } else if ( $dateLayout === 2 ) {
        $dateLayoutFormat = 'F Y';
    } else if ( $dateLayout === 3 ) {
         $dateLayoutFormat = 'd M Y';
    } 
    
    //Get all testimonials.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="testimonials-container">';
    $pluginContainer .= '<h3 class="testimonials-container__heading">' . get_option( 'general-testimonials-leading-text' ) . '</h3>';
    $pluginContainer .= '<div class="testimonials-container__inner-wrapper">';
    
    $numberToDisplay = get_option( 'general-testimonials-number-to-display' );
    if ( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = ( int ) $numberToDisplay;
    $count = 0;
    foreach ( $posts as $post ) {
        if ( $count < $numberToDisplay || $numberToDisplay === -1 ){
            $url_thumb = wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
            $url_altText = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
            $link = gt_get_url( $post );
            $providedName = gt_get_testimonialprovidedname( $post );
            $label = gt_get_testimoniallabel( $post );
            $testimonialLocation = gt_get_testimoniallocation( $post );
            $testimonialDate = strtotime( gt_get_testimonialdate( $post ) );
            if ( ! empty( gt_get_testimonialdate( $post ) ) ) {
                $testimonialDate = date( $dateLayoutFormat, $testimonialDate );
            }
            $testimonialRating = gt_get_testimonialrating( $post );
            $ratingScale = get_option( 'general-testimonials-rating-scale' );
            
            if ( $ratingScale === "0-4") {
                if ( $testimonialRating === "0" ) {
                    $testimonialRating = "&#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "1" ) {
                    $testimonialRating = "&#9733; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "2" ) {
                    $testimonialRating = "&#9733; &#9733; &#9734; &#9734;";
                } else if ( $testimonialRating === "3" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9734;";
                } else if ( $testimonialRating === "4" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733;";
                } 
            } else if ( $ratingScale === "0-10") {
                if ( $testimonialRating === "0" ) {
                    $testimonialRating = "&#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "1" ) {
                    $testimonialRating = "&#9733; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "2" ) {
                    $testimonialRating = "&#9733; &#9733; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "3" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9734; &#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "4" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "5" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "6" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "7" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "8" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9734; &#9734;";
                } else if ( $testimonialRating === "9" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9734;";
                } else if ( $testimonialRating === "10" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733; &#9733;";
                } 
            } else if ( $ratingScale === "0-5" || $ratingScale === "" ) {
                if ( $testimonialRating === "0" ) {
                    $testimonialRating = "&#9734; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "1" ) {
                    $testimonialRating = "&#9733; &#9734; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "2" ) {
                    $testimonialRating = "&#9733; &#9733; &#9734; &#9734; &#9734;";
                } else if ( $testimonialRating === "3" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9734; &#9734;";
                } else if ( $testimonialRating === "4" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9734;";
                } else if ( $testimonialRating === "5" ) {
                    $testimonialRating = "&#9733; &#9733; &#9733; &#9733; &#9733;";
                }
            } 
            
            
            $pluginContainer .= '<div class="testimonial">';
            if ( ! empty( $url_thumb ) ) {
                $pluginContainer .= '<img class="testimonial__image" src="' . $url_thumb . '" alt="' . $url_altText . '" />';
            }
            $pluginContainer .= '<h4 class="testimonial__title">' . $post->post_title . '</h4>';
            if ( ! empty( $post->post_content ) ) {
                $pluginContainer .= '<p class="testimonial__content">' . $post->post_content . '</p>';
            }
            if ( ! empty( $providedName ) ) {
                if ( ! empty( $link ) ) {
                    $pluginContainer .= '<span class="testimonial__provided-name"><a class="testimonial__link" href="' . $link . '" target="__blank">' . $providedName . '</a></span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__provided-name">' . $providedName . '</span>';
                }
            }
            if ( ! empty( $label ) ) {
                if ( ! empty( $providedName ) ) {
                    $pluginContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__label"> ' . $label . '</span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__label">' . $label . '</span>';
                }
            }
            if ( ! empty( $testimonialLocation ) ) { 
                if ( ! empty( $providedName ) || ! empty( $label ) ) {
                    $pluginContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__location"> ' . $testimonialLocation . '</span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__location">' . $testimonialLocation . '</span>';
                }
            }
            if ( ! empty( $testimonialDate ) ) { 
                if ( ! empty( $providedName ) || ! empty( $label ) || ! empty( $testimonialLocation ) ) {
                    $pluginContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__date"> ' . $testimonialDate . '</span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__date">' . $testimonialDate . '</span>';
                }
            }    
            if ( ! empty( $testimonialRating ) ) {
                $pluginContainer .= '<div class="testimonial__rating">' . $testimonialRating . '</div>';
            }
            $pluginContainer .= '</div>';
        }
        $count++;
    }
    $pluginContainer .= '</div>';
    $pluginContainer .= '</div>';
    return $pluginContainer;
}
add_shortcode( "general_testimonials", "gt_load_testimonials" );
add_filter( 'widget_text', 'do_shortcode' );
