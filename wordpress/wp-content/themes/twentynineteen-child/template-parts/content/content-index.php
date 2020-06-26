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

	<?php twentynineteen_post_thumbnail(); ?>

	<div class="entry-content">
            <div class="content-row">
                <div class="col-sma-12">
                    <div class="page-additional-image left"></div> 
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
                </div>
            </div>
            <div class="content-row">
                <div class="col-sma-12">
                    <h2>Delicious Local Fruits</h2>
                </div>
                <div class="index-product zero col-vsm-6 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Cherries</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product one col-vsm-6 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Plums</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product two col-vsm-6 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Apples</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
                <div class="index-product three col-vsm-6 col-sma-4 col-lar-3">
                    <div class="index-product__title"><a class="index-product__title-link" href="the-orchard">Pears</a></div>
                    <div class="index-product__background"><a class="index-product__background-link" href="the-orchard"><span class="sr-only">The Orchard Link</span></a></div>
                    <div class="index-product__description"></div>
                </div>
            </div>
            <div class="content-row testimonials">
                <div class="col-sma-12">
                    <h2>Testimonials</h2>
                </div>
                <div class="col-sma-4 testimonial zero">
                    <h3>I go here every week in the spring and fall for fresh fruit!</h3>
                    I go here everyday in the spring and summer. They always have the best cherries and pears and apples. I frequently use the apples in pies I make too. The staff is real friendly and they always make everyone feel at home!

                    -Amanda, A Happy Regular Customer

                </div>
                <div class="col-sma-4 testimonial one">
                    <h3>Great Pears</h3>
                    A couple of friends and I like to pick out apples and pears here every fall for baking. It's a fun tradition my friends and I do and then we go bake things.

                    -Katie, A Happy Regular Customer

                </div>
                <div class="col-sma-4 testimonial two">
                    <h3>Just Found Out About This Farm</h3>
                    Look no further for fresh local fruit! I just found out about this farm two months ago and am going back again this weekend to get more fruit from them.  Highly recommend paying them a visit.

                    -Robert, A Happy New Customer

                </div>
            </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php twentynineteen_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
