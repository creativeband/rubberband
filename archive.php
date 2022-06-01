<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rubberband_2022
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="inner">
			<header class="archive-header">
				<h1 class="archive-title"><?php the_archive_title(); ?></h1>
				<p class="archive-description"><?php the_archive_description(); ?></p>
			</header><!-- .page-header -->
				
			<div class="archive-content-wrap">
				<div class="article-loop-area">
					<?php
					/* Start the Loop */
					if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
					
						/*
					 	* Include the Post-Type-specific template for the content.
					 	* If you want to override this in a child theme, then include a file
					 	* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 	*/
				 	get_template_part( 'template-parts/archive/content', get_post_type() );
				 	
				 	endwhile; else :
				 	
				 	get_template_part( 'template-parts/content', 'none' );
				 	
				 	endif;
				 	?>
				</div><!-- .article-loop-area -->
					
				<div class="pagination-area"><?php rubberband_pagination(); ?></div><!-- .pagination-area -->
			</div><!-- .archive-wrap -->
				
			<?php get_sidebar(); ?><!-- #secondary -->
		</div><!-- .inner -->
	</main><!-- #main -->

<?php
get_footer();
