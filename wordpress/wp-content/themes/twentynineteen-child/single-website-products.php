<?php

/* Generic layout for the custom post type for this plugin. */

get_header();
?>

    <div class="website-products website-products-product">
        <div class="website-products-product__inner-wrapper">
            <div class="website-products-breadcrumbs">
                <div class="website-products-breadcrumbs__breadcrumb">
                    <a class="website-products-breadcrumbs__breadcrumb-link" href="<?php echo get_option( "website-products-products-page" ); ?>">Back to <?php echo get_option( "website-products-leading-text" ); ?></a>
                </div>
            </div>
            <img class="website-products-product__image" src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), "full" ); ?>" 
                 alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt' , true ); ?>" />
            <h1 class="website-products-product__title"><?php echo get_the_title(); ?></h1>
            <div class="website-products-product__price"><?php echo pw_get_productprice( $post ); ?></div>
            <div class="website-products-product__label"><?php echo pw_get_productlabel( $post ); ?></div>
            <div class="website-products-product__content"><?php the_content(); ?></div>
        </div>
    </div>

<?php
get_footer();
