<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Rubberband_2022
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="inner">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'rubberband' ); ?></h1>
				</header><!-- .page-header -->
	
				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'rubberband' ); ?></p>
	
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div><!-- .inner -->
	</main><!-- #main -->

<?php
get_footer();
