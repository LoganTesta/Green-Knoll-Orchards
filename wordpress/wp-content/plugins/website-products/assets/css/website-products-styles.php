
<?php

header ( "Content-type: text/css; charset: UTF-8" );

require ( '../../../../../wp-load.php' );
include ( plugin_dir_path(__FILE__) . "/website-products.php" );


$numberOfProductsPerRow = (int)( get_option( 'website-products-products-per-row' ) );
if ( $numberOfProductsPerRow <= 0 ) {
    $numberOfProductsPerRow = 2;
}
$productWidthTablet = 100;
if($numberOfProductsPerRow >= 4) {
    $productWidthTablet = (100/$numberOfProductsPerRow) * 2;
} else {
    $productWidthTablet = 100/$numberOfProductsPerRow;
}
$productWidthDesktop = 100/$numberOfProductsPerRow;


$productImageWidthHeight = (int)( get_option( 'website-products-image-width-height' ) );
if ( $productImageWidthHeight <= 0 ) {
    $productImageWidthHeight = 200;
} elseif ( 0 < $productImageWidthHeight && $productImageWidthHeight < 80 ) {
    $productImageWidthHeight = 80;
} elseif ( $productImageWidthHeight > 400 ) {
    $productImageWidthHeight = 400;
}


$websiteProductsFloatImageDirection = get_option ( 'website-products-float-image-direction' );
if ( $websiteProductsFloatImageDirection === "" || $websiteProductsFloatImageDirection !== "right" ) {
    $websiteProductsFloatImageDirection = "left";
}

$websiteProductsImageTabletPlusMarginLeft = "0";
$websiteProductsImageTabletPlusMarginRight = "15px";

if ( $websiteProductsFloatImageDirection === "left" ) {
    $websiteProductsImageTabletPlusMarginLeft = "0";
    $websiteProductsImageTabletPlusMarginRight = "15px";    
} elseif ( $websiteProductsFloatImageDirection === "right" ){
    $websiteProductsImageTabletPlusMarginLeft = "5px";
    $websiteProductsImageTabletPlusMarginRight = "0";    
}

?>

.products-container__heading { padding-bottom: 0; text-align: center; }
.products-container__inner-wrapper { padding-top: 30px; }

.product { float: left; width: 50%; padding: 0 20px 15px 20px;  }
.product__image { display: block; float: <?php echo $websiteProductsFloatImageDirection; ?>; width: 100%; height: <?php echo 0.6 * $productImageWidthHeight; ?>px; margin-bottom: 15px; margin-left: <?php echo $websiteProductsImageTabletPlusMarginLeft; ?>; margin-right: <?php echo $websiteProductsImageTabletPlusMarginRight; ?>; max-width: 100%; border-radius: <?php echo get_option( 'website-products-border-radius' ); ?>px; }
.product__title { padding-bottom: 4px; }
.product__content { padding-bottom: 5px; }
.product__price { display: inline-block; padding-right: 25px; font-size: 18px; font-weight: bold; }
.product__label { display: inline-block; font-size: 18px; font-style: italic; }

.product:last-of-type { padding-bottom: 0; }
.products-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.product__link { font-size: 17px; font-weight: bold; }



@media only screen and (max-width: 1199px){   
    .products-container__inner-wrapper > div:nth-child(2n+1){ content: ""; display: block; clear: both; }
}



@media only screen and (min-width: 1200px){   
    .products-container__inner-wrapper > div:nth-child(<?php echo $numberOfProductsPerRow; ?>n+1){ content: ""; display: block; clear: both; }
}



@media only screen and (min-width: 500px){ 
     .product__image { height: <?php echo 0.8 * $productImageWidthHeight; ?>px; }
}



@media only screen and (min-width: 768px){
    .product { <?php echo $productWidthTablet; ?> }   
    .product__image { height: <?php echo $productImageWidthHeight; ?>px;  }
    
    .product:last-of-type { padding-bottom: 15px; }
}



@media only screen and (min-width: 1200px){ 
     .product { width: <?php echo $productWidthDesktop; ?>%; }
     .product__image { height: <?php echo 0.8 * $productImageWidthHeight; ?>px; }
}



@media only screen and (min-width: 1500px){ 
     .product__image { height: <?php echo $productImageWidthHeight; ?>px; }
}
