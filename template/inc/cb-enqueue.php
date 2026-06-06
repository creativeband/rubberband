<?php
/**
 * rubberband Scripts & Styles
 *
 * @package rubberband
 */

function rubberband_scripts() {

	wp_enqueue_style(
		'rubberband-style',
		get_stylesheet_uri(),
		array(),
		RUBBERBAND_VERSION
	);
	wp_style_add_data( 'rubberband-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'rubberband-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		RUBBERBAND_VERSION,
		true
	);

	wp_enqueue_script(
		'rubberband-creativeband',
		get_template_directory_uri() . '/js/creativeband.js',
		array(),
		RUBBERBAND_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rubberband_scripts' );
