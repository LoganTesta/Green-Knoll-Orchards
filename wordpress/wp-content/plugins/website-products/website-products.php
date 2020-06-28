<?php
/**
 * Plugin Name: Website Products
 * Plugin URI: https://www.greenknollorchards.com/website-products
 * Version: 1.0
 * Author: Green Knoll Orchards
 * Description: Add website products to your site.  Use the shortcode [website-products] where you want to output products, for example in a WordPress generated admin page or a custom PHP page with WordPress enabled.
 * Author URI: https://www.greenknollorchards.com
 */

defined( 'ABSPATH' ) or exit( "File protected." );


add_action( 'admin_enqueue_scripts', function(){ 
    wp_enqueue_style( 'website-products-admin-styling', plugin_dir_url(__FILE__) . '/assets/css/website-products-admin-styles.css' ); 
});

add_action( 'wp_enqueue_scripts', function(){ 
  wp_enqueue_style( 'website-products-styling', plugin_dir_url(__FILE__) . '/assets/css/website-products-styles.php' ); 
});


function pw_create_product_post_type() {
    register_post_type('website-products',
            array(
                'labels' => array(
                    'name' => __('Website Products'),
                    'singular_name' => __('Website Product')
                ),
                'public' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'custom_fields' ),
                'hierarchical' => false
            )
    );
}
add_action( 'init', 'pw_create_product_post_type' );


/*Add a settings page for the plugin*/

/*Set up the settings page inputs*/
function pw_register_settings() {
    add_option( 'website-products-leading-text', 'Some text' );
    add_option( 'website-products-image-width-height', "150" );
    add_option( 'website-products-border-radius', "45" );
    add_option( 'website-products-float-image-direction', "left" );
    add_option( 'website-products-products-per-row', "2" );
    add_option( 'website-products-number-to-display', "" );

    register_setting( 'website-products-settings-group', 'website-products-leading-text', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-image-width-height', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-border-radius', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-float-image-direction', 'pw_validatetextfield' );
    register_setting( 'website-products-settings-group', 'website-products-products-per-row', 'pw_validatetextfield' );  
    register_setting( 'website-products-settings-group', 'website-products-number-to-display', 'pw_validatetextfield' );  
}
add_action( 'admin_init', 'pw_register_settings');


/*Set up the settings page*/
function pw_add_options_page() {
    add_options_page( 'Page Title', 'Website Products Settings', 'manage_options', 'website-products', 'pw_generate_settings_page' );
}
add_action( 'admin_menu', 'pw_add_options_page' );


function pw_validatetextfield( $input ) {
    $updatedField = sanitize_text_field( $input );
    return $updatedField;
}

function pw_generate_settings_page() {
    ?>
    <h1 class="website-products__plugin-title">Website Products Settings</h1>
    <?php screen_icon(); ?>
    <form class="products-settings-form" method="post" action="options.php">
        <?php settings_fields( 'website-products-settings-group' ); ?>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-leading-text">Products Leading Text</label>
                <input id="websiteProductsLeadingText" class="admin-input-container__input website-products-leading-text" name="website-products-leading-text" type="text" value="<?php echo get_option( 'website-products-leading-text' ); ?>" />
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-image-width-height">Image Width, Height (80-400px)</label>
                <input id="websiteProductsNumberToDisplay" class="admin-input-container__input smaller website-products-image-width-height" name="website-products-image-width-height" type="number" value="<?php echo get_option( 'website-products-image-width-height' ); ?>" min="80" max="400" /><span class="admin-input-container__trailing-text">px</span>
            </div>
            <div class="admin-input-container">
                <label class="admin-input-container__label" for="website-products-border-radius">Image Border Radius</label>
                <input id="websiteProductsImageWidthHeight" class="admin-input-container__input website-products-border-radius" name="website-products-border-radius" type="text" value="<?php echo get_option( 'website-products-border-radius' ); ?>" /><span class="admin-input-container__trailing-text">px</span>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Float Image Direction</span>         
                <input id="websiteProductsFloatImageDirection0" class="website-products-float-image-direction" name="website-products-float-image-direction" type="radio" value="left" <?php if(get_option( 'website-products-float-image-direction' ) === "left") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsFloatImageDirection0">Left</label>
                <input id="websiteProductsFloatImageDirection1" class="website-products-float-image-direction" name="website-products-float-image-direction" type="radio" value="right" <?php if(get_option( 'website-products-float-image-direction' ) === "right") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsFloatImageDirection1">Right</label>
            </div>
            <div class="admin-input-container">
                <span class="admin-input-container__label">Number of Products Per Row</span>         
                <input id="websiteProductsProductsPerRow0" class="website-products-products-per-row" name="website-products-products-per-row" type="radio" value="2" <?php if(get_option( 'website-products-products-per-row' ) === "2") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPerRow0">2</label>
                <input id="websiteProductsProductsPerRow1" class="website-products-products-per-row" name="website-products-products-per-row" type="radio" value="3" <?php if(get_option( 'website-products-products-per-row' ) === "3") { echo 'checked="checked"'; } ?> />
                <label class="admin-input-container__label--right" for="websiteProductsProductsPerRow1">3</label>
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
    add_meta_box('custom-metabox', __('Product Information'), 'pw_url_custom_metabox', 'website-products', 'side', 'low');
}
add_action( 'admin_init', 'pw_add_custom_metabox_info' );


//Admin area HTML and logic 
function pw_url_custom_metabox() {
    global $post;
    
    /*Gather the input data, sanitize it, and update the database.*/
    $productprice = sanitize_text_field( get_post_meta( $post->ID, 'productprice', true ) );
    update_post_meta( $post->ID, 'productprice', $productprice );
    $productlabel = sanitize_text_field( get_post_meta( $post->ID, 'productlabel', true ) );
    update_post_meta( $post->ID, 'productlabel', $productlabel );
    $producturl = sanitize_text_field( get_post_meta( $post->ID, 'producturl', true ) );
    update_post_meta( $post->ID, 'producturl', $producturl );
    $productorder = sanitize_text_field( get_post_meta( $post->ID, 'productorder', true ) );
    if( isset( $productorder ) === false || $productorder === "" ) {
        $productorder = "n/a";
    }
    update_post_meta( $post->ID, 'productorder', $productorder );


    $errorsprice = "";
    if( isset( $errorsprice ) ){
        echo $errorsprice;
    }
    
    $errorslabel = "";
    if( isset( $errorslabel ) ){
        echo $errorslabel;
    }
   
    $errorslink = "";
    if ( !preg_match( "/http(s?):\/\//", $producturl ) && $producturl !== "" ) {
        $errorslink = "This URL is not valid";
        $producturl = "http://";
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
        <label for="productprice">Price:<br />
            <input id="productprice" name="productprice" size="37" value="<?php if( isset($productprice ) ) { echo $productprice; } ?>" />
        </label>
    </p>
    <p>
        <label for="productlabel">Product Label:<br />
            <input id="productlabel" name="productlabel" size="37" value="<?php if( isset( $productlabel ) ) { echo $productlabel; } ?>" />
        </label>
    </p>
    <p>
        <label for="producturl">Related URL:<br />
            <input id="producturl" size="37" name="producturl" value="<?php if( isset( $producturl ) ) { echo $producturl; } ?>" />
        </label>
    </p>
        <p>
        <label for="productorder">Product Order:<br />
            <input id="productorder" size="37" type="number" min="1" name="productorder" value="<?php if( isset($productorder) ) { echo $productorder; } ?>" />
        </label>
    </p>
 <?php 
}


//Save user provided field data.
function pw_save_custom_productprice( $post_id ) {
    global $post;
    
    if( isset( $_POST['productprice']) ) {
        update_post_meta( $post->ID, 'productprice', $_POST['productprice'] );
    }
}
add_action( 'save_post', 'pw_save_custom_productprice' );

function pw_get_productprice( $post ) {
    $productprice = get_post_meta( $post->ID, 'productprice', true );
    return $productprice;
}


function pw_save_custom_productlabel( $post_id ) {
    global $post;
    
    if( isset($_POST['productlabel']) ) {
        update_post_meta( $post->ID, 'productlabel', $_POST['productlabel'] );
    }
}
add_action( 'save_post', 'pw_save_custom_productlabel' );

function pw_get_productlabel( $post ) {
    $productlabel = get_post_meta( $post->ID, 'productlabel', true );
    return $productlabel;
}


function pw_save_custom_url( $post_id ) {
    global $post;
    
    if( isset($_POST['producturl']) ) {
        update_post_meta( $post->ID, 'producturl', $_POST['producturl'] );
    }
}
add_action( 'save_post', 'pw_save_custom_url' );

function pw_get_url( $post ) {
    $producturl = get_post_meta( $post->ID, 'producturl', true );
    return $producturl;
}


function pw_save_custom_order( $post_id ) {
    global $post;
    
    if( isset($_POST['productorder']) ) {
        update_post_meta( $post->ID, 'productorder', $_POST['productorder'] );
    }
}
add_action( 'save_post', 'pw_save_custom_order' );

function pw_get_order( $post ) {
    $productorder = get_post_meta( $post->ID, 'productorder', true );
    return $productorder;
}



/*Adjust admin columns for Products*/
if ( $_GET[ 'post_type' ] === "website-products" ){
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
        if( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array(100, 100) );
        }
        if ( 'productprice' === $column ) {
            echo get_post_meta( $post_id, 'productprice', true);
        }
        if( 'content' === $column ) {
            echo get_post_field( 'post_content', $post_id );
        }
        if( 'order' === $column ) {
            echo get_post_meta( $post_id, 'productorder', true );
        }
    }


    //Determine order of products shown in admin*/
    add_action( 'pre_get_posts', 'pw_custom_post_order_sort' );
    function pw_custom_post_order_sort( $query ) { 
        if ( $query->is_main_query() && $_GET[ 'post_type' ] === "website-products" ){
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'meta_key', 'productorder' );
            $query->set( 'order', 'ASC' );
        }
    }
}


//Register the shortcode so we can show products.
function pw_load_products( $a ) {
    $args = array(
        "post_type" => "website-products"
    );

    if ( isset( $a['rand'] ) && $a['rand'] == true ) {
        $args['orderby'] = 'rand';
    } else {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = 'productorder';
        $args['order'] = 'ASC';
    }

    if ( isset( $a['max']) ) {
        $args['posts_per_page'] = (int) $a['max'];
    }

    //Get all products.
    $posts = get_posts($args);
    echo '<div class="products-container">';
    echo '<h3 class="products-container__heading">' . get_option( 'website-products-leading-text' ) . '</h3>';
    echo '<div class="products-container__inner-wrapper">';
    
    $numberToDisplay = get_option( 'website-products-number-to-display' );
    if( $numberToDisplay === "" ) {
        $numberToDisplay = -1;
    }
    $numberToDisplay = (int) $numberToDisplay;
    $count = 0;
    foreach ($posts as $post) {
        if( $count < $numberToDisplay  || $numberToDisplay === -1){
            $url_thumb = get_the_post_thumbnail_url( $post->ID, 'medium_square_crop' ); 
            $url_altText = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
            $price = pw_get_productprice( $post );
            $label = pw_get_productlabel( $post );
            $link = pw_get_url( $post );
            echo '<div class="product">';
            if ( !empty( $url_thumb ) ) {
                echo '<img class="product__image" src="' . $url_thumb . '" alt="' . $url_altText . '" />';
            }
            echo '<h4 class="product__title">' . $post->post_title . '</h4>';
            if ( !empty( $post->post_content ) ) {
                echo '<p class="product__content">' . $post->post_content . '</p>';
            }
            if ( !empty( $price ) ) {
                if (!empty( $link )) {
                    echo '<span class="product__price"><a class="product__link" href="' . $link . '" target="__blank">' . $price . '</a></span>';
                } else {
                    echo '<span class="product__price">' . $price . '</span>';
                }
            }
            if ( !empty( $label ) ) {
                echo '<span class="product__label">, ' . $label . '</span>';
            }
            echo '</div>';
        }
        $count++;
    }
    echo '</div>';
    echo '</div>';
}
add_shortcode( "website_products", "pw_load_products" );
add_filter( 'widget_text', 'do_shortcode' );