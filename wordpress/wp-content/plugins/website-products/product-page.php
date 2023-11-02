<?php

/* Generic layout for the custom post type for this plugin. */

get_header();
?>

    <div class="website-products-product">
        <h1 class="website-products-product__title"><?php echo get_the_title(); ?></h1>
        <img class="website-products-product__image" src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), "full" ); ?>" 
             alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt' , true ); ?>" />
        <div class="website-products-product__content"><?php the_content(); ?></div>
    </div>

<?php
get_footer();
