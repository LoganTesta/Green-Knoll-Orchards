
<?php

header ( "Content-type: text/css; charset: UTF-8" );

require ( '../../../../../wp-load.php' );
include ( plugin_dir_path(__FILE__) . "/website-products.php" );


$numberOfProductsPerRow = (int)( get_option( 'website-products-products-per-row' ) );
if ( $numberOfProductsPerRow <= 0 ) {
    $numberOfProductsPerRow = 2;
}
$productWidth = 100/$numberOfProductsPerRow;


$productImageWidthHeight = (int)( get_option( 'website-products-image-width-height' ) );
if ( $productImageWidthHeight <= 0 ) {
    $productImageWidthHeight = 150;
} elseif ( 0 < $productImageWidthHeight && $productImageWidthHeight < 60 ) {
    $productImageWidthHeight = 60;
} elseif ( $productImageWidthHeight > 150 ) {
    $productImageWidthHeight = 150;
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

.product { padding-bottom: 40px; }
.product__image { display: block; width: <?php echo $productImageWidthHeight; ?>px; height: <?php echo $productImageWidthHeight; ?>px; margin-bottom: 15px; margin-left: auto; margin-right: auto; border-radius: <?php echo get_option( 'website-products-border-radius' ); ?>px; }
.product__title { }
.product__content { padding-bottom: 5px; }
.product__provided-name { font-size: 17px; font-weight: bold; }
.product__label { font-size: 17px; font-style: italic; }

.product:last-of-type { padding-bottom: 0; }
.products-container__inner-wrapper::after { content: ""; display: block; clear: both; }
.product__link { font-size: 17px; font-weight: bold; }



@media only screen and (min-width: 700px){
    .product { float: left; width: <?php echo $productWidth; ?>%; padding: 0 20px 15px 20px; }
    
    .product__image { float: <?php echo $websiteProductsFloatImageDirection; ?>; margin-left: <?php echo $websiteProductsImageTabletPlusMarginLeft; ?>; margin-right: <?php echo $websiteProductsImageTabletPlusMarginRight; ?>; }
    
    .product:nth-of-type(<?php echo $numberOfProductsPerRow; ?>n+1) { padding-left: 0; }
    .product:nth-of-type(<?php echo $numberOfProductsPerRow; ?>n+<?php echo $numberOfProductsPerRow; ?>) { padding-right: 0; }
    .product:last-of-type { padding-bottom: 15px; }
}



@media only screen and (min-width: 1200px){ 
     
}
