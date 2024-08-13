<?php

/* Generic layout for the custom post type for this plugin. */

get_header();


$ratingScale = get_option( 'general-testimonials-rating-scale' );
$dateLayout = intval( get_option( 'general-testimonials-date-layout' ) );
$dateLayoutFormat = "";
if ( $dateLayout === 1 ) {
    $dateLayoutFormat = 'F j, Y';
} else if ( $dateLayout === 2 ) {
    $dateLayoutFormat = 'F Y';
} else if ( $dateLayout === 3 ) {
     $dateLayoutFormat = 'd M Y';
} 

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


if ( $ratingScale === "0-4" ) {
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

?>

    <div class="general-testimonials general-testimonials-testimonial ">
        <div class="general-testimonials-testimonial__inner-wrapper">
            <div class="general-testimonials-breadcrumbs">
                <div class="general-testimonials-breadcrumbs__breadcrumb">
                    <a class="general-testimonials-breadcrumbs__breadcrumb-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span>&#8592</span> Back to home page</a>
                </div>
            </div>
            <?php
            $testimonialContainer .= '<div class="single-testimonial">';
            if ( ! empty( $url_thumb ) ) {
                $testimonialContainer .= '<img class="testimonial__image" src="' . $url_thumb . '" alt="' . $url_altText . '" />';
            }
            $testimonialContainer .= '<h4 class="testimonial__title">' . $post->post_title . '</h4>';
            $testimonialContainer .= '<div class="testimonial__body">';
                if ( ! empty( $post->post_content ) ) {
                    $testimonialContainer .= '<p class="testimonial__content">' . $post->post_content . '</p>';
                }
                if ( ! empty( $providedName ) ) {
                    if ( ! empty( $link ) ) {
                        $testimonialContainer .= '<span class="testimonial__provided-name"><a class="testimonial__link" href="' . $link . '" target="__blank">' . $providedName . '</a></span>';
                    } else {
                        $testimonialContainer .= '<span class="testimonial__provided-name">' . $providedName . '</span>';
                    }
                }
                if ( ! empty( $label ) ) {
                    if ( ! empty( $providedName ) ) {
                        $testimonialContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__label"> ' . $label . '</span>';
                    } else {
                        $testimonialContainer .= '<span class="testimonial__label">' . $label . '</span>';
                    }
                }
                if ( ! empty( $testimonialLocation ) ) { 
                    if ( ! empty( $providedName ) || ! empty( $label ) ) {
                        $testimonialContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__location"> ' . $testimonialLocation . '</span>';
                    } else {
                        $testimonialContainer .= '<span class="testimonial__location">' . $testimonialLocation . '</span>';
                    }
                }
                if ( ! empty( $testimonialDate ) ) { 
                    if ( ! empty( $providedName ) || ! empty( $label ) || ! empty( $testimonialLocation ) ) {
                        $testimonialContainer .= '<span class="testimonial__comma">,</span><span class="testimonial__date"> ' . $testimonialDate . '</span>';
                    } else {
                        $testimonialContainer .= '<span class="testimonial__date">' . $testimonialDate . '</span>';
                    }
                }    
                if ( ! empty( $testimonialRating ) ) {
                    $testimonialContainer .= '<div class="testimonial__rating">' . $testimonialRating . '</div>';
                }
            $testimonialContainer .= '<div class="clear-both"></div>'; 
            $testimonialContainer .= '</div>'; 
            $testimonialContainer .= '</div>'; 
            
            echo $testimonialContainer;
            ?>
        </div>
    </div>

<?php
get_footer();
