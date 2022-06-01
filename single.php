<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Rubberband_2022
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="inner">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'template-parts/single/content', get_post_type() ); ?>
			
			<?php endwhile; else : ?>
				
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
				
			<?php endif; ?>
		</div><!-- .inner -->
	</main><!-- #main -->

<?php
get_footer();
