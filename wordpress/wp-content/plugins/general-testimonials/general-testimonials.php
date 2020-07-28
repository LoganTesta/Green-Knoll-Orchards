<?php
/**
 * Plugin Name: General Testimonials
 * Plugin URI: https://www.tualatintopbakery.com/general-testimonials
 * Version: 1.0
 * Author: Tualatin Top Bakery
 * Description: Add customer testimonials to your site.  Use the shortcode [general_testimonials] where you want to output testimonials, for example in a WordPress generated admin page or a custom PHP page with WordPress enabled.
 * Author URI: https://www.tualatintopbakery.com
 */

defined( 'ABSPATH' ) or exit( "File protected." );


add_action( 'admin_enqueue_scripts', function(){ 
    wp_enqueue_style( 'general-testimonials-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-admin-styles.css' ); 
});

add_action( 'wp_enqueue_scripts', function(){ 
  wp_enqueue_style( 'general-testimonials-styling', plugin_dir_url(__FILE__) . '/assets/css/general-testimonials-styles.php' ); 
});


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
    add_option( 'general-testimonials-leading-text', 'Customer Testimonials' );
    add_option( 'general-testimonials-image-width-height', "120" );
    add_option( 'general-testimonials-border-radius', "15" );
    add_option( 'general-testimonials-float-image-direction', "left" );
    add_option( 'general-testimonials-testimonials-per-row', "2" );
    add_option( 'general-testimonials-number-to-display', "" );

    register_setting( 'general-testimonials-settings-group', 'general-testimonials-leading-text', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-image-width-height', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-border-radius', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-float-image-direction', 'gt_validatetextfield' );
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-testimonials-per-row', 'gt_validatetextfield' );  
    register_setting( 'general-testimonials-settings-group', 'general-testimonials-number-to-display', 'gt_validatetextfield' );  
}
add_action( 'admin_init', 'gt_register_settings' );


function gt_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}


function gt_generate_settings_page() {
    ?>
    <h1 class="general-testimonials__plugin-title">General Testimonials Settings</h1>
    <form class="testimonials-settings-form" method="post" action="options.php">
        <?php settings_fields( 'general-testimonials-settings-group' ); ?>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-leading-text">Testimonials Leading Text</label>
                <input id="generalTestimonialsLeadingText" class="admin-input-container__input general-testimonials-leading-text" name="general-testimonials-leading-text" type="text" value="<?php echo get_option( 'general-testimonials-leading-text' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-image-width-height">Image Width, Height (60-150px)</label>
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
                <input id="generalTestimonialsFloatImageDirection0" class="general-testimonials-float-image-direction" name="general-testimonials-float-image-direction" type="radio" value="left" <?php if( get_option( 'general-testimonials-float-image-direction' ) === "left" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsFloatImageDirection0">Left</label>
                <input id="generalTestimonialsFloatImageDirection1" class="general-testimonials-float-image-direction" name="general-testimonials-float-image-direction" type="radio" value="right" <?php if( get_option( 'general-testimonials-float-image-direction' ) === "right" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsFloatImageDirection1">Right</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Testimonials Per Row</span>         
                <input id="generalTestimonialsTestimonialsPerRow0" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="2" <?php if( get_option( 'general-testimonials-testimonials-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow0">2</label>
                <input id="generalTestimonialsTestimonialsPerRow1" class="general-testimonials-testimonials-per-row" name="general-testimonials-testimonials-per-row" type="radio" value="3" <?php if( get_option( 'general-testimonials-testimonials-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="generalTestimonialsTestimonialsPerRow1">3</label>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="general-testimonials-number-to-display">Testimonials to Display (Empty: display all)</label>
                <input id="generalTestimonialsNumberToDisplay" class="admin-input-container__input smaller general-testimonials-number-to-display" name="general-testimonials-number-to-display" type="number" value="<?php echo get_option( 'general-testimonials-number-to-display' ); ?>" />
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
    
    /*Gather the input data, sanitize it, and update the database.*/
    $testimonialprovidedname = sanitize_text_field( get_post_meta( $post->ID, 'testimonialprovidedname', true ) );
    update_post_meta( $post->ID, 'testimonialprovidedname', $testimonialprovidedname );
    $testimoniallabel = sanitize_text_field( get_post_meta( $post->ID, 'testimoniallabel', true ) );
    update_post_meta( $post->ID, 'testimoniallabel', $testimoniallabel );
    $testimonialurl = sanitize_text_field( get_post_meta( $post->ID, 'testimonialurl', true ) );
    update_post_meta( $post->ID, 'testimonialurl', $testimonialurl );
    $testimonialorder = sanitize_text_field( get_post_meta( $post->ID, 'testimonialorder', true ) );
    if( isset( $testimonialorder ) === false || $testimonialorder === "" ) {
        $testimonialorder = "n/a";
    }
    update_post_meta( $post->ID, 'testimonialorder', $testimonialorder );


    $errorsprovidedname = "";
    if( isset( $errorsprovidedname ) ){
        echo $errorsprovidedname;
    }
    
    $errorslabel = "";
    if( isset( $errorslabel ) ){
        echo $errorslabel;
    }
   
    $errorslink = "";
    if ( !preg_match( "/http(s?):\/\//", $testimonialurl ) && $testimonialurl !== "" ) {
        $errorslink = "This URL is not valid";
        $testimonialurl = "http://";
    }
    
    if( isset( $errorslink ) ){
        echo $errorslink;
    }
    
    $errorsorder = "";
    if( isset( $errorsorder ) ){
        echo $errorsorder;
    }
    
    ?>
    <p>
        <label for="testimonialprovidedname">Provided Testimonial Name:<br />
            <input id="testimonialprovidedname" name="testimonialprovidedname" size="37" value="<?php if( isset( $testimonialprovidedname ) ) { echo $testimonialprovidedname; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimoniallabel">Testimonial Label:<br />
            <input id="testimoniallabel" name="testimoniallabel" size="37" value="<?php if( isset( $testimoniallabel ) ) { echo $testimoniallabel; } ?>" />
        </label>
    </p>
    <p>
        <label for="testimonialurl">Related URL:<br />
            <input id="testimonialurl" size="37" name="testimonialurl" value="<?php if( isset( $testimonialurl ) ) { echo $testimonialurl; } ?>" />
        </label>
    </p>
        <p>
        <label for="testimonialorder">Testimonial Order:<br />
            <input id="testimonialorder" size="37" type="number" min="1" name="testimonialorder" value="<?php if( isset( $testimonialorder ) ) { echo $testimonialorder; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function gt_save_custom_testimonialprovidedname( $post_id ) {
    global $post;
    
    if( isset( $_POST['testimonialprovidedname'] ) ) {
        update_post_meta( $post->ID, 'testimonialprovidedname', $_POST['testimonialprovidedname'] );
    }
}
add_action( 'save_post', 'gt_save_custom_testimonialprovidedname' );

function gt_get_testimonialprovidedname( $post ) {
    $testimonialname = get_post_meta( $post->ID, 'testimonialprovidedname', true );
    return $testimonialname;
}


function gt_save_custom_testimoniallabel( $post_id ) {
    global $post;
    
    if( isset( $_POST['testimoniallabel'] ) ) {
        update_post_meta( $post->ID, 'testimoniallabel', $_POST['testimoniallabel'] );
    }
}
add_action( 'save_post', 'gt_save_custom_testimoniallabel' );

function gt_get_testimoniallabel( $post ) {
    $testimoniallabel = get_post_meta( $post->ID, 'testimoniallabel', true );
    return $testimoniallabel;
}


function gt_save_custom_url( $post_id ) {
    global $post;
    
    if( isset( $_POST['testimonialurl'] ) ) {
        update_post_meta( $post->ID, 'testimonialurl', $_POST['testimonialurl'] );
    }
}
add_action( 'save_post', 'gt_save_custom_url' );

function gt_get_url( $post ) {
    $testimonialurl = get_post_meta( $post->ID, 'testimonialurl', true );
    return $testimonialurl;
}


function gt_save_custom_order( $post_id ) {
    global $post;
    
    if( isset( $_POST['testimonialorder'] ) ) {
        update_post_meta( $post->ID, 'testimonialorder', $_POST['testimonialorder'] );
    }
}
add_action( 'save_post', 'gt_save_custom_order' );

function gt_get_order( $post ) {
    $testimonialorder = get_post_meta( $post->ID, 'testimonialorder', true );
    return $testimonialorder;
}



/*Adjust admin columns for Testimonials*/
if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === "general-testimonials" ){
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
        );   
        return $columns;
    }


    //Add images and other data to posts admin
    add_action( 'manage_posts_custom_column', 'gt_add_data_to_admin_columns', 10, 2 );
    function gt_add_data_to_admin_columns( $column, $post_id ) {
        if( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
        }
        if ( 'testimonialprovidedname' === $column ) {
            echo get_post_meta( $post_id, 'testimonialprovidedname', true );
        }
        if( 'content' === $column ) {
            echo get_post_field( 'post_content', $post_id );
        }
        if( 'order' === $column ) {
            echo get_post_meta( $post_id, 'testimonialorder', true );
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
function gt_load_testimonials( $a ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "general-testimonials"
    );

    if ( isset( $a['rand'] ) && $a['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'testimonialorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $a['max'] ) ) {
        $args['posts_per_page'] = (int) $a['max'];
    }

    //Get all testimonials.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="testimonials-container">';
    $pluginContainer .= '<h3 class="testimonials-container__heading">' . get_option( 'general-testimonials-leading-text' ) . '</h3>';
    $pluginContainer .= '<div class="testimonials-container__inner-wrapper">';
    
    $numberToDisplay = get_option( 'general-testimonials-number-to-display' );
    if( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = (int) $numberToDisplay;
    $count = 0;
    foreach ( $posts as $post ) {
        if( $count < $numberToDisplay || $numberToDisplay === -1 ){
            $url_thumb = wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
            $url_altText = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
            $providedName = gt_get_testimonialprovidedname( $post );
            $label = gt_get_testimoniallabel( $post );
            $link = gt_get_url( $post );
            $pluginContainer .= '<div class="testimonial">';
            if ( !empty( $url_thumb ) ) {
                $pluginContainer .= '<img class="testimonial__image" src="' . $url_thumb . '" alt="' . $url_altText . '" />';
            }
            $pluginContainer .= '<h4 class="testimonial__title">' . $post->post_title . '</h4>';
            if ( !empty( $post->post_content ) ) {
                $pluginContainer .= '<p class="testimonial__content">' . $post->post_content . '</p>';
            }
            if ( !empty( $providedName ) ) {
                if ( !empty( $link ) ) {
                    $pluginContainer .= '<span class="testimonial__provided-name"><a class="testimonial__link" href="' . $link . '" target="__blank">' . $providedName . '</a></span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__provided-name">' . $providedName . '</span>';
                }
            }
            if ( !empty( $label ) ) {
                if ( !empty( $providedName ) ) {
                    $pluginContainer .= '<span class="testimonial__label">, ' . $label . '</span>';
                } else {
                    $pluginContainer .= '<span class="testimonial__label">' . $label . '</span>';
                }
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
