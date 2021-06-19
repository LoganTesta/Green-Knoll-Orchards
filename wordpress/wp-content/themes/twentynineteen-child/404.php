





<?php

/*Template Name: General page custom template
 Description: the customized generic page layout for this site. */

get_header();
?>

	<div id="primary" class="content-area <?php echo strtolower(get_the_title()); ?>">
		<main id="main" class="site-main">

			<?php

				get_template_part( 'template-parts/content/content-404', 'page-404' );

			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
