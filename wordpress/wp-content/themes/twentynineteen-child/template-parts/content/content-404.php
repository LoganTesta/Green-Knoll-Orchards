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

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry testing" ); ?>>
	<header class="entry-header error-404">

		<?php

                if ( is_404() ){
                    echo '<h1 class="entry-title">Error 404</h1>';
                }

		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
            <div class="content-row">
                <div class="col-sma-12">
                    <?php _e('<p>There appears to be a broken link.  Please try one of the links in the navbar to continue enjoying our site.</p>'); ?>
                </div>
            </div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php twentynineteen_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
