<?php
/**
 * Rubberband 2022 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rubberband_2022
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rubberband_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Rubberband 2022, use a find and replace
		* to change 'rubberband' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rubberband', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary', 'rubberband' ),
			'footer-menu' => esc_html__( 'Footer Navigation', 'rubberband' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'rubberband_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'rubberband_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rubberband_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rubberband_content_width', 640 );
}
add_action( 'after_setup_theme', 'rubberband_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rubberband_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rubberband' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rubberband' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'rubberband_widgets_init' );

/*************************************
	Cb-00. Remove Head Link (RSD, Manifest)
*************************************/
function rubberband_removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'rubberband_removeHeadLinks');


/*************************************
	CB-01. Add Page Excerpt
*************************************/
add_post_type_support( 'page', 'excerpt' );

/*************************************
	CB-02. Archive Title
*************************************/
add_filter('get_the_archive_title', function ($title) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} else {
		$title = __( 'Archives' );
	}
	return $title;
});

/*************************************
	CB-03. Custom Default Error Page
*************************************/
add_filter('wp_die_handler', 'get_custom_die_handler' );

function get_custom_die_handler() {
	return 'custom_die_handler';
}
function custom_die_handler( $message, $title="", $args = array() ) {
	require_once get_stylesheet_directory() . '/404.php';
}

/*************************************
	CB-04. CB Pagination
*************************************/
function rubberband_pagination() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	) );
}

/************************************************
	CB-05. Add featured image directly to REST API
************************************************/
function rubberband_post_featured_image_json( $data, $post, $context ) {
	$featured_image_id = $data->data['featured_media']; // get featured image id
	$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'medium' ); // get url of the original size

	if( $featured_image_url ) {
		$data->data['featured_image_url'] = $featured_image_url[0];
	}

	return $data;
}
add_filter( 'rest_prepare_post', 'rubberband_post_featured_image_json', 10, 3 );

function rubberband_prepare_rest_fi($data, $post, $request){
	$_data = $data->data;

	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnailFull = wp_get_attachment_image_src( $thumbnail_id, 'medium' );

	$_data['fi_full'] = $thumbnailFull[0];
	$data->data = $_data;

	return $data;
}
add_filter('rest_prepare_work', 'rubberband_prepare_rest_fi', 10, 3);

/*************************************
	CB-06. Disable Autocomplete
*************************************/
function rubberband_login_form() {
	echo <<<html
<script>
	document.getElementById( "user_pass" ).autocomplete = "off";
</script>
html;
}

add_action( 'login_form', 'rubberband_login_form' );

/*************************************
	CB-07. Post View Count
*************************************/
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count=='') {
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count=='') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}


/**
 * Enqueue scripts and styles.
 */
function rubberband_scripts() {
	wp_enqueue_style( 'rubberband-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'rubberband-style', 'rtl', 'replace' );

	wp_enqueue_script( 'rubberband-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rubberband_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

