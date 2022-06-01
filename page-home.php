<?php
/**
 * Template name: Homepage
 *
 * This is the template that displays Homepage template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rubberband_2022
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="inner">
			<?php
			while ( have_posts() ) :
				the_post();
				
				setPostViews(get_the_ID());
	
				get_template_part( 'template-parts/content', 'page' );
	
				// If comments are open or we have at least one comment, load up the comment template.
				// if ( comments_open() || get_comments_number() ) :
				// 	comments_template();
				// endif;
	
			endwhile; // End of the loop.
			?>
		</div><!-- .inner -->
	</main><!-- #main -->

<?php
get_footer();
