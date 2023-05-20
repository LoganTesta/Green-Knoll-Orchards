<?php

header( "Content-type: text/css; charset: UTF-8" );

require( '../../../../../wp-load.php' );
include( plugin_dir_path(__FILE__) . "/general-testimonials.php" );


$numberOfTestimonialsPerRow = (int)( get_option( 'general-testimonials-testimonials-per-row' ) );
$numberOfTestimonialsPerRowTablet = (int)( get_option( 'general-testimonials-testimonials-per-row' ) );
$testimonialWidthTablet = 50;
$testimonialWidth;
if ( $numberOfTestimonialsPerRow <= 0 ) {
    $numberOfTestimonialsPerRow = 2;
}
if ( $numberOfTestimonialsPerRow < 2) {
    $testimonialWidthTablet = 100;
}
if ( $numberOfTestimonialsPerRow > 2 ) {
    $numberOfTestimonialsPerRowTablet = 2;
}
$testimonialWidth = 100/$numberOfTestimonialsPerRow;


$testimonialImageWidthHeight = (int)( get_option( 'general-testimonials-image-width-height' ) );
if ( $testimonialImageWidthHeight <= 0 ) {
    $testimonialImageWidthHeight = 150;
} elseif ( 0 < $testimonialImageWidthHeight && $testimonialImageWidthHeight < 60 ) {
    $testimonialImageWidthHeight = 60;
} elseif ( $testimonialImageWidthHeight > 150 ) {
    $testimonialImageWidthHeight = 150;
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
} elseif ( $generalTestimonialsFloatImageDirection === "right" ){
    $generalTestimonialsImageTabletPlusMarginLeft = "5px";
    $generalTestimonialsImageTabletPlusMarginRight = "0";    
}

?>

.testimonials-container__heading { padding-bottom: 0; text-align: center; }
.testimonials-container__inner-wrapper { padding-top: 30px; }

.testimonial { padding-bottom: 50px; }
.testimonial__image { display: block; width: <?php echo $testimonialImageWidthHeight; ?>px; height: <?php echo $testimonialImageWidthHeight; ?>px; margin-bottom: 8px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>px; }
.testimonial__title { padding-bottom: 12px; }
.testimonial__content { padding-bottom: 5px; }
.testimonial__provided-name { font-size: 17px; font-weight: bold; }
.testimonial__comma { font-size: 17px; }
.testimonial__label { font-size: 17px; font-style: italic; }

.testimonials-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.testimonial__link { font-size: 17px; font-weight: bold; }



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
