<?php
/**
 * Plugin Name: Simple Events
 * Plugin URI: https://www.greenknollorchards.com/simple-events
 * Version: 1.0
 * Author: Green Knoll Orchards
 * Description: Add simple events to your site, with layout and styling customizations.
 * Author URI: https://www.greenknollorchards.com
 */

defined( 'ABSPATH' ) or exit( "File protected." );


add_action( 'admin_enqueue_scripts', function(){ 
    wp_enqueue_style( 'simple-events-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/simple-events-admin-styles.css' ); 
});

add_action( 'wp_enqueue_scripts', function(){ 
  wp_enqueue_style( 'simple-events-styling', plugin_dir_url(__FILE__) . '/assets/css/simple-events-styles.php' ); 
});


function se_create_event_post_type() {
    register_post_type('simple-events',
            array(
                'labels' => array(
                    'name' => __('Simple Events'),
                    'singular_name' => __('Simple Event')
                ),
                'public' => true,
                'show_in_menu' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'custom_fields' ),
                'hierarchical' => false
            )
    );
}
add_action( 'init', 'se_create_event_post_type' );


/*Set up the settings page*/
function se_admin_menu(){
    add_submenu_page( 'edit.php?post_type=simple-events', 'Settings', 'Settings', 'manage_options', 'simple-events', 'se_generate_settings_page' );
}
add_action( 'admin_menu', 'se_admin_menu' );


/*Set up the settings page inputs*/
function se_register_settings() {
    add_option( 'simple-events-leading-text', 'Our Events' );
    add_option( 'simple-events-leading-text-index', 'Our Events' );
    add_option( 'simple-events-events-page', '' );
    add_option( 'simple-events-image-width-height', "240" );
    add_option( 'simple-events-border-radius', "5" );
    add_option( 'simple-events-events-per-row', "3" );
    add_option( 'simple-events-number-to-display', "" );

    register_setting( 'simple-events-settings-group', 'simple-events-leading-text', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-leading-text-index', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-events-page', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-image-width-height', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-border-radius', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-events-per-row', 'se_validatetextfield' );  
    register_setting( 'simple-events-settings-group', 'simple-events-number-to-display', 'se_validatetextfield' );  
}
add_action( 'admin_init', 'se_register_settings');


function se_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}


function se_generate_settings_page() {
    ?>
    <h1 class="simple-events__plugin-title">Simple Events Settings</h1>
    <div class="simple-events__instructions">
        <p>Add simple events to your site, with layout and styling customizations.</p>
        <p>Use the shortcode [simple-events] where you want to output events.</p>
        <p>There is also a second shortcode, [simple-events_index], for when when you wish to create events on another page such as the index.  This different layout 
            includes links to your events page, and in the plugin settings you can set a different header text too. </p>
    </div>
    <form class="events-settings-form" method="post" action="options.php">
        <?php settings_fields( 'simple-events-settings-group' ); ?>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-leading-text">Events Leading Text</label>
                <input id="simpleEventsLeadingText" class="admin-input-container__input simple-events-leading-text" name="simple-events-leading-text" type="text" value="<?php echo get_option( 'simple-events-leading-text' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-leading-text-index">Index/Additional Page Events Text</label>
                <input id="simpleEventsLeadingTextIndex" class="admin-input-container__input simple-events-leading-text-index" name="simple-events-leading-text-index" type="text" value="<?php echo get_option( 'simple-events-leading-text-index' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-events-page">Events Page (page's URL Slug)</label>
                <input id="simpleEventsEventsPage" class="admin-input-container__input simple-events-events-page" name="simple-events-events-page" type="text" value="<?php echo get_option( 'simple-events-events-page' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-image-width-height">Max Image Height (80-400px)</label>
                <input id="simpleEventsNumberToDisplay" class="admin-input-container__input smaller simple-events-image-width-height" name="simple-events-image-width-height" type="number" value="<?php echo get_option( 'simple-events-image-width-height' ); ?>" min="80" max="400" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 240px</span>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-border-radius">Image Border Radius</label>
                <input id="simpleEventsImageWidthHeight" class="admin-input-container__input simple-events-border-radius" name="simple-events-border-radius" type="text" value="<?php echo get_option( 'simple-events-border-radius' ); ?>" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 5px</span>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Events Per Row</span>       
                <input id="simpleEventsEventsPerRow0" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="1" <?php if(get_option( 'simple-events-events-per-row' ) === "1") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow0">1</label>
                <input id="simpleEventsEventsPerRow1" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="2" <?php if(get_option( 'simple-events-events-per-row' ) === "2") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow1">2</label>
                <input id="simpleEventsEventsPerRow2" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="3" <?php if(get_option( 'simple-events-events-per-row' ) === "3") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow2">3</label>
                <input id="simpleEventsEventsPerRow3" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="4" <?php if(get_option( 'simple-events-events-per-row' ) === "4") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow3">4</label>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-number-to-display">Events to Display (Empty: display all)</label>
                <input id="simpleEventsNumberToDisplay" class="admin-input-container__input smaller simple-events-number-to-display" name="simple-events-number-to-display" type="number" value="<?php echo get_option( 'simple-events-number-to-display' ); ?>" />
            </div>
            <?php submit_button(); ?>
        </form>
    <?php
}


function se_add_custom_metabox_info() {
    add_meta_box( 'custom-metabox', __('Event Information'), 'se_url_custom_metabox', 'simple-events', 'side', 'low' );
    add_meta_box( 'custom-metabox-main', __('More Event Fields'), 'se_url_more_event_fields', 'simple-events', 'normal', 'low' );
}
add_action( 'admin_init', 'se_add_custom_metabox_info' );


//Admin area HTML and logic 
function se_url_custom_metabox() {
    global $post;
    
    /*Gather the input data, sanitize it, and update the database.*/
    $eventprice = sanitize_text_field( get_post_meta( $post->ID, 'eventprice', true ) );
    update_post_meta( $post->ID, 'eventprice', $eventprice );
    $eventdate = sanitize_text_field( get_post_meta( $post->ID, 'eventdate', true ) );
    update_post_meta( $post->ID, 'eventdate', $eventdate );
    $eventstarttime = sanitize_text_field( get_post_meta( $post->ID, 'eventstarttime', true ) );
    update_post_meta( $post->ID, 'eventstarttime', $eventstarttime );
    $eventendtime = sanitize_text_field( get_post_meta( $post->ID, 'eventendtime', true ) );
    update_post_meta( $post->ID, 'eventendtime', $eventendtime );
    $eventlabel = sanitize_text_field( get_post_meta( $post->ID, 'eventlabel', true ) );
    update_post_meta( $post->ID, 'eventlabel', $eventlabel );
    $eventorder = sanitize_text_field( get_post_meta( $post->ID, 'eventorder', true ) );
    if( isset( $eventorder ) === false || $eventorder === "" ) {
        $eventorder = "n/a";
    }
    update_post_meta( $post->ID, 'eventorder', $eventorder );


    $errorsprice = "";
    if( isset( $errorsprice ) ){
        echo $errorsprice;
    }
    
    $errorslabel = "";
    if( isset( $errorslabel ) ){
        echo $errorslabel;
    }
    
    $errorsorder = "";
    if( isset( $errorsorder ) ){
        echo $errorsorder;
    }
    
    ?>
    <p>
        <label for="eventprice">Price:<br />
            <input id="eventprice" name="eventprice" size="37" value="<?php if( isset( $eventprice ) ) { echo $eventprice; } ?>" />
        </label>
    </p>
    <p>
        <label for="eventdate">Date:<br />
            <input id="eventdate" name="eventdate" size="37" type="date" value="<?php if( isset( $eventdate ) ) { echo $eventdate; } ?>" />
        </label>
    </p>
    <p>
        <label for="eventstarttime">Start Time:<br />
            <input id="eventstarttime" name="eventstarttime" size="37" type="time" value="<?php if( isset( $eventstarttime ) ) { echo $eventstarttime; } ?>" />
        </label>
    </p>
    <p>
        <label for="eventendtime">End Time:<br />
            <input id="eventendtime" name="eventendtime" size="37" type="time" value="<?php if( isset( $eventendtime ) ) { echo $eventendtime; } ?>" />
        </label>
    </p>
    <p>
        <label for="eventlabel">Event Label:<br />
            <input id="eventlabel" name="eventlabel" size="37" value="<?php if( isset( $eventlabel ) ) { echo $eventlabel; } ?>" />
        </label>
    </p>
    <p>
        <label for="eventorder">Event Order:<br />
            <input id="eventorder" size="37" type="number" min="1" name="eventorder" value="<?php if( isset($eventorder) ) { echo $eventorder; } ?>" />
        </label>
    </p>
 <?php 
}


//Admin area HTML and logic 
function se_url_more_event_fields() {
    global $post;
    
    /*Gather the input data, sanitize it, and update the database.*/
    $eventshortdescription = sanitize_text_field( get_post_meta( $post->ID, 'eventshortdescription', true ) );
    update_post_meta( $post->ID, 'eventshortdescription', $eventshortdescription );

    $errorshortdescription = "";
    if( isset( $shortdescription ) ){
        echo $shortdescription;
    }
    
    ?>
    <p>
        <label for="eventshortdescription">Short Description (max 200 characters):<br />
            <textarea id="eventshortdescription" name="eventshortdescription" maxlength="200"><?php if( isset( $eventshortdescription ) ) { echo $eventshortdescription; } ?></textarea>
        </label>
    </p>
    
 <?php 
}


//Save user provided field data.
function se_save_custom_eventprice( $post_id ) {
    global $post;
    
    if( isset( $_POST['eventprice']) ) {
        update_post_meta( $post->ID, 'eventprice', $_POST['eventprice'] );
    }
}
add_action( 'save_post', 'se_save_custom_eventprice' );

function se_get_event_price( $post ) {
    $eventprice = get_post_meta( $post->ID, 'eventprice', true );
    return $eventprice;
}


function se_save_custom_eventdate( $post_id ) {
    global $post;
    
    if( isset( $_POST['eventdate']) ) {
        update_post_meta( $post->ID, 'eventdate', $_POST['eventdate'] );
    }
}
add_action( 'save_post', 'se_save_custom_eventdate' );

function se_get_event_date( $post ) {
    $eventdate = get_post_meta( $post->ID, 'eventdate', true );
    return $eventdate;
}


function se_save_custom_eventstarttime( $post_id ) {
    global $post;
    
    if( isset( $_POST['eventstarttime']) ) {
        update_post_meta( $post->ID, 'eventstarttime', $_POST['eventstarttime'] );
    }
}
add_action( 'save_post', 'se_save_custom_eventstarttime' );

function se_get_event_starttime( $post ) {
    $eventstarttime = get_post_meta( $post->ID, 'eventstarttime', true );
    return $eventstarttime;
}


function se_save_custom_eventendtime( $post_id ) {
    global $post;
    
    if( isset( $_POST['eventendtime']) ) {
        if( $_POST['eventstarttime'] <= $_POST['eventendtime'] ) {
            update_post_meta( $post->ID, 'eventendtime', $_POST['eventendtime'] );
        } else {
            update_post_meta( $post->ID, 'eventendtime', $_POST['eventstarttime'] );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventendtime' );

function se_get_event_eventendtime( $post ) {
    $eventendtime = get_post_meta( $post->ID, 'eventendtime', true );
    return $eventendtime;
}


function se_save_custom_event_label( $post_id ) {
    global $post;
    
    if( isset($_POST['eventlabel']) ) {
        update_post_meta( $post->ID, 'eventlabel', $_POST['eventlabel'] );
    }
}
add_action( 'save_post', 'se_save_custom_event_label' );

function se_get_event_label( $post ) {
    $eventlabel = get_post_meta( $post->ID, 'eventlabel', true );
    return $eventlabel;
}


function se_save_custom_order( $post_id ) {
    global $post;
    
    if( isset($_POST['eventorder']) ) {
        update_post_meta( $post->ID, 'eventorder', $_POST['eventorder'] );
    }
}
add_action( 'save_post', 'se_save_custom_order' );

function se_get_order( $post ) {
    $eventorder = get_post_meta( $post->ID, 'eventorder', true );
    return $eventorder;
}


function se_save_custom_eventshortdescription( $post_id ) {
    global $post;
    
    if( isset( $_POST['eventshortdescription']) ) {
        update_post_meta( $post->ID, 'eventshortdescription', $_POST['eventshortdescription'] );
    }
}
add_action( 'save_post', 'se_save_custom_eventshortdescription' );

function se_get_event_shortdescription( $post ) {
    $eventshortdescription = get_post_meta( $post->ID, 'eventshortdescription', true );
    return $eventshortdescription;
}




/*Adjust admin columns for Events*/
if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === "simple-events" ){
    add_filter( 'manage_posts_columns', 'se_setup_adjust_admin_columns' );
    function se_setup_adjust_admin_columns( $columns ) {
        $columns = array(
            'cb' => $columns['cb'],
            'title' => __( 'Title' ),
            'image' => __( 'Image' ), 
            'content' => __( 'Event Text' ),
            'eventprice' => __( 'Event Price', 'swe' ),
            'eventdate' => __( 'Event Date', 'swe' ),
            'eventstarttime' => __( 'Event Start Time', 'swe' ),
            'eventendtime' => __( 'Event End Time', 'swe' ),
            'order' => __( 'Order' ),
            'date' => __( 'Date' ),
        );   
        return $columns;
    }


    //Add images and other data to posts admin
    add_action( 'manage_posts_custom_column', 'se_add_data_to_admin_columns', 10, 2 );
    function se_add_data_to_admin_columns( $column, $post_id ) {
        if( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array(100, 100) );
        }
        if ( 'eventprice' === $column ) {
            echo get_post_meta( $post_id, 'eventprice', true);
        }
        if ( 'eventdate' === $column ) {
            echo get_post_meta( $post_id, 'eventdate', true);
        }
        if ( 'eventstarttime' === $column ) {
            echo get_post_meta( $post_id, 'eventstarttime', true);
        }
        if ( 'eventendtime' === $column ) {
            echo get_post_meta( $post_id, 'eventendtime', true);
        }
        if( 'content' === $column ) {
            echo get_post_field( 'post_content', $post_id );
        }
        if( 'order' === $column ) {
            echo get_post_meta( $post_id, 'eventorder', true );
        }
    }


    //Determine order of events shown in admin*/
    add_action( 'pre_get_posts', 'se_custom_post_order_sort' );
    function se_custom_post_order_sort( $query ) { 
        if ( $query->is_main_query() && $_GET[ 'post_type' ] === "simple-events" ){
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'meta_key', 'eventorder' );
            $query->set( 'order', 'ASC' );
        }
    }
}


//Register the shortcode so we can show events on a different page, most likely the index page.
function se_load_events_index( $a ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "simple-events"
    );

    if ( isset( $a['rand'] ) && $a['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'eventorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $a['max']) ) {
        $args['posts_per_page'] = (int) $a['max'];
    }

    //Get all events.
    $posts = get_posts($args);
    $pluginContainer .= '<div class="events-container index">';
    $pluginContainer .= '<div class="events-container__heading index">' . get_option( 'simple-events-leading-text-index' ) . '</div>';
    $pluginContainer .= '<div class="events-container__inner-wrapper">';

    $numberToDisplay = get_option( 'simple-events-events-per-row' );
    if( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = (int) $numberToDisplay;
    $count = 0;
    foreach ($posts as $post) {
        if( $count < $numberToDisplay  || $numberToDisplay === -1){
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
            $price = se_get_event_price( $post );
            $date = date('F j, Y', strtotime( se_get_event_date( $post ) ) );
            $startTime = date( "g:i a", strtotime( se_get_event_starttime( $post ) ) );
            $endTime = date( "g:i a", strtotime( se_get_event_eventendtime( $post ) ) );
            $label = se_get_event_label( $post );
            $eventshortdescription = se_get_event_shortdescription( $post );
            $pluginContainer .= '<div class="event">';
            $pluginContainer .= '<div class="event__title"><a class="event__name-link" href="' . get_option( 'simple-events-events-page' ) . '">' . $post->post_title . '</a></div>';
            $pluginContainer .= '<div class="event__date">' . $date . '</div>';
            if ( !empty( $startTime ) ) {
                $pluginContainer .= '<div class="event__starttime">&nbsp;from ' . $startTime . '</div>';
            }
            if ( !empty( $endTime ) ) {
                $pluginContainer .= '<div class="event__endtime">&nbsp;- ' . $endTime . '</div>';
            }
            if ( !empty( $url_thumb ) ) {
                $pluginContainer .= '<div class="event__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat">'
                        . '<a class="event__background-link" href="' . get_option( 'simple-events-events-page' ) . '"><span class="sr-only">' . $post->post_title . 'Link</span></a>'
                        . '</div>';
            }
            if ( !empty( $eventshortdescription ) ) {
                $pluginContainer .= '<div class="event__shortdescription">' . $eventshortdescription . '</div>';    
            }
            if ( !empty( $post->post_content ) ) {
                
            }
            $pluginContainer .= '</div>';
        }
        $count++;
    }
    $pluginContainer .= '</div>';
    $pluginContainer .= '</div>';
    
    return $pluginContainer;
}


//Register the shortcode so we can show events.
function se_load_events( $a ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "simple-events"
    );

    if ( isset( $a['rand'] ) && $a['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'eventorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $a['max']) ) {
        $args['posts_per_page'] = (int) $a['max'];
    }

    //Get all events.
    $posts = get_posts($args);
    $pluginContainer .= '<div class="events-container">';
    $pluginContainer .= '<div class="events-container__heading">' . get_option( 'simple-events-leading-text' ) . '</div>';
    $pluginContainer .= '<div class="events-container__inner-wrapper">';
    
    $numberToDisplay = get_option( 'simple-events-number-to-display' );
    if( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = (int) $numberToDisplay;
    $count = 0;
    foreach ($posts as $post) {
        if( $count < $numberToDisplay  || $numberToDisplay === -1){
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
            $price = se_get_event_price( $post );
            $date = date('F j, Y', strtotime( se_get_event_date( $post ) ) );
            $startTime = date( "g:i a", strtotime( se_get_event_starttime( $post ) ) );
            $endTime = date( "g:i a", strtotime( se_get_event_eventendtime( $post ) ) );
            $label = se_get_event_label( $post );
            $pluginContainer .= '<div class="event">';
            $pluginContainer .= '<div class="event__title">' . $post->post_title . '</div>';
            if ( !empty( $url_thumb ) ) {
                $pluginContainer .= '<div class="event__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat"></div>';
            }
            if ( !empty( $date ) ) {
                $pluginContainer .= '<div class="event__date">' . $date . '</div>';
            }
            if ( !empty( $startTime ) ) {
                $pluginContainer .= ' at <div class="event__starttime">' . $startTime . '.</div>';
            }
            if ( !empty( $endTime ) ) {
                $pluginContainer .= '<div class="event__endtime">&nbsp;- ' . $endTime . '</div>';
            }
            if ( !empty( $price ) ) {
                    $pluginContainer .= '<div class="event__price">&nbsp;Cost: ' . $price . '</div>';
            }
            if ( !empty( $label ) ) {
                $pluginContainer .= '<div class="event__label">' . $label . '</div>';
            }
            if ( !empty( $post->post_content ) ) {
                $pluginContainer .= '<p class="event__content">' . $post->post_content . '</p>';
            }
            $pluginContainer .= '</div>';
        }
        $count++;
    }
    $pluginContainer .= '</div>';
    $pluginContainer .= '</div>';
    
    return $pluginContainer;
}


add_shortcode( "simple_events_index", "se_load_events_index" );
add_filter( 'widget_text', 'do_shortcode' );

add_shortcode( "simple_events", "se_load_events" );
add_filter( 'widget_text', 'do_shortcode' );



