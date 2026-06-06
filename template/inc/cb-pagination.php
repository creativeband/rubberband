<?php
/**
 * rubberband Pagination
 *
 * CB-04. 기존 rubberband paginate_links() 방식을 유지.
 *
 * rubberband_pagination()      : 아카이브/검색용 숫자 페이지네이션
 * rubberband_post_navigation() : 단일 포스트 이전/다음
 *
 * 사용 예시:
 *   archive.php → rubberband_pagination();
 *   single.php  → rubberband_post_navigation();
 *
 * @package rubberband
 */

function rubberband_pagination() {
	global $wp_query;
	$big = 999999999;

	$links = paginate_links(
		array(
			'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total'   => $wp_query->max_num_pages,
			'prev_text' => esc_html__( '이전', 'rubberband' ),
			'next_text' => esc_html__( '다음', 'rubberband' ),
		)
	);

	if ( $links ) {
		echo '<nav class="pagination" aria-label="' . esc_attr__( '페이지 이동', 'rubberband' ) . '">';
		echo $links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</nav>';
	}
}

function rubberband_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span class="nav-subtitle">' . esc_html__( '이전 글', 'rubberband' ) . '</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-subtitle">' . esc_html__( '다음 글', 'rubberband' ) . '</span> <span class="nav-title">%title</span>',
		)
	);
}
