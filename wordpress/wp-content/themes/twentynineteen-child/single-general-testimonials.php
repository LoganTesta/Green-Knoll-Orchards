<?php

/* Generic layout for the custom post type for this plugin. */

get_header();
?>

    <div class="general-testimonials general-testimonials-testimonial">
        <div class="general-testimonials-testimonial__inner-wrapper">
            <div class="general-testimonials-breadcrumbs">
                <div class="general-testimonials-breadcrumbs__breadcrumb">
                    <a class="general-testimonials-breadcrumbs__breadcrumb-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home page</a>
                </div>
            </div>
            <img class="general-testimonials-testimonial__image" src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), "full" ); ?>" 
                 alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt' , true ); ?>" />
            <h1 class="general-testimonials-testimonial__title"><?php echo get_the_title(); ?></h1>
            <div class="general-testimonials-testimonial__content"><?php the_content(); ?></div>
            <div class="general-testimonials-testimonial__provided-name"><?php echo gt_get_testimonialprovidedname( $post ); ?></div>
            <div class="general-testimonials-testimonial__label"><?php echo gt_get_testimoniallabel( $post ); ?></div>
            <div class="general-testimonials-testimonial__location"><?php echo gt_get_testimoniallocation( $post ); ?></div>
            <div class="general-testimonials-testimonial__url"><?php echo gt_get_url( $post ); ?></div>
            <div class="general-testimonials-testimonial__date"><?php echo gt_get_testimonialdate( $post ); ?></div>
            <div class="general-testimonials-testimonial__rating"><?php echo gt_get_testimonialrating( $post ); ?></div>
        </div>
    </div>

<?php
get_footer();
