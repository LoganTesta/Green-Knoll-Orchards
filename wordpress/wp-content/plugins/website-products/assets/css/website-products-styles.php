<?php

header( "Content-type: text/css; charset: UTF-8" );

require( '../../../../../wp-load.php' );
include( plugin_dir_path(__FILE__) . "/website-products.php" );


$numberOfProductsPerRow = ( int )( get_option( 'website-products-products-per-row' ) );
if ( $numberOfProductsPerRow <= 0 ) {
    $numberOfProductsPerRow = 2;
}
$productWidthDesktop = 100/$numberOfProductsPerRow;


$numberOfProductsProductsPagePerRow = ( int )( get_option( 'website-products-products-page-products-per-row' ) );
if ( $numberOfProductsProductsPagePerRow <= 0 ) {
    $numberOfProductsProductsPagePerRow = 2;
}
$productWidthProductsPageDesktop = 100/$numberOfProductsProductsPagePerRow;


$productImageWidthHeight = ( int )( get_option( 'website-products-image-width-height' ) );
if ( $productImageWidthHeight <= 0 ) {
    $productImageWidthHeight = 200;
} elseif ( 0 < $productImageWidthHeight && $productImageWidthHeight < 80 ) {
    $productImageWidthHeight = 80;
} elseif ( $productImageWidthHeight > 400 ) {
    $productImageWidthHeight = 400;
}

?>

.products-container { }
.products-container:after { content: ""; display: block; clear: both; }
.products-container__heading { padding-bottom: 0; text-align: center; font-size: 20px; font-weight: bold; }
.products-container__inner-wrapper { padding-top: 20px; }

.product { float: left; width: 50%; padding: 0 20px 15px 20px; }
.product__background { display: block; width: 100%; height: <?php echo 0.6 * $productImageWidthHeight; ?>px; margin-left: 0; margin-bottom: 15px; max-width: 100%; border-radius: <?php echo get_option( 'website-products-border-radius' ); ?>px; }
.product__background-link { display: block; height: 100%; }
.product__title { }
.product__title-link { }
.product__content { padding-bottom: 5px; }
.product__price { display: inline-block; padding-right: 25px; font-size: 18px; font-weight: bold; }
.product__label { display: inline-block; font-size: 18px; font-style: italic; }

.product:last-of-type { padding-bottom: 0; }
.products-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.product__link { font-size: 17px; font-weight: bold; }


/*For index page*/
.products-container.index .product { padding: 0 15px 50px 15px; }

.products-container.index .product__background { margin-bottom: 0; border-radius: 0; }
.products-container.index .product__background-link { display: block; height: 100%; }


/*For individual product pages*/
.website-products-breadcrumbs__breadcrumb { padding-bottom: 20px; }
.website-products-breadcrumbs__breadcrumb-link { display: inline-block; }



/*Clearing variable width columns */
@media only screen and (max-width: 1199px){   
    .products-container__inner-wrapper > div:nth-child(2n+1){ content: ""; display: block; clear: both; }
}

@media only screen and (min-width: 1200px){
    .products-container.index .products-container__inner-wrapper > div:nth-child(<?php echo $numberOfProductsPerRow; ?>n+1){ content: ""; display: block; clear: both; }
    
    .products-container.products-page .products-container__inner-wrapper > div:nth-child(<?php echo $numberOfProductsProductsPagePerRow; ?>n+1){ content: ""; display: block; clear: both; }
}



@media only screen and (min-width: 500px){ 
    .product__background { height: <?php echo 0.8 * $productImageWidthHeight; ?>px; }
}



@media only screen and (min-width: 768px){
    .products-container__heading { font-size: 24px; }
    .products-container__inner-wrapper { margin-left: -15px; margin-right: 15px; }

    .product { }   
    .product__background { height: <?php echo $productImageWidthHeight; ?>px; }
    
    .product:last-of-type { padding-bottom: 15px; }  
}



@media only screen and (min-width: 1200px){ 
    .products-container__heading { font-size: 28px; }

    .product { width: <?php echo $productWidthDesktop; ?>%; }
    .products-container.products-page .product { width: <?php echo $productWidthProductsPageDesktop; ?>%; }
    .product__background { height: <?php echo 0.8 * $productImageWidthHeight; ?>px; }
    
    
    /*For index page*/
    .products-container.index .product { padding-bottom: 0; }
}



@media only screen and (min-width: 1500px){ 
    .product__background { height: <?php echo $productImageWidthHeight; ?>px; }
}
