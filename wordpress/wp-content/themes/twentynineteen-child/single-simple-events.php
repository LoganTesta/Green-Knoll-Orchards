<?php

/* Generic layout for the custom post type for this plugin. */

get_header();
?>

    <div class="simple-events simple-events-event">
        <div class="simple-events-event__inner-wrapper">
            <div class="simple-events-breadcrumbs">
                <div class="simple-events-breadcrumbs__breadcrumb">
                    <a class="simple-events-breadcrumbs__breadcrumb-link" href="<?php echo get_option( "simple-events-events-page" ); ?>">Back to <?php echo get_option( "simple-events-leading-text" ); ?></a>
                </div>
            </div>
            <img class="simple-events-event__image" src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), "full" ); ?>" 
                 alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt' , true ); ?>" />
            <h1 class="simple-events-event__title"><?php echo get_the_title(); ?></h1>
            <div class="simple-events-event__price"><?php echo se_get_event_price( $post ); ?></div>
            <div class="simple-events-event__label"><?php echo se_get_event_label( $post ); ?></div>
            <div class="simple-events-event__content"><?php the_content(); ?></div>
        </div>
    </div>

<?php
get_footer();
