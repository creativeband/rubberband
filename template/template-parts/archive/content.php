<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rubberband_2022
 */
 $featured = wp_get_attachment_image_src(  get_post_thumbnail_id( $post->ID ), 'full-size' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-thumbnail" style="background-image: url('<?php echo $featured[0]; ?>');">
		<a href="<?php the_permalink(); ?>" rel="bookmark"></a>
		<div class="entry-thumbnail-fitler"></div>
	</div><!-- .entry-thumbnail -->
	<div class="entry-meta">
		<h2 class="entry-title"><a href="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php if(has_excerpt()) { the_excerpt(); } ?>
		<span class="entry-date"><?php the_time('Y-m-d'); ?></span> 
		<span class="by">by</span> 
		<span class="entry-author"><?php the_author_posts_link(); ?></span>
	</div><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
