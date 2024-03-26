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


add_action( 'admin_enqueue_scripts', function() { 
    wp_enqueue_style( 'simple-events-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/simple-events-admin-styles.css' ); 
} );

add_action( 'wp_enqueue_scripts', function() { 
  wp_enqueue_style( 'simple-events-styling', plugin_dir_url(__FILE__) . '/assets/css/simple-events-styles.php' ); 
} );


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
                'hierarchical' => false,
                'taxonomies' => array( 'category' )
            )
    );
}
add_action( 'init', 'se_create_event_post_type' );


/*Set up the settings page*/
function se_admin_menu() {
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
    add_option( 'simple-events-event-page-events-per-row', "3" );
    add_option( 'simple-events-order-by', "1" );
    add_option( 'simple-events-date-layout', "3" );
    add_option( 'simple-events-number-to-display', "" );

    register_setting( 'simple-events-settings-group', 'simple-events-leading-text', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-leading-text-index', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-events-page', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-image-width-height', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-border-radius', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-events-per-row', 'se_validatetextfield' ); 
    register_setting( 'simple-events-settings-group', 'simple-events-event-page-events-per-row', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-order-by', 'se_validatetextfield' ); 
    register_setting( 'simple-events-settings-group', 'simple-events-date-layout', 'se_validatetextfield' );
    register_setting( 'simple-events-settings-group', 'simple-events-number-to-display', 'se_validatetextfield' );  
}
add_action( 'admin_init', 'se_register_settings' );


function se_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}


function se_generate_settings_page() {
    ?>
    <div class="simple-events__settings-header">
        <h1 class="simple-events__plugin-title">Simple Events Settings</h1>
        <div class="simple-events__instructions">
            <p>Add simple events to your site, with layout and styling customizations.</p>
            <p>Use the shortcode [simple-events] where you want to output events.</p>
            <p>There is also a second shortcode, [simple-events_index], for when when you wish to create events on another page such as the index.  This different layout 
                includes links to your events page, and in the plugin settings you can set a different header text too. </p>
        </div>
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
                <label class="admin-input-container__label" for="simple-events-events-page">Events Page Slug, don't add lead slash (/)</label>
                <input id="simpleEventsEventsPage" class="admin-input-container__input simple-events-events-page" name="simple-events-events-page" type="text" value="<?php echo get_option( 'simple-events-events-page' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-image-width-height">Max Image Height (200-500px)</label>
                <input id="simpleEventsNumberToDisplay" class="admin-input-container__input smaller simple-events-image-width-height" name="simple-events-image-width-height" type="number" value="<?php echo get_option( 'simple-events-image-width-height' ); ?>" min="200" max="500" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 260px</span>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="simple-events-border-radius">Image Border Radius</label>
                <input id="simpleEventsImageWidthHeight" class="admin-input-container__input simple-events-border-radius" name="simple-events-border-radius" type="text" value="<?php echo get_option( 'simple-events-border-radius' ); ?>" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 5px</span>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Events Per Row</span>       
                <input id="simpleEventsEventsPerRow0" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="1" <?php if ( get_option( 'simple-events-events-per-row' ) === "1" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow0">1</label>
                <input id="simpleEventsEventsPerRow1" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="2" <?php if ( get_option( 'simple-events-events-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow1">2</label>
                <input id="simpleEventsEventsPerRow2" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="3" <?php if ( get_option( 'simple-events-events-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow2">3</label>
                <input id="simpleEventsEventsPerRow3" class="simple-events-events-per-row" name="simple-events-events-per-row" type="radio" value="4" <?php if ( get_option( 'simple-events-events-per-row' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventsPerRow3">4</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Events Per Row in Events Page</span>       
                <input id="simpleEventsEventPageEventsPerRow0" class="simple-events-event-page-events-per-row" name="simple-events-event-page-events-per-row" type="radio" value="1" <?php if ( get_option( 'simple-events-event-page-events-per-row' ) === "1" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventPageEventsPerRow0">1</label>
                <input id="simpleEventsEventPageEventsPerRow1" class="simple-events-event-page-events-per-row" name="simple-events-event-page-events-per-row" type="radio" value="2" <?php if ( get_option( 'simple-events-event-page-events-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventPageEventsPerRow1">2</label>
                <input id="simpleEventsEventPageEventsPerRow2 class="simple-events-event-page-events-per-row" name="simple-events-event-page-events-per-row" type="radio" value="3" <?php if ( get_option( 'simple-events-event-page-events-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventPageEventsPerRow2">3</label>
                <input id="simpleEventsEventPageEventsPerRow3" class="simple-events-event-page-events-per-row" name="simple-events-event-page-events-per-row" type="radio" value="4" <?php if ( get_option( 'simple-events-event-page-events-per-row' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsEventPageEventsPerRow3">4</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Order Events By:</span>       
                <input id="simpleEventsOrderBy0" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventorder" <?php if ( get_option( 'simple-events-order-by' ) === "eventorder" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy0">Order (default)</label>
                <input id="simpleEventsOrderBy1" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventdateasc" <?php if ( get_option( 'simple-events-order-by' ) === "eventdateasc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy1">Date (Old - New)</label>
                <input id="simpleEventsOrderBy2" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventdatedesc" <?php if ( get_option( 'simple-events-order-by' ) === "eventdatedesc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy2">Date (New - Old)</label>
                <input id="simpleEventsOrderBy3" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventtitleasc" <?php if ( get_option( 'simple-events-order-by' ) === "eventtitleasc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy3">Title</label>
                <input id="simpleEventsOrderBy4" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventtitledesc" <?php if ( get_option( 'simple-events-order-by' ) === "eventtitledesc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy4">Title (Z - A)</label>
                <input id="simpleEventsOrderBy5" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventpriceasc" <?php if ( get_option( 'simple-events-order-by' ) === "eventpriceasc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy5">Price</label>
                <input id="simpleEventsOrderBy6" class="simple-events-order-by" name="simple-events-order-by" type="radio" value="eventpricedesc" <?php if ( get_option( 'simple-events-order-by' ) === "eventpricedesc" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsOrderBy6">Price (decreasing)</label>
            </div>
            <div class="admin-input-container event-dates-layout">
                <span class="admin-input-container__label">Layout of Event Dates</span>       
                <input id="simpleEventsDateLayout0" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="1" <?php if ( get_option( 'simple-events-date-layout' ) === "1" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout0">
                    <span class="date-format">mm/dd/year</span> <span class="date-example">05/14/2023</span>
                </label>
                <input id="simpleEventsDateLayout1" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="2" <?php if ( get_option( 'simple-events-date-layout' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout1">
                    <span class="date-format">dd/mm/year</span> <span class="date-example">14/05/2023</span>
                </label>
                <input id="simpleEventsDateLayout2" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="3" <?php if ( get_option( 'simple-events-date-layout' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right has-additional-date-info" for="simpleEventsDateLayout2">
                    <span class="date-format">Month Day, Year</span> <span class="date-example">May 14, 2023</span> <span class="additional-date-info">(default)</span></label>
                <input id="simpleEventsDateLayout3" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="4" <?php if ( get_option( 'simple-events-date-layout' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout3">
                    <span class="date-format">Day Month Year</span> <span class="date-example">14 May 2023</span>
                </label>
                <input id="simpleEventsDateLayout4" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="5" <?php if ( get_option( 'simple-events-date-layout' ) === "5" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout4">
                    <span class="date-format">Mon. dd Year</span> <span class="date-example">May 14 2023</span>
                </label>
                <input id="simpleEventsDateLayout5" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="6" <?php if ( get_option( 'simple-events-date-layout' ) === "6" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout5">
                    <span class="date-format">dd Mon. Year</span> <span class="date-example">14 May 2023</span>
                </label>
                <input id="simpleEventsDateLayout6" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="7" <?php if ( get_option( 'simple-events-date-layout' ) === "7" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout6">
                    <span class="date-format">Mon. dd or. Year</span> <span class="date-example">May 14th 2023</span>
                </label>
                <input id="simpleEventsDateLayout7" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="8" <?php if ( get_option( 'simple-events-date-layout' ) === "8" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout7">
                    <span class="date-format">Mon. dd or. Year</span> <span class="date-example">14th May 2023</span>
                </label>
                <input id="simpleEventsDateLayout8" class="simple-events-date-layout" name="simple-events-date-layout" type="radio" value="9" <?php if ( get_option( 'simple-events-date-layout' ) === "9" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="simpleEventsDateLayout8">
                    <span class="date-format">Month Year</span> <span class="date-example">May 2023</span>
                </label>
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
    add_meta_box( 'custom-metabox', __( 'Event Information' ), 'se_url_custom_metabox', 'simple-events', 'side', 'low' );
    add_meta_box( 'custom-metabox-fields', __( 'Event Fields' ), 'se_url_event_fields', 'simple-events', 'normal', 'high' );
}
add_action( 'admin_init', 'se_add_custom_metabox_info' );


//Admin area HTML and logic 
function se_url_custom_metabox() {
    global $post;
    
    wp_nonce_field( 'settings_group_nonce_save', 'settings_group_nonce' );
    
  
    /*Gather the input data, sanitize it, and update the database.*/
    $eventprice = sanitize_text_field( get_post_meta( $post->ID, 'eventprice', true ) );
    update_post_meta( $post->ID, 'eventprice', $eventprice );
    $eventdate = sanitize_text_field( get_post_meta( $post->ID, 'eventdate', true ) );
    update_post_meta( $post->ID, 'eventdate', $eventdate );
    $ismultiday = sanitize_text_field( get_post_meta( $post->ID, 'ismultiday', true ) );
    update_post_meta( $post->ID, 'ismultiday', $ismultiday );
    $eventstarttime = sanitize_text_field( get_post_meta( $post->ID, 'eventstarttime', true ) );
    update_post_meta( $post->ID, 'eventstarttime', $eventstarttime );
    $eventendtime = sanitize_text_field( get_post_meta( $post->ID, 'eventendtime', true ) );
    update_post_meta( $post->ID, 'eventendtime', $eventendtime );
    $eventenddate = sanitize_text_field( get_post_meta( $post->ID, 'eventenddate', true ) );
    update_post_meta( $post->ID, 'eventenddate', $eventenddate );
    $eventtimes = sanitize_text_field( get_post_meta( $post->ID, 'eventtimes', true ) );
    update_post_meta( $post->ID, 'eventtimes', $eventtimes );
    $eventlabel = sanitize_text_field( get_post_meta( $post->ID, 'eventlabel', true ) );
    update_post_meta( $post->ID, 'eventlabel', $eventlabel );
    $eventlocation = sanitize_text_field( get_post_meta( $post->ID, 'eventlocation', true ) );
    update_post_meta( $post->ID, 'eventlocation', $eventlocation );
    $eventlocationaddress = sanitize_text_field( get_post_meta( $post->ID, 'eventlocationaddress', true ) );
    update_post_meta( $post->ID, 'eventlocationaddress', $eventlocationaddress );
    $eventorder = sanitize_text_field( get_post_meta( $post->ID, 'eventorder', true ) );
    if ( isset( $eventorder ) === false || $eventorder === "" ) {
        $eventorder = "n/a";
    }
    update_post_meta( $post->ID, 'eventorder', $eventorder );


    $errorsprice = "";
    if ( isset( $errorsprice ) ) {
        echo $errorsprice;
    }
    
    $errorslabel = "";
    if ( isset( $errorslabel ) ) {
        echo $errorslabel;
    }
    
    $errorsorder = "";
    if ( isset( $errorsorder ) ) {
        echo $errorsorder;
    }
    
    ?>
    <div id="eventVariables">
        <p>
            <label for="eventprice">Price (number, no symbols):<br />
                <input id="eventprice" name="eventprice" value="<?php if ( isset( $eventprice ) ) { echo $eventprice; } ?>" />
            </label>
        </p>
        <p>
            <label for="eventdate">Date:<br />
                <input id="eventdate" name="eventdate" type="date" value="<?php if ( isset( $eventdate ) ) { echo $eventdate; } ?>" />
            </label>
        </p>
        <p>
            <span>Event Length: <?php echo $ismultiday; ?></span><br /> 
            <label for="ismultiday0">1 day</label>
            <input id="ismultiday0" name="ismultiday" type="radio" value="1 day" <?php if ( $ismultiday === "1 day" ) { echo 'checked="checked"'; } ?> />
            <label for="ismultiday1">Multi-day</label>
            <input id="ismultiday1" name="ismultiday" type="radio" value="Multi-day" <?php if ( $ismultiday === "Multi-day" ) { echo 'checked="checked"'; } ?> />    
        </p>
        <div class="admin-sidebar-section">
            <p class="admin-subheader">Single Day times ONLY:</p>
            <p>
                <label for="eventstarttime">Start Time:<br />
                    <input id="eventstarttime" name="eventstarttime" type="time" value="<?php if ( isset( $eventstarttime ) ) { echo $eventstarttime; } ?>" />
                </label>
            </p>
            <p>
                <label for="eventendtime">End Time:<br />
                    <input id="eventendtime" name="eventendtime" type="time" value="<?php if ( isset( $eventendtime ) ) { echo $eventendtime; } ?>" />
                </label>
            </p>
            <p class="admin-subheader">Multi-day times and dates ONLY:</p>
            <p>
                <label for="eventenddate">End Date:<br />
                    <input id="eventenddate" name="eventenddate" type="date" value="<?php if ( isset( $eventenddate ) ) { echo $eventenddate; } ?>" />
                </label>
            </p>
            <p>
                <label for="eventtimes">Event Times:<br />
                    <textarea id="eventtimes" name="eventtimes"><?php if ( isset( $eventtimes ) ) { echo $eventtimes; } ?></textarea>
                </label>
            </p>
        </div>
        <p>
            <label for="eventlabel">Event Label:<br />
                <input id="eventlabel" name="eventlabel" value="<?php if ( isset( $eventlabel ) ) { echo $eventlabel; } ?>" />
            </label>
        </p>
        <p>
            <label for="eventlocation">Location:<br />
                <input id="eventlocation" name="eventlocation" value="<?php if ( isset( $eventlocation ) ) { echo $eventlocation; } ?>" />
            </label>
        </p>
        <p>
            <label for="eventlocationaddress">Location Address:<br />
                <input id="eventlocationaddress" name="eventlocationaddress" value="<?php if ( isset( $eventlocationaddress ) ) { echo $eventlocationaddress; } ?>" />
            </label>
        </p>
        <p>
            <label for="eventorder">Event Order:<br />
                <input id="eventorder" type="number" min="1" name="eventorder" value="<?php if ( isset( $eventorder ) ) { echo $eventorder; } ?>" />
            </label>
        </p>
    </div>
 <?php 
}


//Admin area HTML and logic 
function se_url_event_fields() {
    global $post;
    
    /*Gather the input data, sanitize it, and update the database.*/
    $eventshortdescription = sanitize_text_field( get_post_meta( $post->ID, 'eventshortdescription', true ) );
    update_post_meta( $post->ID, 'eventshortdescription', $eventshortdescription );

    $errorshortdescription = "";
    if ( isset( $shortdescription ) ) {
        echo $shortdescription;
    }
    
    $eventorganizer = sanitize_text_field( get_post_meta( $post->ID, 'eventorganizer', true ) );
    update_post_meta( $post->ID, 'eventorganizer', $eventorganizer );
    
    ?>
    <p>
        <label for="eventshortdescription">Short Description (max 200 characters):<br />
            <textarea id="eventshortdescription" name="eventshortdescription" maxlength="200"><?php if ( isset( $eventshortdescription ) ) { echo $eventshortdescription; } ?></textarea>
        </label>
    </p>
    <p>
        <label for="eventorganizer">Organizer:<br />
            <textarea id="eventorganizer" name="eventorganizer" maxlength="200"><?php if ( isset( $eventorganizer ) ) { echo $eventorganizer; } ?></textarea>
        </label>
    </p>

 <?php 
}


//Save user provided field data.
function se_save_custom_eventprice( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventprice'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventprice', $_POST['eventprice'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventprice' );

function se_get_event_price( $post ) {
    $eventprice = get_post_meta( $post->ID, 'eventprice', true );
    return $eventprice;
}


function se_save_custom_eventdate( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventdate'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventdate', $_POST['eventdate'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventdate' );

function se_get_event_date( $post ) {
    $eventdate = get_post_meta( $post->ID, 'eventdate', true );
    return $eventdate;
}


function se_save_custom_ismultiday( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['ismultiday'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'ismultiday', $_POST['ismultiday'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_ismultiday' );

function se_get_is_multiday( $post ) {
    $ismultiday = get_post_meta( $post->ID, 'ismultiday', true );
    return $ismultiday;
}


function se_save_custom_eventstarttime( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventstarttime'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventstarttime', $_POST['eventstarttime'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventstarttime' );

function se_get_event_starttime( $post ) {
    $eventstarttime = get_post_meta( $post->ID, 'eventstarttime', true );
    return $eventstarttime;
}


function se_save_custom_eventendtime( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventendtime'] ) ) {
        if ( $nonceToVerify ) { 
            if ( $_POST['eventstarttime'] <= $_POST['eventendtime'] ) {
                update_post_meta( $post->ID, 'eventendtime', $_POST['eventendtime'] );
            } else {
                update_post_meta( $post->ID, 'eventendtime', '' );
            }
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventendtime' );

function se_get_event_eventendtime( $post ) {
    $eventendtime = get_post_meta( $post->ID, 'eventendtime', true );
    return $eventendtime;
}


function se_save_custom_eventenddate( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventenddate'] ) ) {
        if ( $nonceToVerify ) { 
            if ( $_POST['eventdate'] <= $_POST['eventenddate'] ) {
                update_post_meta( $post->ID, 'eventenddate', $_POST['eventenddate'] );
            } else {
                update_post_meta( $post->ID, 'eventenddate', '' );
            }
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventenddate' );

function se_get_event_eventenddate( $post ) {
    $eventenddate = get_post_meta( $post->ID, 'eventenddate', true );
    return $eventenddate;
}


function se_save_custom_eventtimes( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventtimes'] ) ) {
        if ( $nonceToVerify ) { 
            if ( $_POST['eventstarttime'] <= $_POST['eventtimes'] ) {
                update_post_meta( $post->ID, 'eventtimes', $_POST['eventtimes'] );
            } else {
                update_post_meta( $post->ID, 'eventtimes', '' );
            }
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_eventtimes' );

function se_get_event_eventtimes( $post ) {
    $eventtimes = get_post_meta( $post->ID, 'eventtimes', true );
    return $eventtimes;
}


function se_save_custom_event_label( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventlabel'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventlabel', $_POST['eventlabel'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_event_label' );

function se_get_event_label( $post ) {
    $eventlabel = get_post_meta( $post->ID, 'eventlabel', true );
    return $eventlabel;
}


function se_save_custom_location( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventlocation'] ) ) {
        if ( $nonceToVerify ) {
        update_post_meta( $post->ID, 'eventlocation', $_POST['eventlocation'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_location' );

function se_get_location( $post ) {
    $eventlocation = get_post_meta( $post->ID, 'eventlocation', true );
    return $eventlocation;
}


function se_save_custom_locationaddress( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventlocationaddress'] ) ) {
        if ( $nonceToVerify ) {
        update_post_meta( $post->ID, 'eventlocationaddress', $_POST['eventlocationaddress'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_locationaddress' );

function se_get_locationaddress( $post ) {
    $eventlocationaddress = get_post_meta( $post->ID, 'eventlocationaddress', true );
    return $eventlocationaddress;
}


function se_save_custom_organizer( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventorganizer'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventorganizer', $_POST['eventorganizer'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_organizer' );

function se_get_organizer( $post ) {
    $eventorganizer = get_post_meta( $post->ID, 'eventorganizer', true );
    return $eventorganizer;
}


function se_save_custom_order( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventorder'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventorder', $_POST['eventorder'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'se_save_custom_order' );

function se_get_order( $post ) {
    $eventorder = get_post_meta( $post->ID, 'eventorder', true );
    return $eventorder;
}


function se_save_custom_eventshortdescription( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['eventshortdescription'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'eventshortdescription', $_POST['eventshortdescription'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
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
            'eventdate' => __( 'Start Date', 'swe' ),
            'eventenddate' => __( 'End Date' ),
            'order' => __( 'Order' ),
            'date' => __( 'Date' ),
        );   
        return $columns;
    }


    //Add images and other data to posts admin
    add_action( 'manage_posts_custom_column', 'se_add_data_to_admin_columns', 10, 2 );
    function se_add_data_to_admin_columns( $column, $post_id ) {
        
        if ( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
        }
        if ( 'content' === $column ) {
            echo wp_trim_words( get_post_field( 'post_content', $post_id ), 30 );
        }
        if ( 'eventprice' === $column ) {
            echo get_post_meta( $post_id, 'eventprice', true );
        }
        if ( 'eventdate' === $column ) {
            echo get_post_meta( $post_id, 'eventdate', true );
        }
        if ( 'eventenddate' === $column ) {
            echo get_post_meta( $post_id, 'eventenddate', true );
        }
        if ( 'order' === $column ) {
            echo get_post_meta( $post_id, 'eventorder', true );
        }
    }


    //Determine order of events shown in admin*/
    add_action( 'pre_get_posts', 'se_custom_post_order_sort' );
    function se_custom_post_order_sort( $query ) { 
        if ( $query->is_main_query() && $_GET[ 'post_type' ] === "simple-events" ) {
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'meta_key', 'eventorder' );
            $query->set( 'order', 'ASC' );
        }
    }
}


//Register the shortcode so we can show events on a different page, most likely the index page.
function se_load_events_index( $postQuery ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "simple-events"
    );
   
    
    $eventOrderSetting = get_option( 'simple-events-order-by' );
    $orderBy = "meta_value";
    $metaKey = "eventorder";
    $order = "";

    if ( $eventOrderSetting === "eventdateasc" ) {
        $orderBy = "";
        $metaKey = "eventdate";
        $order = "ASC";
    } else if ( $eventOrderSetting === "eventdatedesc" ) {
        $orderBy = "";
        $metaKey = "eventdate";
        $order = "DESC";
    } else if ( $eventOrderSetting === "eventtitleasc" ) {
        $orderBy = "title";
        $metaKey = "";
        $order = "ASC";
    } else if ( $eventOrderSetting === "eventtitledesc" ) {
        $orderBy = "title";
        $metaKey = "";
        $order = "DESC";
    } else if ( $eventOrderSetting === "eventpriceasc" ) {
        $orderBy = "eventprice";
        $metaKey = "eventprice";
        $order = "ASC";
    } else if ( $eventOrderSetting === "eventpricedesc" ) {
        $orderBy = "eventprice";
        $metaKey = "eventprice";
        $order = "DESC";
    }


    $args['orderby'] =  $orderBy;
    $args['meta_key'] = $metaKey;
    $args['order'] = $order;
    

    if ( isset( $postQuery['max']) ) {
        $args['posts_per_page'] = ( int ) $postQuery['max'];
    }

    $dateLayout = intval( get_option( 'simple-events-date-layout' ) );
    $dateLayoutFormat = "";
    if ( $dateLayout === 1 ) {
        $dateLayoutFormat = 'm/d/Y';
    } else if ( $dateLayout === 2 ) {
        $dateLayoutFormat = 'd/m/Y';
    } else if ( $dateLayout === 3 ) {
         $dateLayoutFormat = 'F j, Y';
    } else if ( $dateLayout === 4 ) {
         $dateLayoutFormat = 'j F Y';
    } else if ( $dateLayout === 5 ) {
         $dateLayoutFormat = 'M d Y';
    } else if ( $dateLayout === 6 ) {
         $dateLayoutFormat = 'd M Y';
    } else if ( $dateLayout === 7 ) {
         $dateLayoutFormat = 'F jS Y';
    } else if ( $dateLayout === 8 ) {
         $dateLayoutFormat = 'jS F Y';
    } else if ( $dateLayout === 9 ) {
         $dateLayoutFormat = 'F Y';
    }
    
    //Get all events.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="events-container index">';
    $pluginContainer .= '<div class="events-container__heading index">' . get_option( 'simple-events-leading-text-index' ) . '</div>';
    $pluginContainer .= '<div class="events-container__inner-wrapper">';

    $numberToDisplay = get_option( 'simple-events-events-per-row' );
    if ( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = ( int ) $numberToDisplay;
    $count = 0;
    foreach ( $posts as $post ) {
        if ( $count < $numberToDisplay  || $numberToDisplay === -1 ) {
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
            $price = se_get_event_price( $post );
            $date;
            $startTime = "";
            $endTime = "";
            $eventenddate = "";
            $eventtimes = "";
            if ( se_get_is_multiday( $post ) !== "Multi-day" ) {
                $date = date( $dateLayoutFormat, strtotime( se_get_event_date( $post ) ) );
                if ( se_get_event_starttime( $post ) !== "" ) {
                    $startTime = date( "g:i a", strtotime( se_get_event_starttime( $post ) ) );
                }
                if ( se_get_event_eventendtime( $post ) !== "" ) {
                    $endTime = date( "g:i a", strtotime( se_get_event_eventendtime( $post ) ) );
                } 
            } else {
                $date = date( $dateLayoutFormat, strtotime( se_get_event_date( $post ) ) ) . " - " . date( $dateLayoutFormat, strtotime( se_get_event_eventenddate( $post ) ) );
                $eventtimes = se_get_event_eventtimes( $post );
            }
            $label = se_get_event_label( $post );
            $location = se_get_location( $post );
            $locationaddress = se_get_locationaddress( $post );
            $organizer = se_get_organizer( $post );
            $eventtext = "";
            $eventshortdescription = se_get_event_shortdescription( $post );
            $eventcontent = $post->post_content;
            if ( ! empty ( $eventshortdescription ) ) {
                $eventtext = $eventshortdescription;
            } else {
                $eventtext = wp_trim_words( $eventcontent, 60 );
            }
            
            
            $eventCategories = "";
            $categories = get_the_category( $post->ID );
            
            $categoryNumber = 0;
            $numberOfCategories = count( $categories );
            if ( ! empty( $categories ) ) {
                foreach( $categories as $category ) {
                    if ( $categoryNumber < $numberOfCategories - 1 ) {
                        $eventCategories .= $category->name . ", ";
                    } else { 
                        $eventCategories .= $category->name . " ";
                    }
                    $categoryNumber++;
                }
            }
            
            
            $pluginContainer .= '<div class="event">';
            if ( ! empty( $url_thumb ) ) {
                $pluginContainer .= '<div class="event__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat">'
                        . '<a class="event__background-link" href="' . get_option( 'simple-events-events-page' ) . '">'                      
                        . '<span class="sr-only">' . $post->post_title . 'Link</span></a>';
                if ( ! empty( $label ) ) {
                    $pluginContainer .= '<div class="event__label">' . $label . '</div>';
                }
                $pluginContainer .= '</div>';
            }
            $pluginContainer .= '<div class="event__title"><a class="event__name-link" href="' . get_option( 'simple-events-events-page' ) . '">' . $post->post_title . '</a></div>';
            $pluginContainer .= '<div class="event__date">' . $date . '</div> ';
            if ( ! empty( $location ) ) {
                $pluginContainer .= '<div class="event__location">' . $location . '</div> ';
            }
            if ( ! empty( $locationaddress ) ) {
                $pluginContainer .= '<div class="event__location-address">' . $locationaddress . '</div> ';
            }
            if ( ! empty( $organizer ) ) {
                $pluginContainer .= '<div class="event__organizer">' . $organizer . '</div> ';
            }
            if ( se_get_is_multiday( $post ) !== "Multi-day" ) {
                if ( ! empty( $startTime ) && ! empty( $endTime ) ) {
                    $pluginContainer .= '<div class="event__times">';
                    if ( ! empty( $startTime ) ) {
                        $pluginContainer .= '<div class="event__starttime">from ' . $startTime . '</div>';
                    }
                    $eventStartAndEndText = "";
                    if ( ! empty( $startTime ) && ! empty( $endTime ) ) {
                        $eventStartAndEndText = "&nbsp;- ";
                    }
                    if ( ! empty( $endTime ) ) {
                        $pluginContainer .= '<div class="event__endtime">' . $eventStartAndEndText . $endTime . '</div>';
                    }
                    $pluginContainer .= '</div>';
                }
            } else {
                if ( ! empty( $eventtimes ) ) {
                    $pluginContainer .= '<div class="event__times">' . $eventtimes . '</div>';
                }
            }
            $pluginContainer .= '<div class="event__short-description">' . $eventtext . '</div>';
            if ( ! empty( $eventCategories ) ) {
                $pluginContainer .= '<div class="event__categories">' . $eventCategories . '</div>';
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
function se_load_events( $postQuery ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "simple-events"
    );


    $eventOrderSetting = get_option( 'simple-events-order-by' );
    $orderBy = "meta_value";
    $metaKey = "eventorder";
    $order = "";

    if ( $eventOrderSetting === "eventdateasc" ) {
        $orderBy = "";
        $metaKey = "eventdate";
        $order = "ASC";
    } else if ( $eventOrderSetting === "eventdatedesc" ) {
        $orderBy = "";
        $metaKey = "eventdate";
        $order = "DESC";
    } else if ( $eventOrderSetting === "eventtitleasc" ) {
        $orderBy = "title";
        $metaKey = "";
        $order = "ASC";
    } else if ( $eventOrderSetting === "eventtitledesc" ) {
        $orderBy = "title";
        $metaKey = "";
        $order = "DESC";
    }

    
    $args['orderby'] =  $orderBy;
    $args['meta_key'] = $metaKey;
    $args['order'] = $order;
    

    if ( isset( $postQuery['max'] ) ) {
        $args['posts_per_page'] = ( int ) $postQuery['max'];
    }
    
    $dateLayout = intval( get_option( 'simple-events-date-layout' ) );
    $dateLayoutFormat = "";
    if ( $dateLayout === 1 ) {
        $dateLayoutFormat = 'm/d/Y';
    } else if ( $dateLayout === 2 ) {
        $dateLayoutFormat = 'd/m/Y';
    } else if ( $dateLayout === 3 ) {
         $dateLayoutFormat = 'F j, Y';
    } else if ( $dateLayout === 4 ) {
         $dateLayoutFormat = 'j F Y';
    } else if ( $dateLayout === 5 ) {
         $dateLayoutFormat = 'M d Y';
    } else if ( $dateLayout === 6 ) {
         $dateLayoutFormat = 'd M Y';
    } else if ( $dateLayout === 7 ) {
         $dateLayoutFormat = 'F jS Y';
    } else if ( $dateLayout === 8 ) {
         $dateLayoutFormat = 'F Y';
    }
    
    //Get all events.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="events-container events-page">';
    $pluginContainer .= '<div class="events-container__heading">' . get_option( 'simple-events-leading-text' ) . '</div>';
    $pluginContainer .= '<div class="events-container__inner-wrapper">';
    
    $count = 0;
    foreach ( $posts as $post ) {
        $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
        $price = se_get_event_price( $post );
        $date;
        $startTime = "";
        $endTime = "";
        $eventenddate = "";
        $eventtimes = "";
        if ( se_get_is_multiday( $post ) !== "Multi-day" ) {
            $date = date( $dateLayoutFormat, strtotime( se_get_event_date( $post ) ) );
            if ( se_get_event_starttime( $post ) !== "" ) {
                $startTime = date( "g:i a", strtotime( se_get_event_starttime( $post ) ) );
            }
            if ( se_get_event_eventendtime( $post ) !== "" ) {
                $endTime = date( "g:i a", strtotime( se_get_event_eventendtime( $post ) ) );
            } 
        } else {
            $date = date( $dateLayoutFormat, strtotime( se_get_event_date( $post ) ) ) . " - " . date( $dateLayoutFormat, strtotime( se_get_event_eventenddate( $post ) ) );
            $eventtimes = se_get_event_eventtimes( $post );
        }
        $label = se_get_event_label( $post );
        $location = se_get_location( $post );
        $locationaddress = se_get_locationaddress( $post );
        $organizer = se_get_organizer( $post );
        
        
        $eventCategories = "";
        $categories = get_the_category( $post->ID );

        $categoryNumber = 0;
        $numberOfCategories = count( $categories );
        if ( ! empty( $categories ) ) {
            foreach( $categories as $category ) {
                if ( $categoryNumber < $numberOfCategories - 1 ) {
                    $eventCategories .= $category->name . ", ";
                } else { 
                    $eventCategories .= $category->name . " ";
                }
                $categoryNumber++;
            }
        }
        
        
        $pluginContainer .= '<div class="event">';
        if ( ! empty( $url_thumb ) ) {
            $pluginContainer .= '<div class="event__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat">'
                    . '<a class="event__background-link" href="' . get_permalink( $post->ID ) . '"><span class="sr-only">' . $post->post_title . ' Link</span></a>'
                    . '</div>';
        }
        $pluginContainer .= '<div class="event__title">'
                . '<a class="event__title-link" href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a>'
                . '</div>';
        if ( ! empty( $date ) ) {
            $pluginContainer .= '<div class="event__date">' . $date . '</div> ';
        }
        if ( ! empty( $location ) ) {
            $pluginContainer .= '<div class="event__location">' . $location . '</div> ';
        }
        if ( ! empty( $locationaddress ) ) {
            $pluginContainer .= '<div class="event__location-address">' . $locationaddress . '</div> ';
        }
        if ( ! empty( $organizer ) ) {
            $pluginContainer .= '<div class="event__organizer">' . $organizer . '</div> ';
        }
        if ( se_get_is_multiday( $post ) !== "Multi-day" ) {
            if ( ! empty( $startTime ) && ! empty( $endTime ) ) {
                $pluginContainer .= '<div class="event__times">';
                if ( ! empty( $startTime ) ) {
                    $pluginContainer .= '<div class="event__starttime">from ' . $startTime . '</div>';
                }
                $eventStartAndEndText = "";
                if ( ! empty( $startTime ) && ! empty( $endTime ) ) {
                    $eventStartAndEndText = "&nbsp;- ";
                }
                if ( ! empty( $endTime ) ) {
                    $pluginContainer .= '<div class="event__endtime">' . $eventStartAndEndText . $endTime . '</div>';
                }
                $pluginContainer .= '</div>';
            }
        } else {
            if ( ! empty( $eventtimes ) ) {
                $pluginContainer .= '<div class="event__times">' . $eventtimes . '</div>';
            }
        }        
        if ( ! empty( $price ) ) {
                $pluginContainer .= '<div class="event__price">Cost: ' . $price . '</div>';
        }
        if ( ! empty( $label ) ) {
            $pluginContainer .= '<div class="event__label">' . $label . '</div>';
        }
        if ( ! empty( $eventCategories ) ) {
            $pluginContainer .= '<div class="event__categories">' . $eventCategories . '</div>';
        }
        if ( ! empty( $post->post_content ) ) {
            $pluginContainer .= '<p class="event__content">' . $post->post_content . '</p>';
        }
        $pluginContainer .= '</div>';      
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
