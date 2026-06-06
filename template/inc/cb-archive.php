<?php
/**
 * rubberband Archive Title
 *
 * CB-02. 기존 rubberband에서 가져온 코드.
 * get_the_archive_title()의 "Category:", "Tag:" 등 접두어를 제거.
 *
 * @package rubberband
 */

add_filter( 'get_the_archive_title', function( $title ) {

	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'rubberband' ) );
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'rubberband' ) );
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'rubberband' ) );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} else {
		$title = esc_html__( 'Archives', 'rubberband' );
	}

	return $title;
} );
