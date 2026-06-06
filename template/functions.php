<?php
/**
 * rubberband functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rubberband
 */

if ( ! defined( 'RUBBERBAND_VERSION' ) ) {
	define( 'RUBBERBAND_VERSION', '1.0.0' );
}

/**
 * ── _s 원본 inc ──────────────────────────────────────────────────────────────
 * 직접 수정하지 않는다.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * ── rubberband (Creative Band) ───────────────────────────────────────────────
 * cb- 접두사 파일. 프로젝트 생성 후 이 파일들을 주로 편집한다.
 */
require get_template_directory() . '/inc/cb-setup.php';
require get_template_directory() . '/inc/cb-enqueue.php';
require get_template_directory() . '/inc/cb-menus.php';
require get_template_directory() . '/inc/cb-archive.php';
require get_template_directory() . '/inc/cb-pagination.php';
require get_template_directory() . '/inc/cb-dashboard.php';

/**
 * ── 프로젝트별 추가 (필요에 따라 주석 해제) ─────────────────────────────────
 */
// require get_template_directory() . '/inc/cb-cpt.php';
// require get_template_directory() . '/inc/cb-taxonomy.php';
// require get_template_directory() . '/inc/cb-metabox.php';
