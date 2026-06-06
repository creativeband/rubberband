<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rubberband_2022
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rubberband' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<div class="inner">
				<?php if ( is_front_page() || is_home() ) { ?>
					<h1 class="site-title"><?php the_custom_logo(); ?></h1>
				<?php } else { ?>
					<p class="site-title"><?php the_custom_logo(); ?></p>
				<?php } ?>
			</div><!-- .inner -->
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div class="inner">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</div><!-- .inner -->
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
		
	<?php get_template_part( 'template-parts/common/menu' ); ?>
	
	<?php get_template_part( 'template-parts/common/search' ); ?>
