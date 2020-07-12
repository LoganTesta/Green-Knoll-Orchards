<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'twentynineteen' ) );
		}
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
            <div class="content-row index-intro">
                <div class="col-sma-12">
                    <?php $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );                 
                        echo '<div class="index-intro__bg-image" style="background: url(' . $featured_image[0] . ') 0% 0%/cover no-repeat"></div>'; ?>
                    <?php
                    the_content(
                            sprintf(
                                    wp_kses(
                                            /* translators: %s: Post title. Only visible to screen readers. */
                                            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentynineteen' ),
                                            array(
                                                    'span' => array(
                                                            'class' => array(),
                                                    ),
                                            )
                                    ),
                                    get_the_title()
                            )
                    );

                    wp_link_pages(
                            array(
                                    'before' => '<div class="page-links">' . __( 'Pages:', 'twentynineteen' ),
                                    'after'  => '</div>',
                            )
                    );
                    ?>
                    <div class="clear-both"></div>
                </div>
            </div>
            <div class="content-row index-products">
                <div class="col-sma-12">
                    <h2 class="index-products__heading">Delicious Local Fruits</h2>
                </div>
                <div class="index-product zero col-vsm-12 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Cherries</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product one col-vsm-12 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Plums</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product two col-vsm-12 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Apples</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product three col-vsm-12 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Pears</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
            </div>
            <div class="content-row">
                <div class="col-sma-12">
                    <?php echo do_shortcode( "[general_testimonials]" ); ?>
                </div>
            </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php twentynineteen_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
