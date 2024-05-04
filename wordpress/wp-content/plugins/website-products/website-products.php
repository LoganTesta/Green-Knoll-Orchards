<?php
/**
 * Plugin Name: Website Products
 * Plugin URI: https://www.greenknollorchards.com/website-products
 * Version: 1.0
 * Author: Green Knoll Orchards
 * Description: Add website products to your site, with layout and styling customizations.
 * Author URI: https://www.greenknollorchards.com
 */

defined( 'ABSPATH' ) or exit( "File protected." );


add_action( 'admin_enqueue_scripts', function() { 
    wp_enqueue_style( 'website-products-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/website-products-admin-styles.css' ); 
} );

add_action( 'wp_enqueue_scripts', function() { 
  wp_enqueue_style( 'website-products-styling', plugin_dir_url(__FILE__) . '/assets/css/website-products-styles.php' ); 
} );


function pw_create_product_post_type() {
    register_post_type( 'website-products',
            array(
                'labels' => array(
                    'name' => __( 'Website Products' ),
                    'singular_name' => __( 'Website Product' )
                ),
                'public' => true,
                'show_in_menu' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'custom_fields' ),
                'hierarchical' => false
            )
    );
}
add_action( 'init', 'pw_create_product_post_type' );


/*Set up the settings page*/
function pw_admin_menu() {
    add_submenu_page( 'edit.php?post_type=website-products', 'Settings', 'Settings', 'manage_options', 'website-products', 'pw_generate_settings_page' );
}
add_action( 'admin_menu', 'pw_admin_menu' );


/*Set up the settings page inputs*/
function pw_register_settings() {
    add_option( 'website-products-leading-text', 'Our Products' );
    add_option( 'website-products-leading-text-index', 'Our Products' );
    add_option( 'website-products-products-page', '' );
    add_option( 'website-products-image-width-height', "240" );
    add_option( 'website-products-border-radius', "5" );
    add_option( 'website-products-products-per-row', "3" );
    add_option( 'website-products-products-page-products-per-row', "3" );
    add_option( 'website-products-number-to-display', "" );

    register_setting( 'website-products-settings-group', 'website-products-leading-text', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-leading-text-index', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-products-page', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-image-width-height', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-border-radius', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-products-per-row', 'pw_validatetextfield' );  
    register_setting( 'website-products-settings-group', 'website-products-products-page-products-per-row', 'pw_validatetextfield' ); 
    register_setting( 'website-products-settings-group', 'website-products-number-to-display', 'pw_validatetextfield' );  
}
add_action( 'admin_init', 'pw_register_settings' );


function pw_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}


function pw_generate_settings_page() {
    ?>
    <h1 class="website-products__plugin-title">Website Products Settings</h1>
    <div class="website-products__instructions">
        <p>Add website products to your site, with layout and styling customizations.</p>
        <p>Use the shortcode [website_products] where you want to output products.</p>
        <p>There is also a second shortcode, [website_products_index], for when when you wish to create products on another page such as the index.  This different layout 
            includes links to your products page, and in the plugin settings you can set a different header text too. </p>
    </div>
    <form class="products-settings-form" method="post" action="options.php">
        <?php settings_fields( 'website-products-settings-group' ); ?>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-leading-text">Products Leading Text</label>
                <input id="websiteProductsLeadingText" class="admin-input-container__input website-products-leading-text" name="website-products-leading-text" type="text" value="<?php echo get_option( 'website-products-leading-text' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-leading-text-index">Index/Additional Page Products Text</label>
                <input id="websiteProductsLeadingTextIndex" class="admin-input-container__input website-products-leading-text-index" name="website-products-leading-text-index" type="text" value="<?php echo get_option( 'website-products-leading-text-index' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-products-page">Products Page (page's URL Slug)</label>
                <input id="websiteProductsProductsPage" class="admin-input-container__input website-products-products-page" name="website-products-products-page" type="text" value="<?php echo get_option( 'website-products-products-page' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-image-width-height">Max Image Height (80-400px)</label>
                <input id="websiteProductsNumberToDisplay" class="admin-input-container__input smaller website-products-image-width-height" name="website-products-image-width-height" type="number" value="<?php echo get_option( 'website-products-image-width-height' ); ?>" min="80" max="400" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 240px</span>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-border-radius">Image Border Radius</label>
                <input id="websiteProductsImageWidthHeight" class="admin-input-container__input website-products-border-radius" name="website-products-border-radius" type="text" value="<?php echo get_option( 'website-products-border-radius' ); ?>" />
                <span class="admin-input-container__trailing-text">px</span>
                <span class="admin-input-container__default-settings-text">Default: 5px</span>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Products Per Row</span>         
                <input id="websiteProductsProductsPerRow0" class="website-products-products-per-row" name="website-products-products-per-row" type="radio" value="2" <?php if ( get_option( 'website-products-products-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPerRow0">2</label>
                <input id="websiteProductsProductsPerRow1" class="website-products-products-per-row" name="website-products-products-per-row" type="radio" value="3" <?php if ( get_option( 'website-products-products-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPerRow1">3</label>
                <input id="websiteProductsProductsPerRow2" class="website-products-products-per-row" name="website-products-products-per-row" type="radio" value="4" <?php if ( get_option( 'website-products-products-per-row' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPerRow2">4</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Products Per Row Products Page</span>         
                <input id="websiteProductsProductsPageProductsPerRow0" class="website-products-products-page-products-per-row" name="website-products-products-page-products-per-row" type="radio" value="2" <?php if ( get_option( 'website-products-products-page-products-per-row' ) === "2" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPageProductsPerRow0">2</label>
                <input id="websiteProductsProductsPageProductsPerRow1" class="website-products-products-page-products-per-row" name="website-products-products-page-products-per-row" type="radio" value="3" <?php if ( get_option( 'website-products-products-page-products-per-row' ) === "3" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPageProductsPerRow1">3</label>
                <input id="websiteProductsProductsPageProductsPerRow2" class="website-products-products-page-products-per-row" name="website-products-products-page-products-per-row" type="radio" value="4" <?php if ( get_option( 'website-products-products-page-products-per-row' ) === "4" ) { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPageProductsPerRow2">4</label>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-number-to-display">Products to Display (Empty: display all)</label>
                <input id="websiteProductsNumberToDisplay" class="admin-input-container__input smaller website-products-number-to-display" name="website-products-number-to-display" type="number" value="<?php echo get_option( 'website-products-number-to-display' ); ?>" />
            </div>
            <?php submit_button(); ?>
        </form>
    <?php
}


function pw_add_custom_metabox_info() {
    add_meta_box( 'custom-metabox', __( 'Product Information' ), 'pw_url_custom_metabox', 'website-products', 'side', 'low' );
}
add_action( 'admin_init', 'pw_add_custom_metabox_info' );


//Admin area HTML and logic 
function pw_url_custom_metabox() {
    global $post;
    
    wp_nonce_field( 'settings_group_nonce_save', 'settings_group_nonce' );
    
    /*Gather the input data, sanitize it, and update the database.*/
    $productprice = sanitize_text_field( get_post_meta( $post->ID, 'productprice', true ) );
    update_post_meta( $post->ID, 'productprice', $productprice );
    $productlabel = sanitize_text_field( get_post_meta( $post->ID, 'productlabel', true ) );
    update_post_meta( $post->ID, 'productlabel', $productlabel );
    $productorder = sanitize_text_field( get_post_meta( $post->ID, 'productorder', true ) );
    if ( isset( $productorder ) === false || $productorder === "" ) {
        $productorder = "n/a";
    }
    update_post_meta( $post->ID, 'productorder', $productorder );


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
    <p>
        <label for="productprice">Price:<br />
            <input id="productprice" name="productprice" size="37" value="<?php if ( isset( $productprice ) ) { echo $productprice; } ?>" />
        </label>
    </p>
    <p>
        <label for="productlabel">Product Label:<br />
            <input id="productlabel" name="productlabel" size="37" value="<?php if ( isset( $productlabel ) ) { echo $productlabel; } ?>" />
        </label>
    </p>
    <p>
    </p>
        <p>
        <label for="productorder">Product Order:<br />
            <input id="productorder" size="37" type="number" min="1" name="productorder" value="<?php if ( isset( $productorder ) ) { echo $productorder; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function pw_save_custom_productprice( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['productprice'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'productprice', $_POST['productprice'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'pw_save_custom_productprice' );

function pw_get_productprice( $post ) {
    $productprice = get_post_meta( $post->ID, 'productprice', true );
    return $productprice;
}


function pw_save_custom_productlabel( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['productlabel'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'productlabel', $_POST['productlabel'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'pw_save_custom_productlabel' );

function pw_get_productlabel( $post ) {
    $productlabel = get_post_meta( $post->ID, 'productlabel', true );
    return $productlabel;
}


function pw_save_custom_order( $post_id ) {
    global $post;
    
    $nonceToVerify = check_admin_referer( 'settings_group_nonce_save', 'settings_group_nonce' );
    if ( isset( $_POST['productorder'] ) ) {
        if ( $nonceToVerify ) {
            update_post_meta( $post->ID, 'productorder', $_POST['productorder'] );
        } else {
            wp_die( "Invalid wp nonce provided", array( 'response' => 403, ) );
        }
    }
}
add_action( 'save_post', 'pw_save_custom_order' );

function pw_get_order( $post ) {
    $productorder = get_post_meta( $post->ID, 'productorder', true );
    return $productorder;
}



/*Adjust admin columns for Products*/
if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === "website-products" ) {
    add_filter( 'manage_posts_columns', 'pw_setup_adjust_admin_columns' );
    function pw_setup_adjust_admin_columns( $columns ) {
        $columns = array(
            'cb' => $columns['cb'],
            'title' => __( 'Title' ),
            'image' => __( 'Image' ), 
            'content' => __( 'Product Text' ),
            'productprice' => __( 'Product Price', 'pw' ),
            'order' => __( 'Order' ),
            'date' => __( 'Date' ),
        );   
        return $columns;
    }


    //Add images and other data to posts admin
    add_action( 'manage_posts_custom_column', 'pw_add_data_to_admin_columns', 10, 2 );
    function pw_add_data_to_admin_columns( $column, $post_id ) {
        if ( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
        }
        if ( 'productprice' === $column ) {
            echo get_post_meta( $post_id, 'productprice', true );
        }
        if ( 'content' === $column ) {
            echo get_post_field( 'post_content', $post_id );
        }
        if ( 'order' === $column ) {
            echo get_post_meta( $post_id, 'productorder', true );
        }
    }


    //Determine order of products shown in admin*/
    add_action( 'pre_get_posts', 'pw_custom_post_order_sort' );
    function pw_custom_post_order_sort( $query ) { 
        if ( $query->is_main_query() && $_GET[ 'post_type' ] === "website-products" ) {
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'meta_key', 'productorder' );
            $query->set( 'order', 'ASC' );
        }
    }
}


//Register the shortcode so we can show products on a different page, most likely the index page.
function pw_load_products_index( $postQuery ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "website-products"
    );

    if ( isset( $postQuery['rand'] ) && $postQuery['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'productorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $postQuery['max'] ) ) {
        $args['posts_per_page'] = ( int ) $postQuery['max'];
    }

    //Get all products.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="website-products products-container index">';
    $pluginContainer .= '<div class="products-container__heading index">' . get_option( 'website-products-leading-text-index' ) . '</div>';
    $pluginContainer .= '<div class="products-container__inner-wrapper">';

    $numberToDisplay = get_option( 'website-products-products-per-row' );
    if ( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = ( int ) $numberToDisplay;
    $count = 0;
    foreach ( $posts as $post ) {
        if ( $count < $numberToDisplay  || $numberToDisplay === -1 ) {
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
            $price = pw_get_productprice( $post );
            $label = pw_get_productlabel( $post );
            $pluginContainer .= '<div class="product">';
            $pluginContainer .= '<div class="product__title"><a class="product__title-link" href="' . get_option( 'website-products-products-page' ) . '">' . $post->post_title . '</a></div>';
            if ( ! empty( $url_thumb ) ) {
                $pluginContainer .= '<div class="product__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat">'
                    . '<a class="product__background-link" href="' . get_option( 'website-products-products-page' ) . '"><span class="sr-only">' . $post->post_title . ' Link</span></a>'
                    . '</div>';
            }
            if ( ! empty( $post->post_content ) ) {
                
            }
            $pluginContainer .= '</div>';
        }
        $count++;
    }
    $pluginContainer .= '</div>';
    $pluginContainer .= '</div>';
    
    return $pluginContainer;
}


//Register the shortcode so we can show products.
function pw_load_products( $postQuery ) {
    $pluginContainer = "";
    $args = array(
        "post_type" => "website-products"
    );

    if ( isset( $postQuery['rand'] ) && $postQuery['rand'] === true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'productorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $postQuery['max'] ) ) {
        $args['posts_per_page'] = ( int ) $postQuery['max'];
    }

    //Get all products.
    $posts = get_posts( $args );
    $pluginContainer .= '<div class="website-products products-container products-page">';
    $pluginContainer .= '<div class="products-container__heading">' . get_option( 'website-products-leading-text' ) . '</div>';
    $pluginContainer .= '<div class="products-container__inner-wrapper">';
    
    $numberToDisplay = get_option( 'website-products-number-to-display' );
    if ( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = ( int ) $numberToDisplay;
    $count = 0;
    foreach ( $posts as $post ) {
        if ( $count < $numberToDisplay || $numberToDisplay === -1 ) {
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' ); 
            $price = pw_get_productprice( $post );
            $label = pw_get_productlabel( $post );
            $pluginContainer .= '<div class="product">';
            $pluginContainer .= '<div class="product__title"><a class="product__title-link" href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a></div>';            
            if ( ! empty( $url_thumb ) ) {
                $pluginContainer .= '<div class="product__background" style="background: url(' . $url_thumb . ') 0% 0%/cover no-repeat">'
                        . '<a class="product__background-link" href="' . get_permalink( $post->ID ) . '"><span class="sr-only">' . $post->post_title . ' Link</span></a>'
                        . '</div>';
            }
            if ( ! empty( $price ) ) {
                    $pluginContainer .= '<div class="product__price">' . $price . '</div>';
            }
            if ( ! empty( $label ) ) {
                $pluginContainer .= '<div class="product__label">' . $label . '</div>';
            }
            if ( ! empty( $post->post_content ) ) {
                $pluginContainer .= '<p class="product__content">' . $post->post_content . '</p>';
            }
            $pluginContainer .= '</div>';
        }
        $count++;
    }
    $pluginContainer .= '</div>';
    $pluginContainer .= '</div>';
    
    return $pluginContainer;
}


add_shortcode( "website_products_index", "pw_load_products_index" );
add_filter( 'widget_text', 'do_shortcode' );

add_shortcode( "website_products", "pw_load_products" );
add_filter( 'widget_text', 'do_shortcode' );
