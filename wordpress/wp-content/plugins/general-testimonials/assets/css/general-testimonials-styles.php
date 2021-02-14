
<?php

header ( "Content-type: text/css; charset: UTF-8" );

require ( '../../../../../wp-load.php' );
include ( plugin_dir_path(__FILE__) . "/general-testimonials.php" );


$numberOfTestimonialsPerRow = (int)( get_option( 'general-testimonials-testimonials-per-row' ) );
if ( $numberOfTestimonialsPerRow <= 0 ) {
    $numberOfTestimonialsPerRow = 2;
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

.testimonial { padding-bottom: 40px; }
.testimonial__image { display: block; width: <?php echo $testimonialImageWidthHeight; ?>px; height: <?php echo $testimonialImageWidthHeight; ?>px; margin-bottom: 15px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'general-testimonials-border-radius' ); ?>px; }
.testimonial__title { }
.testimonial__content { padding-bottom: 5px; }
.testimonial__provided-name { font-size: 17px; font-weight: bold; }
.testimonial__comma { font-size: 17px; }
.testimonial__label { font-size: 17px; font-style: italic; }

.testimonial:last-of-type { padding-bottom: 0; }
.testimonials-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.testimonial__link { font-size: 17px; font-weight: bold; }



@media only screen and (min-width: 700px){
     /* Clearing variable width columns */
    .testimonials-container__inner-wrapper .testimonial:nth-child(<?php echo $numberOfTestimonialsPerRow; ?>n+1){ content: ""; display: block; clear: both; }  

    
    .testimonial { float: left; width: <?php echo $testimonialWidth; ?>%; padding: 0 20px 15px 20px; }
    
    .testimonial__image { float: <?php echo $generalTestimonialsFloatImageDirection; ?>; margin-left: <?php echo $generalTestimonialsImageTabletPlusMarginLeft; ?>; margin-right: <?php echo $generalTestimonialsImageTabletPlusMarginRight; ?>; }
    
    .testimonial:nth-of-type(<?php echo $numberOfTestimonialsPerRow; ?>n+1) { padding-left: 0; }
    .testimonial:nth-of-type(<?php echo $numberOfTestimonialsPerRow; ?>n+<?php echo $numberOfTestimonialsPerRow; ?>) { padding-right: 0; }
    .testimonial:last-of-type { padding-bottom: 15px; }
}



@media only screen and (min-width: 1200px){ 
     
}
