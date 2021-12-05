
<?php

header ( "Content-type: text/css; charset: UTF-8" );

require ( '../../../../../wp-load.php' );
include ( plugin_dir_path(__FILE__) . "/simple-events.php" );


$numberOfEventsPerRow = (int)( get_option( 'simple-events-events-per-row' ) );
$eventWidthTablet = 50;

if ( $numberOfEventsPerRow <= 0 ) {
    $numberOfEventsPerRow = 1;
}
if ( $numberOfEventsPerRow < 2) {
    $eventWidthTablet = 100;
}
$eventWidthDesktop = 100/$numberOfEventsPerRow;


$eventImageWidthHeight = (int)( get_option( 'simple-events-image-width-height' ) );
if ( $eventImageWidthHeight <= 0 ) {
    $eventImageWidthHeight = 200;
} elseif ( 0 < $eventImageWidthHeight && $eventImageWidthHeight < 80 ) {
    $eventImageWidthHeight = 80;
} elseif ( $eventImageWidthHeight > 400 ) {
    $eventImageWidthHeight = 400;
}

?>

.events-container { }
.events-container:after { content: ""; display: block; clear: both; }
.events-container__heading { padding-bottom: 0; text-align: center; font-size: 22px; font-weight: bold; }
.events-container__inner-wrapper { padding-top: 20px; }

.event { float: left; width: 100%; padding: 0 20px 60px 20px; font-size: 16px; }
.event__background { display: block; width: 100%; height: <?php echo 0.6 * $eventImageWidthHeight; ?>px; margin-left: 0; margin-bottom: 15px; max-width: 100%; border-radius: <?php echo get_option( 'simple-events-border-radius' ); ?>px; }
.event__title { padding-bottom: 12px; font-size: 20px; font-weight: bold; }
.event__name-link { text-decoration: none; }
.event__price { padding-right: 25px; font-size: 18px; font-weight: bold; }
.event__date { display: inline-block; font-size: 18px; font-weight: bold; }
.event__times {  display: inline-block; font-size: 18px; font-style: italic; }
.event__starttime { display: inline-block; }
.event__endtime { display: inline-block; }
.event__label { display: inline-block; font-size: 18px; font-style: italic; }
.event__content { padding-top: 20px; }

.event:last-of-type { padding-bottom: 0; }
.events-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.event__link { font-size: 17px; font-weight: bold; }


/*For index page*/
.events-container.index .event { padding: 0 15px 60px 15px; }

.events-container.index .event__background { position: relative; border-radius: 0; }
.events-container.index .event__background-link { display: block; height: 100%; }
.events-container.index .event__label { position: absolute; top: 15px; right: 10px; padding: 10px 8px; border: 2px solid #333333; background-color: rgba(255, 255, 255, 0.9); font-style: normal; }
.events-container.index  .event__title { padding-bottom: 4px; }
.events-container.index .event__short-description { padding-top: 20px; }


/*Clearing variable width columns */
@media only screen and (max-width: 1199px){   
    .events-container__inner-wrapper > div:nth-child(2n+1){ content: ""; display: block; clear: both; }
}

@media only screen and (min-width: 1200px){
    .events-container__inner-wrapper > div:nth-child(<?php echo $numberOfEventsPerRow; ?>n+1){ content: ""; display: block; clear: both; }
}



@media only screen and (min-width: 500px){ 
    .event__background { height: <?php echo 0.8 * $eventImageWidthHeight; ?>px; }
}



@media only screen and (min-width: 768px){
    .events-container__heading { font-size: 24px; }

    .event { width: <?php echo $eventWidthTablet; ?>%; }   
    .event__background { height: <?php echo 0.95 * $eventImageWidthHeight; ?>px; }
    
    .event:last-of-type { padding-bottom: 15px; }
}



@media only screen and (min-width: 1200px){ 
    .events-container__heading { font-size: 28px; }

    .event { width: <?php echo $eventWidthDesktop; ?>%; padding-bottom: 60px; }
    .event__background { height: <?php echo $eventImageWidthHeight; ?>px; }
    .event__title { font-size: 24px; }
    
    
    /*For index page*/
    .events-container.index .event { padding-bottom: 0; }
    
    .events-container.index .event__label { font-size: 24px; }
}



@media only screen and (min-width: 1500px){ 
    .event__background { height: <?php echo $eventImageWidthHeight; ?>px; }
}
