<?php

header( "Content-type: text/css; charset: UTF-8" );

require( '../../../../../wp-load.php' );
include( plugin_dir_path(__FILE__) . "/general-testimonials.php" );


$starColor = get_option( 'general-testimonials-star-color' );
$starSize = get_option( 'general-testimonials-star-size' );

$numberOfTestimonialsPerRow = ( int )( get_option( 'general-testimonials-testimonials-per-row' ) );
$numberOfTestimonialsPerRowTablet = ( int )( get_option( 'general-testimonials-testimonials-per-row' ) );
$testimonialWidthTablet = 50;
$testimonialWidth;
if ( $numberOfTestimonialsPerRow <= 0 ) {
    $numberOfTestimonialsPerRow = 2;
}
if ( $numberOfTestimonialsPerRow < 2 ) {
    $testimonialWidthTablet = 100;
}
if ( $numberOfTestimonialsPerRow > 2 ) {
    $numberOfTestimonialsPerRowTablet = 2;
}
$testimonialWidth = 100/$numberOfTestimonialsPerRow;


$testimonialImageWidthHeight = ( int ) ( get_option( 'general-testimonials-image-width-height' ) );
if ( $testimonialImageWidthHeight <= 0 ) {
    $testimonialImageWidthHeight = 200;
} elseif ( 0 < $testimonialImageWidthHeight && $testimonialImageWidthHeight < 40 ) {
    $testimonialImageWidthHeight = 40;
} elseif ( $testimonialImageWidthHeight > 200 ) {
    $testimonialImageWidthHeight = 200;
}


$generalTestimonialsFloatImageDirection = get_option ( 'general-testimonials-float-image-direction' );
if ( $generalTestimonialsFloatImageDirection === "" || $generalTestimonialsFloatImageDirection !== "right" ) {
    $generalTestimonialsFloatImageDirection = "left";
}

$generalTestimonialsImageTabletPlusMarginLeft = "0";
$generalTestimonialsImageTabletPlusMarginRight = "15px";

if ( $generalTestimonialsFloatImageDirection === "left" ) {
    $generalTestimonialsImageTabletPlusMarginLeft = "0";
    $generalTestimonialsImageTabletPlusMarginRight = "15px";    
} elseif ( $generalTestimonialsFloatImageDirection === "right" ) {
    $generalTestimonialsImageTabletPlusMarginLeft = "15px";
    $generalTestimonialsImageTabletPlusMarginRight = "0";    
}

?>

.testimonials-container__heading { padding-bottom: 0; font-size: 24px; }
.testimonials-container__heading.left { text-align: left; }
.testimonials-container__heading.center { text-align: center; }
.testimonials-container__heading.right { text-align: right; }

.testimonials-container__inner-wrapper { padding-top: 30px; }

.testimonial { padding-bottom: 50px; }
.testimonial__image { display: block; width: <?php echo $testimonialImageWidthHeight; ?>px; height: <?php echo $testimonialImageWidthHeight; ?>px; margin-bottom: 8px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>px; object-fit: cover; }
.testimonial__title { padding-bottom: 12px; font-size: 20px; }
.testimonial__title.left { text-align: left; }
.testimonial__title.center { text-align: center; }
.testimonial__title.right { text-align: right; }
.testimonial__body { }
.testimonial__body.left { text-align: left; }
.testimonial__body.center { text-align: center; }
.testimonial__body.right { text-align: right; }
.testimonial__content { font-size: 16px; padding-bottom: 5px; }
.testimonial__content__entire-content { }
.testimonial__content-wrapper.hide-some .testimonial__content-entire { display: none; }
.testimonial__ellipsis { }
.testimonial__content.open-whole-testimonial .testimonial__ellipsis { display: none; }
.testimonial__ellipsis.can-toggle:hover { cursor: pointer; }
.testimonial__content.open-whole-testimonial { }
.testimonial__content.open-whole-testimonial .testimonial__content-partial { display: none }
.testimonial__content.open-whole-testimonial .testimonial__ellipsis { display: none; }
.testimonial__content.open-whole-testimonial .testimonial__content-entire { display: block; }
.testimonial__provided-name { font-size: 16px; font-weight: bold; }
.testimonial__link { font-size: 16px; font-weight: bold; }
.testimonial__comma { font-size: 16px; }
.testimonial__label { font-size: 16px; font-style: italic; }
.testimonial__location { font-size: 16px; }
.testimonial__date { font-size: 16px; }
.testimonial__rating { <?php if ( ! empty ( $starSize ) ) { echo "font-size: " . $starSize; } ?>px; <?php if ( ! empty ( $starColor ) ) { echo "color: " . $starColor; } ?> } 

.testimonials-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.testimonial__link { font-size: 16px; font-weight: bold; }


/*For individual event pages*/
.general-testimonials-breadcrumbs__breadcrumb { padding-bottom: 20px; }
.general-testimonials-breadcrumbs__breadcrumb-link { display: inline-block; }



@media only screen and (min-width: 700px){

    /* Clearing variable width columns */
    .testimonials-container__inner-wrapper { margin-left: -15px; margin-right: -15px; }
    
    .testimonial { float: left; width: <?php echo $testimonialWidthTablet; ?>%; padding: 0 20px 50px 20px; }
    
    .testimonial__image { float: <?php echo $generalTestimonialsFloatImageDirection; ?>; margin-bottom: 15px; margin-left: <?php echo $generalTestimonialsImageTabletPlusMarginLeft; ?>; margin-right: <?php echo $generalTestimonialsImageTabletPlusMarginRight; ?>; }

}



@media only screen and (min-width: 700px) and (max-width: 1199px){

   /* Clearing variable width columns */
    .testimonials-container__inner-wrapper .testimonial:nth-child(<?php echo $numberOfTestimonialsPerRowTablet; ?>n+1){ content: ""; display: block; clear: both; }  
    
}



@media only screen and (min-width: 1200px){ 
    
    .testimonial { width: <?php echo $testimonialWidth; ?>%; }
    
}
